<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContainerJoinRequest;
use App\Mail\ContainerReservationMail;
use App\Models\Container;
use App\Models\ContainerProduct;
use App\Models\ContainerReservation;
use App\Models\Product;
use App\Services\Admin\CMSManagement\FaqService;
use App\Services\Admin\GroupShipping\ContainerProductService;
use App\Services\Admin\GroupShipping\ContainerService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class GroupShippingPageController extends Controller
{
    protected $faqService;
    protected ContainerService $containerService;
    protected ContainerProductService $containerProductService;
    public function __construct(FaqService $faqService, ContainerService $containerService, ContainerProductService $containerProductService)
    {
        $this->faqService = $faqService;
        $this->containerService = $containerService;
        $this->containerProductService = $containerProductService;
    }


    public function group_shipping()
    {
        // Load active FAQs
        $data['faqs'] = $this->faqService->getFaqs()->active()->get();

        // Load containers with essential relationships
        $data['containers'] = $this->containerService
            ->getContainers('deadline', 'asc')
            ->where('deadline', '>', now())
            ->active()
            ->with(['destinationPort', 'shippingPort', 'containerReservations.product']) // removed 'containerReservations.product' to avoid N+1
            ->get();

        $rawProducts = Product::select('id', 'length_m', 'width_m', 'height_m')
            ->whereNotNull('length_m')
            ->whereNotNull('width_m')
            ->whereNotNull('height_m')
            ->whereNot('product_type', Product::PRODUCT_TYPE_DROPSHIPPING)
            ->inStock()
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'volume' => (float) $product->length_m * (float) $product->width_m * (float) $product->height_m,
                ];
            })
            ->sortBy('volume')
            ->values(); // reindex for speed

        $productToContainers = []; // product_id => [container_id]
        $usedProductIds = [];      // quick lookup for assigned products

        foreach ($data['containers'] as $container) {
            $containerVolume = (float) $container->length_m * (float) $container->width_m * (float) $container->height_m;
            $remainingVolume = $containerVolume;

            foreach ($rawProducts as $product) {
                $productId = $product['id'];

                if (isset($usedProductIds[$productId])) {
                    continue; // skip already assigned
                }

                if ($product['volume'] <= $remainingVolume) {
                    $productToContainers[$productId][] = $container->id;
                    $usedProductIds[$productId] = true;
                    $remainingVolume -= $product['volume'];
                }

                if ($remainingVolume <= 0)
                    break; // no space left
            }
        }

        $matchedProductIds = array_keys($productToContainers);

        $matchedProducts = Product::with(['brand', 'model', 'company', 'primaryImage'])->whereIn('id', $matchedProductIds)->get()->keyBy('id');

        // $containerMatches = [];

        // foreach ($productToContainers as $productId => $containerIds) {
        //     foreach ($containerIds as $containerId) {
        //         $containerMatches[$containerId][] = $matchedProducts[$productId];
        //     }
        // }

        $data['matchedProducts'] = $matchedProducts;



        return view('frontend.pages.group_shipping', $data);
    }
    public function joinGroupShipping(string $container_slug, string $product_slug = null)
    {
        $data['container'] = Container::with(['destinationPort', 'shippingPort', 'containerReservations.product'])->where('slug', $container_slug)->first();
        if ($product_slug) {
            $data['product'] = Product::where('slug', $product_slug)->first();
            $data['container_product'] = ContainerProduct::where('container_id', $data['container']->id)->where('product_id', $data['product']->id)->first();
        }
        $data['products'] = Product::where('status', Product::STATUS_ACTIVE)->orderBy('name')->get();
        return view('frontend.pages.join_group_shipping', $data);
    }

    public function joinRequest(ContainerJoinRequest $request, string $container_slug)
    {
        $container = Container::where('slug', $container_slug)->first();

        $user = user();
        $validated = $request->all();
        $validated += [
            'container_id' => $container->id,
            'user_id' => $user->id,
            'creater_id' => $user->id,
            'creater_type' => get_class($user),
        ];
        $reservation = ContainerReservation::create($validated);
        Mail::to('supperadmin@gmail.com')->send(new ContainerReservationMail($reservation));

        session()->flash('success', 'Join request submitted successfully! We will contact you soon.');
        return redirect()->route('frontend.join-group-shipping', ['container_slug' => $container_slug]);
    }

}
