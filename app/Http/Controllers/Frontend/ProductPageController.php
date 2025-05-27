<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProductFilterRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Model;
use App\Models\Product;
use App\Services\Admin\ProductManagement\BrandService;
use App\Services\Admin\ProductManagement\CategoryService;
use App\Services\Admin\ProductManagement\ModelService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{
    protected CategoryService $categoryService;
    protected BrandService $brandService;
    protected ModelService $modelService;

    public function __construct(CategoryService $categoryService, BrandService $brandService, ModelService $modelService)
    {
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->modelService = $modelService;
    }

    public function productFilter(ProductFilterRequest $request, $category_slug = false): RedirectResponse
    {
        $data['category_slug'] = $category_slug;
        if (!empty($request->input("sort"))) {
            $data["sort"] = $request->input("sort");
        }
        if (!empty($request->input("subcategory"))) {
            $data["subcategory"] = $request->input("subcategory");
        }
        if (!empty($request->input("brand"))) {
            $data["brand"] = $request->input("brand");
        }
        if (!empty(request()->input("model"))) {
            $data["model"] = $request->input("model");
        }
        if (!empty(request()->input("year"))) {
            $data["year"] = $request->input("year");
        }
        if (!empty(request()->input("start_price"))) {
            $data["start_price"] = $request->input("start_price");
        }
        if (!empty(request()->input("end_price"))) {
            $data["end_price"] = $request->input("end_price");
        }
        return redirect()->route('frontend.products', $data);
    }
    public function products(Request $request, $category_slug = false): View
    {
        $query = Product::with(['category', 'company', 'brand', 'model', 'primaryImage', 'subCategory'])->active();

        if ($category_slug) {
            $query->whereHas('category', function ($query) use ($category_slug) {
                $query->where('slug', $category_slug);
            });
        }
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
        if ($request->input("subcategory")) {
            $query->whereHas("subCategory", function ($query) use ($request) {
                $query->where("slug", $request->input("subcategory"));
            });
        }
        if ($request->input("brand")) {
            $query->whereHas("brand", function ($query) use ($request) {
                $query->where("slug", $request->input("brand"));
            });
        }
        if ($request->input("model")) {
            $query->whereHas("model", function ($query) use ($request) {
                $query->where("slug", $request->input("model"));
            });
        }
        if ($request->input("year")) {
            $query->where('year', $request->input("year"));
        }
        if ($request->input("start_price") && $request->input("end_price")) {
            $query->whereBetween('price', [$request->input('start_price'), $request->input('end_price')]);
        }
        $data['products'] = $query->get();
        if ($category_slug) {
            $data['category'] = Category::with(['brands', 'models', 'childrens'])->where('slug', $category_slug)->first();
            $data['subcategories'] = $data['category']->childrens;
            $data['brands'] = $data['category']->brands;
            $data['models'] = $data['category']->models;
        } else {
            $data['subcategories'] = $this->categoryService->getCategories()->isSubCategory()->active()->select(['id', 'name', 'slug'])->get();
            $data['brands'] = $this->brandService->getBrands()->active()->select(['id', 'name', 'slug'])->get();
            $data['models'] = $this->modelService->getModels()->active()->select(['id', 'name', 'slug'])->get();
            $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name', 'slug'])->get();

        }
        return view('frontend.pages.products', $data);
    }
    public function productDetails($slug)
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
