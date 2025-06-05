<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\TestimonialService;
use App\Services\Admin\CMSManagement\BannerService;
use App\Services\Admin\GroupShipping\ContainerService;
use App\Services\Admin\ProductManagement\CategoryService;
use App\Services\Admin\ProductManagement\ProductService;

class HomePageController extends Controller
{
    protected CategoryService $categoryService;
    protected BannerService $bannerService;
    protected TestimonialService $testimonialService;
    protected ContainerService $containerService;
    protected ProductService $productService;

    public function __construct(CategoryService $categoryService, BannerService $bannerService, TestimonialService $testimonialService, ContainerService $containerService, ProductService $productService)
    {
        $this->bannerService = $bannerService;
        $this->categoryService = $categoryService;
        $this->testimonialService = $testimonialService;
        $this->containerService = $containerService;
        $this->productService = $productService;
    }
    public function home()
    {
        $data['banners'] = $this->bannerService->getBanners()->active()->get();
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->select(['id', 'name', 'slug', 'image'])->active()->get();
        $data['container'] = $this->containerService->getContainers('deadline', 'asc')->active()->where('deadline', '>', now())->with(['destinationPort', 'shippingPort'])->first();
        $data['testimonials'] = $this->testimonialService->getTestimonials()->active()->get();
        $data['featured_products'] = $this->productService->getProducts()
            ->active()->featured()
            ->with(['company', 'brand', 'model', 'primaryImage'])->latest()->get();

        return view('frontend.pages.home', $data);
    }
}
