<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContainerJoinRequest;
use App\Mail\ContainerReservationMail;
use App\Models\Container;
use App\Models\ContainerProduct;
use App\Models\ContainerReservation;
use App\Models\Product;
use App\Services\Admin\GroupShipping\ContainerProductService;
use App\Services\Admin\GroupShipping\ContainerService;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{

   
    protected ContainerService $containerService;
    protected ContainerProductService $containerProductService;
    public function __construct( ContainerService $containerService, ContainerProductService $containerProductService)
    {
        
        $this->containerService = $containerService;
        $this->containerProductService = $containerProductService;
    }

    public function about()
    {
        return view('frontend.pages.about');
    }


    public function parts_accessories()
    {
        return view('frontend.pages.parts_accessories');
    }


    public function dropshipping()
    {
        return view('frontend.pages.dropshipping');
    }
    public function regions()
    {
        return view('frontend.pages.regions');
    }
    public function orderForm()
    {
        return view('frontend.pages.order_form');
    }

    public function checkout()
    {
        return view('frontend.pages.checkout');
    }
    public function terms()
    {
        return view('frontend.pages.terms');
    }
    // public function orders()
    // {
    //     return view('frontend.pages.orders');
    // }



    // order page join group shippin cointainer

  

    public function testContainerPage()
    {

        // Load containers with essential relationships
        $data['containers'] = $this->containerService
            ->getContainers('deadline', 'asc')
            ->active()
            ->with(['destinationPort', 'shippingPort', 'containerReservations.product']) // removed 'containerReservations.product' to avoid N+1
            ->get();

        return view('frontend.pages.orders', $data);
    }
    public function joinGroupShipping(string $container_slug, ?string $product_slug = null)
    {
        $data['container'] = Container::with(['destinationPort', 'shippingPort', 'containerReservations.product'])->where('slug', $container_slug)->first();
        if ($product_slug) {
            $data['product'] = Product::where('slug', $product_slug)->first();
            $data['container_product'] = ContainerProduct::where('container_id', $data['container']->id)->where('product_id', $data['product']->id)->first();
        }
        $data['products'] = Product::where('status', Product::STATUS_ACTIVE)->orderBy('name')->get();
        return view('frontend.pages.order_finished', $data);
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

