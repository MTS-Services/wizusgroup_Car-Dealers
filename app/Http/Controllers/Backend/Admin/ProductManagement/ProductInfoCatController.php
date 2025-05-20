<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProductInfoCatRequest;
use App\Services\Admin\ProductManagement\ProductInfoCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductInfoCatController extends Controller
{
    protected ProductInfoCategoryService $ProductInfoCatService;
    public function __construct(ProductInfoCategoryService $ProductInfoCatService)
    {
        $this->ProductInfoCatService = $ProductInfoCatService;

        $this->middleware('auth:admin');
        $this->middleware('permission:product-info-category-list', ['only' => ['index']]);
        $this->middleware('permission:product-info-category-details', ['only' => ['show']]);
        $this->middleware('permission:product-info-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-info-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-info-category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-info-category-status', ['only' => ['status']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->ProductInfoCatService->getProductInfoCats()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product_info_category) {
                    return "<span class='badge " . $product_info_category->status_color . "'>$product_info_category->status_label</span>";
                })
                ->editColumn('created_by', function ($product_info_category) {
                    return $product_info_category->creater_name;
                })
                ->editColumn('created_at', function ($product_info_category) {
                    return $product_info_category->created_at_formatted;
                })
                ->editColumn('action', function ($product_info_category) {
                    $menuItems = $this->menuItems($product_info_category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_info_cat.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['product-info-category-details']
            ],
            [
                'routeName' => 'pm.product-info-category.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-info-category-edit']
            ],
            [
                'routeName' => 'pm.product-info-category.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-info-category-status']
            ],
            [
                'routeName' => 'pm.product-info-category.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-info-category-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->ProductInfoCatService->getProductInfoCats()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product_info_category) {
                    return "<span class='badge " . $product_info_category->status_color . "'>$product_info_category->status_label</span>";
                })
                ->editColumn('deleted_by', function ($product_info_category) {
                    return $product_info_category->deleter_name;
                })
                ->editColumn('deleted_at', function ($product_info_category) {
                    return $product_info_category->deleted_at_formatted;
                })
                ->editColumn('action', function ($product_info_category) {
                    $menuItems = $this->trashedMenuItems($product_info_category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_info_cat.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product-info-category.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-info-category-restore']
            ],
            [
                'routeName' => 'pm.product-info-category.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-info-category-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.product_management.product_info_cat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(ProductInfoCatRequest $request)
    {
        try {
            $validated = $request->validated();
             $this->ProductInfoCatService->createProductInfoCat($validated, $request);
            session()->flash('success', 'Product Info Category created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category create failed!');
            throw $e;
        }

        return redirect()->route('pm.product-info-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_info_category = $this->ProductInfoCatService->getProductInfoCat($id);
        $product_info_category->load(['creater_admin', 'updater_admin']);
        return response()->json($product_info_category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_info_category = $this->ProductInfoCatService->getProductInfoCat($id);
        return view('backend.admin.product_management.product_info_cat.edit', compact('product_info_category'));

    }

    /**
     * Update the specified resource in storage.
     */
   public function update(ProductInfoCatRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->ProductInfoCatService->updateProductInfoCat($id, $validated);
            session()->flash('success', 'Product Info Category updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id): RedirectResponse
    {
        try {
            $this->ProductInfoCatService->deleteProductInfoCat($id);
            session()->flash('success', 'Product Info Category deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category.index');
    }

    public function status(string $id): RedirectResponse
    {
        try {
            $this->ProductInfoCatService->toggleStatus($id);
            session()->flash('success', 'Product Info Category status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category status update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category.index');
    }
     public function restore(string $id): RedirectResponse
    {
        try {
            $this->ProductInfoCatService->restoreProductInfoCat($id);
            session()->flash('success', 'Product Info Category restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category restore failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category.recycle-bin');
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
            $this->ProductInfoCatService->permanentDeleteCompany($id);
            session()->flash('success', 'Product Info Category permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Info Category permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-info-category.recycle-bin');
    }
}
