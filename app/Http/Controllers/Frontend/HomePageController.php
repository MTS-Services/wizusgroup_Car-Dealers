<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\BannerService;
use App\Services\Admin\CMSManagement\FaqService;
use App\Services\Admin\ProductManagement\CategoryService;

class HomePageController extends Controller
{
    protected $categoryService;
    protected $bannerService;
    protected $faqService;
    public function __construct(CategoryService $categoryService, BannerService $bannerService, FaqService $faqService)
    {
        $this->categoryService = $categoryService;
        $this->bannerService = $bannerService;
        $this->faqService = $faqService;
        
    }
    public function home()
    {
        $data['banners'] =$this->bannerService->getBanners()->active()->get();
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->get();
        // $data['faqs'] = $this->faqService->getFaqs()->active()->get();  
        return view('frontend.pages.home',$data);
    }
    
}

