<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProInfoCatTypeFeatureRequest;
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
        $this->middleware('permission:product-info-category-type-feature-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:product-info-category-type-feature-restore', ['only' => ['restore']]);
        $this->middleware('permission:product-info-category-type-feature-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->proInfoCatTypeFeatureService->getProInfoCatTypeFeatures()->with(['creater_admin', 'infoCategory', 'infoCategoryType']);
            return DataTables::eloquent($query)
                ->editColumn('product_info_cat_id', function ($feature) {
                    return $feature?->infoCategory?->name;
                })
                ->editColumn('product_info_cat_type_id', function ($feature) {
                    return $feature?->infoCategoryType?->name;
                })
                ->editColumn('status', function ($feature) {
                    return "<span class='badge " . $feature->status_color . "'>$feature->status_label</span>";
                })
                ->editColumn('created_by', function ($feature) {
                    return $feature->creater_name;
                })
                ->editColumn('created_at', function ($feature) {
                    return $feature->created_at_formatted;
                })
                ->editColumn('action', function ($feature) {
                    $menuItems = $this->menuItems($feature);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['product_info_cat_id', 'product_info_cat_type_id', 'status',  'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_info_category_type_feature.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['product-info-category-type-feature-details']
            ],
            [
                'routeName' => 'pm.pro-info-cat-tf.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-info-category-type-feature-edit']
            ],
            [
                'routeName' => 'pm.pro-info-cat-tf.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-info-category-type-feature-status']
            ],
            [
                'routeName' => 'pm.pro-info-cat-tf.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-info-category-type-feature-delete']
            ]

        ];
    }

     public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->proInfoCatTypeFeatureService->getProInfoCatTypeFeatures()->onlyTrashed()->with(['deleter_admin','infoCategory','infoCategoryType']);
            return DataTables::eloquent($query)
                ->editColumn('product_info_cat_id', function ($feature) {
                    return $feature?->infoCategory?->name;
                })
                ->editColumn('product_info_cat_type_id', function ($feature) {
                    return $feature?->infoCategoryType?->name;
                })
                ->editColumn('status', function ($feature) {
                    return "<span class='badge " . $feature->status_color . "'>$feature->status_label</span>";
                })
                ->editColumn('deleted_by', function ($feature) {
                    return $feature->deleter_name;
                })
                ->editColumn('deleted_at', function ($feature) {
                    return $feature->deleted_at_formatted;
                })
                ->editColumn('action', function ($feature) {
                    $menuItems = $this->trashedMenuItems($feature);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['product_info_cat_id', 'product_info_cat_type_id','status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_info_category_type_feature.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.pro-info-cat-tf.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-info-category-type-feature-restore']
            ],
            [
                'routeName' => 'pm.pro-info-cat-tf.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-info-category-type-feature-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['features'] = $this->proInfoCatTypeFeatureService->getProInfoCatTypeFeatures()->active()->select(['id','name'])->get();
        return view('backend.admin.product_management.product_info_category_type_feature.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProInfoCatTypeFeatureRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->proInfoCatTypeFeatureService->createProInfoCatTypeFeature($validated, $request);
            session()->flash('success', 'Product Info Category Type Feature created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category Type Feature create failed!');
            throw $e;
        }

        return redirect()->route('pm.pro-info-cat-tf.index');
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
