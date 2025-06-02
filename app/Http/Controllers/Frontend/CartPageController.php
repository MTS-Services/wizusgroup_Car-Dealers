<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CartPageController extends Controller
{
    public function cart()
    {
        return view('frontend.pages.cart');
    }
}
