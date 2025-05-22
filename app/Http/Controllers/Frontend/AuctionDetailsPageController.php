<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuctionDetailsPageController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function auction_details()
    {
        return view('frontend.pages.auction_details');
    }
}
