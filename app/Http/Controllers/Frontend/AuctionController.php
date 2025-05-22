<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Admin\AuctionManagement\AuctionService;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    protected AuctionService $auctionService;
    public function __construct(AuctionService $auctionService)
    {
        $this->auctionService = $auctionService;
    }

    public function auction()
    {
        $data['auctions'] = $this->auctionService->getAuctions()->with(['product.primaryImage', 'product.subCategory'])->open()->latest()->get();
        return view('frontend.pages.auctions', $data);
    }



    public function auctionDetails(string $slug)
    {
        return view('frontend.pages.auction_details');
    }
}
