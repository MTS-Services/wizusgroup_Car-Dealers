<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartsAccessoriesController extends Controller
{
    public function parts(Request $request)
    {
        $query = Auction::all();

        $data['auctions'] = $query->open()->get();
        $data['categories'] = Category::orderBy('name', 'asc')->isMainCategory()->active()->get();
        $data['companies'] = Company::orderBy('name', 'asc')->active()->get();
        return view('frontend.pages.auctions', $data);
    }
    

}
