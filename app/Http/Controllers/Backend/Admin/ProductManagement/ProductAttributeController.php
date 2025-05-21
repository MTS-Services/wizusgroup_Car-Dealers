<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProductAttributeRequest;
use App\Http\Traits\FileManagementTrait;
use App\Models\Documentation;
use App\Models\ProductAttribute;
use App\Services\Admin\ProductManagement\ProductAttributeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductAttributeController extends Controller
{
    protected ProductAttributeService $productAttrService;

    use FileManagementTrait;
    public function __construct( ProductAttributeService $productAttrService)
    {
        $this->productAttrService = $productAttrService;

        $this->middleware('auth:admin');
        $this->middleware('permission:product-attribute-list', ['only' => ['index']]);
        $this->middleware('permission:product-attribute-details', ['only' => ['show']]);
        $this->middleware('permission:product-attribute-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-attribute-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-attribute-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-attribute-status', ['only' => ['status']]);
        $this->middleware('permission:product-attribute-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:product-attribute-restore', ['only' => ['restore']]);
        $this->middleware('permission:product-attribute-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->productAttrService->getProductAttributes()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product_attribute) {
                    return "<span class='badge " . $product_attribute->status_color . "'>$product_attribute->status_label</span>";
                })
                // ->editColumn('is_featured', function ($product_attribute) {
                //     return "<span class='badge " . $product_attribute->featured_color . "'>" . $product_attribute->featured_label . "</span>";
                // })
                ->editColumn('creater_id', function ($product_attribute) {
                    return $product_attribute->creater_name;
                })
                ->editColumn('created_at', function ($product_attribute) {
                    return $product_attribute->created_at_formatted;
                })
                ->editColumn('action', function ($product_attribute) {
                    $menuItems = $this->menuItems($product_attribute);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'creater_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_attribute.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['product-attribute-list']
            ],
            [
                'routeName' => 'pm.product-attribute.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-attribute-edit']
            ],
            [
                'routeName' => 'pm.product-attribute.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-attribute-status']
            ],
            // [
            //     'routeName' => 'pm.product-attribute.feature',
            //     'params' => [encrypt($model->id)],
            //     'label' => $model->featured_btn_label,
            //     'permissions' => ['product-attribute-feature']
            // ],
            [
                'routeName' => 'pm.product-attribute.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-attribute-delete']
            ]

        ];
    }

       public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->productAttrService->getProductAttributes()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
            ->editColumn('status', function ($product_attribute) {
                    return "<span class='badge " . $product_attribute->status_color . "'>$product_attribute->status_label</span>";
                })

               ->editColumn('deleter_id', function ($product_attribute) {
                    return $product_attribute->deleter_name;
                })
                ->editColumn('deleted_at', function ($product_attribute) {
                    return $product_attribute->deleted_at_formatted;
                })
                ->editColumn('action', function ($product_attribute) {
                    $menuItems = $this->trashedMenuItems($product_attribute);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product_attribute.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product-attribute.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-attribute-restore']
            ],
            [
                'routeName' => 'pm.product-attribute.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-attribute-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['document'] = Documentation::where([['module_key', 'product attribute'], ['type', 'update']])->first();
        return view('backend.admin.product_management.product_attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $request)
    {
         try {
            $validated = $request->validated();
            $this->productAttrService->createProductAttribute($validated, $request->image ?? null);
            session()->flash('success', 'Product Attribute created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product Attribute create failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->productAttrService->getProductAttribute($id);
        $data->load(['creater_admin', 'updater_admin']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $product_attribute = $this->productAttrService->getProductAttribute($id);
        $data['document'] = Documentation::where([['module_key', 'product attribute'], ['type', 'update']])->first();
        return view('backend.admin.product_management.product_attribute.edit', compact('product_attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeRequest $request, string $id): RedirectResponse
    {

        try {
            $validated = $request->validated();
            $this->productAttrService->updateProductAttribute($id, $validated, $request->image ?? null);
            session()->flash('success', 'Product attribute updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
       try {
            $this->productAttrService->deleteProductAttribute($id);
            session()->flash('success', 'Product attribute deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.index');
    }

    public function status(string $id): RedirectResponse
    {
         try {
            $this->productAttrService->toggleStatus($id);
            session()->flash('success', 'Product attribute status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute status update failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.index');
    }
        public function restore(string $id): RedirectResponse
    {
        try {
            $this->productAttrService->restoreProductAttribute($id);
            session()->flash('success', 'Product attribute restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute restore failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.recycle-bin');
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
            $this->productAttrService->permanentDeleteProductAttribute($id);
            session()->flash('success', 'Product attribute permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product attribute permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product-attribute.recycle-bin');
    }
}
