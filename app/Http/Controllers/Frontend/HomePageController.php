<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductManagement\CategoryService;

class HomePageController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        
    }
    public function home()
    {
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->get();
        return view('frontend.pages.home',$data);
    }
    
}

