<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\ContainerProduct;
use App\Models\Product;
use App\Services\Admin\CMSManagement\FaqService;
use App\Services\Admin\GroupShipping\ContainerProductService;
use App\Services\Admin\GroupShipping\ContainerService;
use Illuminate\Http\Request;

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
        $data['containers'] = $this->containerService->getContainers('deadline', 'desc')->active()->with(['destinationPort', 'shippingPort', 'containerProducts.product', 'containerReservations.product'])->get();
        return view('frontend.pages.group_shipping', $data);
    }
    public function joinGroupShipping(string $container_slug, string $product_slug)
    {
        $container = Container::where('slug', $container_slug)->first();
        $product = Product::where('slug', $product_slug)->first();
        $data['container_product'] = ContainerProduct::with(['container', 'product'])->where('container_id', $container->id)->where('product_id', $product->id)->first();
        return view('frontend.pages.join_group_shipping', $data);
    }


}
