<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\FaqService;
use Illuminate\Http\Request;

class GroupShippingPageController extends Controller
{
    protected $faqService;
    public function __construct( FaqService $faqService)
    {
        $this->faqService = $faqService;
        
    }
    public function group_shipping()
    {
        $data['faqs'] = $this->faqService->getFaqs()->active()->get();
        return view('frontend.pages.group_shipping',$data);
    }
}
