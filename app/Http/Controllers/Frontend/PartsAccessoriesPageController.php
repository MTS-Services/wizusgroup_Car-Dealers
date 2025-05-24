<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PartsAccessoriesPageController extends Controller
{
    public function parts(Request $request)
    {
        
        $data['products'] = Product::with(['category', 'company',  'primaryImage'])->parts()->latest()->get();
        return view('frontend.pages.parts_accessories', $data);
    }
}
