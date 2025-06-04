<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\PartsAccessoriesRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartsAccessoriesPageController extends Controller
{
    public function productFilter(PartsAccessoriesRequest $request): RedirectResponse
    {
        $data = [];
        if (!empty($request->input("sort"))) {
            $data["sort"] = $request->input("sort");
        }
        if (!empty($request->input("category"))) {
            $data["category"] = $request->input("category");
        }
        if (!empty($request->input("company"))) {
            $data["company"] = $request->input("company");
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
        $query = Product::with(['category', 'company', 'brand', 'model', 'primaryImage', 'subCategory'])->active()->parts();

        if ($request->input("sort")) {
            if ($request->input("sort") == "high_to_low") {
                $query->orderBy('price', 'asc');
            }
            if ($request->input("sort") == "low_to_high") {
                $query->orderBy('price', 'desc');
            }
            if ($request->input("sort") == "latest") {
                $query->latest();
            }
            if ($request->input("sort") == "oldest") {
                $query->oldest();
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        // Filter by company
        if ($request->input("company")) {
            $query->whereHas("company", function ($query) use ($request) {
                $query->where("slug", $request->input("company"));
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

        $data['companies'] = Company::orderBy('name', 'asc')->active()->get();
        // Optional: pass categories for dropdown
        $data['categories'] = Category::isMainCategory()->active()->latest()->get();

        return view('frontend.pages.parts_accessories', $data);
    }

    public function partsDetails($slug)
    {
        $data['product'] = Product::with([
            'category.products.primaryImage',
            'category.products.brand',
            'category.products.model',
            'subCategory',
            'company',
            'brand',
            'model',
            'images',
            'productInformations.infoCategory',
            'productInformations.infoCategoryType',
            'productInformations.infoCategoryTypeFeature',
        ])->where('slug', $slug)->first();
        $data['groupedInfo'] = $data['product']->productInformations->groupBy('infoCategory.name');
        $data['related_products'] = $data['product']->category->products->where('id', '!=', $data['product']->id)->values();
        return view('frontend.pages.product_details', $data);
    }
}
