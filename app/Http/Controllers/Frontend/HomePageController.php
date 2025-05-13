<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function home()
    {
        return view('frontend.pages.home',);
    }
}
