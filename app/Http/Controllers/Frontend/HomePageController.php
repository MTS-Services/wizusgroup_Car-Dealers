<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\TestimonialService;
use App\Services\Admin\ProductManagement\CategoryService;

class HomePageController extends Controller
{
    protected $categoryService;
    protected TestimonialService $testimonialService;

    public function __construct(CategoryService $categoryService, TestimonialService $testimonialService)
    {
        $this->categoryService = $categoryService;
        $this->testimonialService = $testimonialService;

    }
    public function home()
    {
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->get();
        $data['testimonials'] = $this->testimonialService->getTestimonials()->active()->get();
        return view('frontend.pages.home',$data);
    }

}

