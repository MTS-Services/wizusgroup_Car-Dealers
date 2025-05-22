<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AuctionFilterRequest;
use App\Models\Auction;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use App\Services\Admin\AuctionManagement\AuctionService;

class AuctionPageController extends Controller
{

    public function auctionFilter(AuctionFilterRequest $request): RedirectResponse
    {
        $data = [];
        if (!empty($request->input("category"))) {
            $data["category"] = $request->input("category");
        }
        if (!empty($request->input("company"))) {
            $data["company"] = $request->input("company");
        }
        if (!empty($request->input("date"))) {
            $data["date"] = $request->input("date");
        }

        return redirect()->route('frontend.auctions', $data);
    }

    public function auction(Request $request)
    {
        // dd($request->all());
        $query = Auction::with(['product.primaryImage', 'product.subCategory']);
        if ($request->input("category")) {
            $query->whereHas("product.category", function ($query) use ($request) {
                $query->where("slug", $request->input("category"));
            });
        }
        if ($request->input("company")) {
            $query->whereHas("product.company", function ($query) use ($request) {
                $query->where("slug", $request->input("company"));
            });
        }
        if ($request->input("date")) {
            $query->whereDate("end_date", $request->input("date"));
        }
        $data['auctions'] = $query->open()->latest()->get();
        $data['categories'] = Category::orderBy('name', 'asc')->isMainCategory()->active()->get();
        $data['companies'] = Company::orderBy('name', 'asc')->active()->get();
        return view('frontend.pages.auctions', $data);
    }

    public function auctionDetails(string $slug)
    {
        return view('frontend.pages.auction_details');
    }
}
