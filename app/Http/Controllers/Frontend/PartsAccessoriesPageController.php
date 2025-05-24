<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PartsAccessoriesRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartsAccessoriesPageController extends Controller
{
     public function productFilter(PartsAccessoriesRequest $request): RedirectResponse
    {
        $data = [];
        if (!empty($request->input("category"))) {
            $data["category"] = $request->input("category");
        }
        if (!empty(request()->input("start_price"))) {
            $data["start_price"] = $request->input("start_price");
        }
        if (!empty(request()->input("end_price"))) {
            $data["end_price"] = $request->input("end_price");
        }
        return redirect()->route('frontend.parts-accessories', $data);
    }
   public function parts(Request $request)
{
    $query = Product::with(['category', 'company', 'primaryImage'])->parts();

    // Filter by category
    if ($request->filled('category')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('slug', $request->input('category'));
        });
    }

    // Filter by company
    if ($request->filled('company')) {
        $query->whereHas('company', function ($q) use ($request) {
            $q->where('slug', $request->input('company'));
        });
    }

    // Filter by price range
    if ($request->filled('start_price') && $request->filled('end_price')) {
        $query->whereBetween('price', [
            $request->input('start_price'),
            $request->input('end_price')
        ]);
    }
    // Get the filtered products
    $data['products'] = $query->latest()->get();

    // Optional: pass categories for dropdown
    $data['category'] = Category::with('childrens')->where('slug', 'agricultural')->first();

    return view('frontend.pages.parts_accessories', $data);
}

}
