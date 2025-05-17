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
    public function dropshipping()
    {
        return view('frontend.pages.dropshipping');
    }
    public function regions()
    {
        return view('frontend.pages.regions');
    }
}
