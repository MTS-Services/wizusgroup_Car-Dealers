<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
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
    public function orders()
    {
        return view('frontend.pages.orders');
    }
}
