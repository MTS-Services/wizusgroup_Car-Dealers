<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProductAttributeValueRequest;
use App\Models\Documentation;
use App\Models\Product;
use App\Services\Admin\ProductManagement\ProductAttributeService;
use App\Services\Admin\ProductManagement\ProductAttributeValueService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductAttributeValueController extends Controller
{
    protected ProductAttributeValueService $productAttributeValueService;
    protected ProductAttributeService $productAttributeService;
    public function __construct(ProductAttributeValueService $productAttributeValueService ,ProductAttributeService $productAttributeService)
    {
        $this->productAttributeValueService = $productAttributeValueService;
        $this->productAttributeService = $productAttributeService;

        $this->middleware('auth:admin');
        $this->middleware('permission:product-attribute-value-list', ['only' => ['index']]);
        $this->middleware('permission:product-attribute-value-details', ['only' => ['show']]);
        $this->middleware('permission:product-attribute-value-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-attribute-value-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-attribute-value-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-attribute-value-status', ['only' => ['status']]);
        $this->middleware('permission:product-attribute-value-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:product-attribute-value-restore', ['only' => ['restore']]);
        $this->middleware('permission:product-attribute-value-permanent-delete', ['only' => ['permanentDelete']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $query = $this->productAttributeValueService->getProductAttributeValues()->with(['productAttribute', 'creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product_attribute_value) {
                    return "<span class='badge " . $product_attribute_value->status_color . "'>$product_attribute_value->status_label</span>";
                })
                ->editColumn('product_attribute_id', function ($product_attribute_value) {
                    return $product_attribute_value->productAttribute?->name;
                })
                ->editColumn('creater_id', function ($product_attribute_value) {
                    return $product_attribute_value->creater_name;
                })
                ->editColumn('created_at', function ($product_attribute_value) {
                    return $product_attribute_value->created_at_formatted;
                })
                ->editColumn('action', function ($product_attribute_value) {
                    $menuItems = $this->menuItems($product_attribute_value);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['value', 'product_attribute_id', 'status', 'creater_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_attribute_value.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['product-attribute-value-list']
            ],
            [
                'routeName' => 'pm.product-attr-value.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-attribute-value-edit']
            ],
            [
                'routeName' => 'pm.product-attr-value.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-attribute-value-status']
            ],
            [
                'routeName' => 'pm.product-attr-value.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-attribute-value-delete']
            ]

        ];
    }

         public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->productAttributeValueService->getProductAttributeValues()->onlyTrashed()->with(['productAttribute', 'deleter_admin']);
            return DataTables::eloquent($query)
           ->editColumn('status', function ($product_attribute_value) {
                    return "<span class='badge " . $product_attribute_value->status_color . "'>$product_attribute_value->status_label</span>";
                })
                ->editColumn('product_attribute_id', function ($product_attribute_value) {
                    return $product_attribute_value->productAttribute?->name;
                })
               ->editColumn('deleter_id', function ($product_attribute_value) {
                    return $product_attribute_value->deleter_name;
                })
                ->editColumn('deleted_at', function ($product_attribute_value) {
                    return $product_attribute_value->deleted_at_formatted;
                })
                ->editColumn('action', function ($product_attribute_value) {
                    $menuItems = $this->trashedMenuItems($product_attribute_value);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'product_attribute_id', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_attribute_value.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product-attr-value.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-attribute-value-restore']
            ],
            [
                'routeName' => 'pm.product-attr-value.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-attribute-value-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::active()->select(['id', 'name'])->get();
        $product_attribute = $this->productAttributeService->getProductAttributes()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'product attribute value'], ['type', 'create']])->first();
        return view('backend.admin.product_management.product_attribute_value.create', compact('product_attribute', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeValueRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->productAttributeValueService->createProductAttributeValue($validated, $request->image ?? null);
            session()->flash('success', 'Product Attribute Value created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Attribute Value create failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::active()->select(['id', 'name'])->get();
        $data = $this->productAttributeValueService->getProductAttributeValue($id);
        $data->load(['productAttribute', 'creater_admin', 'updater_admin']);
        $data['product_name'] = $data?->product?->name;
        $data['attribute_name'] = $data?->productAttribute?->name;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['products'] = Product::active()->select(['id', 'name'])->get();
        $data['product_attribute_value'] = $this->productAttributeValueService->getProductAttributeValue($id);
        $data['product_attributes'] = $this->productAttributeService->getProductAttributes()->active()->get();
        $data['document'] = Documentation::where([['module_key', 'product attribute value'], ['type', 'update']])->first();
        return view('backend.admin.product_management.product_attribute_value.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeValueRequest $request, string $id)
    {
         try {
            $validated = $request->validated();
            $this->productAttributeValueService->updateProductAttributeValue($id, $validated, $request->image ?? null);
            session()->flash('success', 'Product attribute value updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute value update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { try {
            $this->productAttributeValueService->deleteProductAttributeValue($id);
            session()->flash('success', 'Product attribute value deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute value delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.index');
    }
    public function status(string $id): RedirectResponse
    {try {
            $this->productAttributeValueService->toggleStatus($id);
            session()->flash('success', 'Product attribute value status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute value status update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.index');
    }

        public function restore(string $id): RedirectResponse
    {
        try {
            $this->productAttributeValueService->restoreProductAttributeValue($id);
            session()->flash('success', 'Product attribute value restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute value restore failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.recycle-bin');
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
            $this->productAttributeValueService->permanentDeleteProductAttributeValue($id);
            session()->flash('success', 'Product attribute value permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute value permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attr-value.recycle-bin');
    }
}
