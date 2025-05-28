<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Container;
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
        $data['containers'] = $this->containerService->getContainers()->active()->with(['destinationPort', 'shippingPort' ])->get();
        $data['container_produts'] = $this->containerProductService->getContainerProducts()->with(['product', 'container'])->get();
        return view('frontend.pages.group_shipping', $data);
    }
    public function joinGroupShipping(string $id)
    {
        $data['container'] =$this->containerService->getContainers()->with(['destinationPort', 'shippingPort'])->findOrFail($id);
        return view('frontend.pages.join_group_shipping', $data);
    }


}
