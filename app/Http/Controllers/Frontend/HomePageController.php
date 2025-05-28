<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\TestimonialService;
use App\Services\Admin\CMSManagement\BannerService;
use App\Services\Admin\GroupShipping\ContainerService;
use App\Services\Admin\ProductManagement\CategoryService;

class HomePageController extends Controller
{
    protected CategoryService $categoryService;
    protected BannerService $bannerService;
    protected TestimonialService $testimonialService;
    protected ContainerService $containerService;

    public function __construct(CategoryService $categoryService, BannerService $bannerService, TestimonialService $testimonialService, ContainerService $containerService)
    {
        $this->bannerService = $bannerService;
        $this->categoryService = $categoryService;
        $this->testimonialService = $testimonialService;
        $this->containerService = $containerService;
    }
    public function home()
    {
        $data['banners'] = $this->bannerService->getBanners()->active()->get();
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->select(['id', 'name', 'slug'])->active()->get();
        $data['container'] = $this->containerService->getContainers('deadline', 'desc')->active()->with(['destinationPort', 'shippingPort'])->first();
        $data['testimonials'] = $this->testimonialService->getTestimonials()->active()->get();
        return view('frontend.pages.home', $data);
    }
}
