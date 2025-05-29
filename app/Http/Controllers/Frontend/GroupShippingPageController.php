<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContainerJoinRequest;
use App\Mail\ContainerReservationMail;
use App\Models\Container;
use App\Models\ContainerReservation;
use App\Models\Product;
use App\Services\Admin\CMSManagement\FaqService;
use App\Services\Admin\GroupShipping\ContainerProductService;
use App\Services\Admin\GroupShipping\ContainerService;
use Illuminate\Support\Facades\Mail;

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
        $data['faqs'] = $this->faqService->getFaqs()->active()->get();
        $data['containers'] = $this->containerService->getContainers('deadline', 'asc')->active()->with(['destinationPort', 'shippingPort', 'containerProducts.product.primaryImage', 'containerReservations.product'])->get();
        return view('frontend.pages.group_shipping', $data);
    }
    public function joinGroupShipping(string $container_slug, string $product_slug)
    {
        $data['product'] = Product::where('slug', $product_slug)->first();
        $data['container'] = Container::with(['destinationPort', 'shippingPort', 'containerProducts.product.primaryImage', 'containerReservations.product'])->where('slug', $container_slug)->first();
        $data['container_product'] = $data['container']->containerProducts()->where('product_id', $data['product']->id)->first();
        return view('frontend.pages.join_group_shipping', $data);
    }

    public function joinRequest(ContainerJoinRequest $request, string $container_slug, string $product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();
        $container = Container::where('slug', $container_slug)->first();
        $validated = $request->validated();
        $user = user();
        $validated += [
            'container_id' => $container->id,
            'product_id' => $product->id,
            'user_id' => $user->id,
            'creater_id' => $user->id,
            'creater_type' => get_class($user),
        ];
        $reservation = ContainerReservation::create($validated);

        Mail::to('supperadmin@gmail.com')->send(new ContainerReservationMail($reservation));
        
        session()->flash('success', 'Join request submitted successfully! We will contact you soon.');
        return redirect()->route('frontend.join-group-shipping', ['container_slug' => $container_slug, 'product_slug' => $product_slug]);
    }

}
