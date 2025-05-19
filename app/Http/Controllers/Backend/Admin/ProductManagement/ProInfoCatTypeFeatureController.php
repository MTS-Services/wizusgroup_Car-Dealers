<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductManagement\ProductInfoCategoryTypeFeatureService;
use App\Services\Admin\ProductManagement\ProductInfoCategoryTypeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProInfoCatTypeFeatureController extends Controller
{
    protected ProductInfoCategoryTypeFeatureService $proInfoCatTypeFeatureService;
    protected ProductInfoCategoryTypeService $proInfoCatTypeService;

    public function __construct(ProductInfoCategoryTypeFeatureService $proInfoCatTypeFeatureService, ProductInfoCategoryTypeService $proInfoCatTypeService)
    {
        $this->proInfoCatTypeFeatureService = $proInfoCatTypeFeatureService;
        $this->proInfoCatTypeService = $proInfoCatTypeService;

        $this->middleware('auth:admin');
        $this->middleware('permission:product-info-category-type-feature-list', ['only' => ['index']]);
        $this->middleware('permission:product-info-category-type-feature-details', ['only' => ['show']]);
        $this->middleware('permission:product-info-category-type-feature-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-info-category-type-feature-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-info-category-type-feature-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-info-category-type-feature-status', ['only' => ['status']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->proInfoCatTypeFeatureService->getProInfoCatTypeFeatures()->with(['creater_admin','catagoryTypes','infoCategory']);
            return DataTables::eloquent($query)
                 ->editColumn('product_info_cat_id', function ($product_info_cat_type_feature) {
                    return $product_info_cat_type_feature?->infoCategory?->name;
                })
                 ->editColumn('product_info_cat_type_id', function ($product_info_cat_type_feature) {
                    return $product_info_cat_type_feature?->catagoryTypes?->name;
                })
                ->editColumn('status', function ($product_info_cat_type_feature) {
                    return "<span class='badge " . $product_info_cat_type_feature->status_color . "'>$product_info_cat_type_feature->status_label</span>";
                })
                ->editColumn('created_by', function ($product_info_cat_type_feature) {
                    return $product_info_cat_type_feature->creater_name;
                })
                ->editColumn('created_at', function ($product_info_cat_type_feature) {
                    return $product_info_cat_type_feature->created_at_formatted;
                })
                ->editColumn('action', function ($product_info_cat_type_feature) {
                    $menuItems = $this->menuItems($product_info_cat_type_feature);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['company_id','brand_id','status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_info_cat_type_feature.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
