<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Company;
use App\Services\Admin\AuctionManagement\AuctionService;

class AuctionPageController extends Controller
{
    public function auction()
    {
        $data['categories'] = Category::orderBy('name', 'asc')->isMainCategory()->active()->get();
        $data['companies'] = Company::orderBy('name', 'asc')->active()->get();
        $data['auctions'] = Auction::with(['product.primaryImage', 'product.subCategory'])->open()->latest()->get();
        return view('frontend.pages.auctions', $data);
    }

    public function auctionDetails(string $slug)
    {
        return view('frontend.pages.auction_details');
    }
}
