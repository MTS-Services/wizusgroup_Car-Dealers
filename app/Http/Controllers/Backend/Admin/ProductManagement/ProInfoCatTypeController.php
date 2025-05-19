<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProInfoCatTypeRequest;
use App\Services\Admin\ProductManagement\ProductInfoCategoryService;
use App\Services\Admin\ProductManagement\ProductInfoCategoryTypeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProInfoCatTypeController extends Controller
{
    protected ProductInfoCategoryTypeService $proInfoCatTypeService;
    protected ProductInfoCategoryService $ProductInfoCatService;
    public function __construct(ProductInfoCategoryTypeService $proInfoCatTypeService, ProductInfoCategoryService $ProductInfoCatService)
    {
        $this->proInfoCatTypeService = $proInfoCatTypeService;
        $this->ProductInfoCatService = $ProductInfoCatService;


        $this->middleware('auth:admin');
        $this->middleware('permission:product-info-category-type-list', ['only' => ['index']]);
        $this->middleware('permission:product-info-category-type-details', ['only' => ['show']]);
        $this->middleware('permission:product-info-category-type-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-info-category-type-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-info-category-type-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-info-category-type-status', ['only' => ['status']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->proInfoCatTypeService->getProInfoCatTypes()->with(['creater_admin', 'infoCategory']);
            return DataTables::eloquent($query)
                ->editColumn('product_info_cat_id', function ($product_info_category_type) {
                    return $product_info_category_type?->infoCategory?->name;
                })
                ->editColumn('status', function ($product_info_category_type) {
                    return "<span class='badge " . $product_info_category_type->status_color . "'>$product_info_category_type->status_label</span>";
                })
                ->editColumn('created_by', function ($product_info_category_type) {
                    return $product_info_category_type->creater_name;
                })
                ->editColumn('created_at', function ($product_info_category_type) {
                    return $product_info_category_type->created_at_formatted;
                })
                ->editColumn('action', function ($product_info_category_type) {
                    $menuItems = $this->menuItems($product_info_category_type);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['product_info_cat_id', 'status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.pro_info_cat_type.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['product-info-category-type-details']
            ],
            [
                'routeName' => 'pm.product-info-category-type.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-info-category-type-edit']
            ],
            [
                'routeName' => 'pm.product-info-category-type.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-info-category-type-status']
            ],
            [
                'routeName' => 'pm.product-info-category-type.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-info-category-type-delete']
            ]

        ];
    }
    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->proInfoCatTypeService->getProInfoCatTypes()->onlyTrashed()->with(['deleter_admin', 'infoCategory']);
            return DataTables::eloquent($query)
                ->editColumn('product_info_cat_id', function ($product_info_category_type) {
                    return $product_info_category_type?->infoCategory?->name;
                })
                ->editColumn('status', function ($product_info_category_type) {
                    return "<span class='badge " . $product_info_category_type->status_color . "'>$product_info_category_type->status_label</span>";
                })
                ->editColumn('deleted_by', function ($product_info_category_type) {
                    return $product_info_category_type->deleter_name;
                })
                ->editColumn('deleted_at', function ($product_info_category_type) {
                    return $product_info_category_type->deleted_at_formatted;
                })
                ->editColumn('action', function ($product_info_category_type) {
                    $menuItems = $this->trashedMenuItems($product_info_category_type);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['product_info_cat_id', 'status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.pro_info_cat_type.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product-info-category-type.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-info-category-type-restore']
            ],
            [
                'routeName' => 'pm.product-info-category-type.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-info-category-type-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['product_info_cats'] = $this->ProductInfoCatService->getProductInfoCats()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.pro_info_cat_type.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProInfoCatTypeRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->proInfoCatTypeService->createProInfoCatType($validated, $request);
            session()->flash('success', 'Product Info Category Type created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category Type create failed!');
            throw $e;
        }

        return redirect()->route('pm.product-info-category-type.index');
    }


    /**
     * Display the specified resource.
     */
      public function show(string $id)
    {
        $product_info_category_type = $this->proInfoCatTypeService->getProInfoCatType($id);
        $product_info_category_type->load(['creater_admin', 'updater_admin','infoCategory']);
        $product_info_category_type['product_info_cat_name'] = $product_info_category_type?->infoCategory?->name;
        return response()->json($product_info_category_type);
    }

    /**
     * Show the form for editing the specified resource.
     */

     public function edit(string $id)
    {
        $data['product_info_category_type'] = $this->proInfoCatTypeService->getProInfoCatType($id);
        $data['product_info_cats'] = $this->ProductInfoCatService->getProductInfoCats()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.pro_info_cat_type.edit', $data);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ProInfoCatTypeRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->proInfoCatTypeService->updateProInfoCatType($id, $validated, $request);
            session()->flash('success', 'Product Info Category Type updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category Type update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        try {
            $this->proInfoCatTypeService->deleteProInfoCatType($id);
            session()->flash('success', 'Product Info Category Type deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category Type delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category-type.index');
    }
     public function status(string $id): RedirectResponse
    {
        try {
            $this->proInfoCatTypeService->toggleStatus($id);
            session()->flash('success', 'Product Info Category Type status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'product Info Category Type status update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category-type.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->proInfoCatTypeService->restoreProInfoCatType($id);
            session()->flash('success', 'Brand restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand restore failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->proInfoCatTypeService->permanentDeleteProInfoCatType($id);
            session()->flash('success', 'Brand permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.recycle-bin');
    }
}
