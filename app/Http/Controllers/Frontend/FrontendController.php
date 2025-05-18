<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.pages.home');
    }
    public function about()
    {
        return view('frontend.pages.about');
    }
    public function product()
    {
        return view('frontend.pages.products');
    }
    public function contact()
    {
        return view('frontend.pages.contact');
    }
    public function auction()
    {
        return view('frontend.pages.auctions');
    }
    public function parts_accessories()
    {
        return view('frontend.pages.parts_accessories');
    }
    public function product_details()
    {
        return view('frontend.pages.product_details');
    }
    public function group_shipping()
    {
        return view('frontend.pages.group_shipping');
    }
    public function dropshipping()
    {
        return view('frontend.pages.dropshipping');
    }
    public function regions()
    {
        return view('frontend.pages.regions');
    }
}
