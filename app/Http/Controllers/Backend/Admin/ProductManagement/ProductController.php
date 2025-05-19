<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {

        $this->productService = $productService;

        $this->middleware('auth:admin');
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-details', ['only' => ['show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
        $this->middleware('permission:product-status', ['only' => ['status']]);
        $this->middleware('permission:product-feature', ['only' => ['feature']]);
        $this->middleware('permission:product-backorder', ['only' => ['backorder']]);
        $this->middleware('permission:product-dropshipping', ['only' => ['dropshipping']]);
        $this->middleware('permission:product-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:product-restore', ['only' => ['restore']]);
        $this->middleware('permission:product-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {

        if ($request->ajax()) {
            $query = $this->productService->getProducts()
                ->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product) {
                    return "<span class='badge " . $product->status_color . "'>$product->status_label</span>";
                })
                ->editColumn('is_featured', function ($product) {
                    return "<span class='badge " . $product->featured_color . "'>" . $product->featured_label . "</span>";
                })
                ->editColumn('allow_backorder', function ($product) {
                    return "<span class='badge " . $product->backorder_color . "'>" . $product->backorder_label . "</span>";
                })
                ->editColumn('is_dropshipping', function ($product) {
                    return "<span class='badge " . $product->dropshipping_color . "'>" . $product->dropshipping_label . "</span>";
                })
                ->editColumn('created_by', function ($product) {
                    return $product->creater_name;
                })
                ->editColumn('created_at', function ($product) {
                    return $product->created_at_formatted;
                })
                ->editColumn('action', function ($product) {
                    $menuItems = $this->menuItems($product);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'allow_backorder', 'is_dropshipping', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product.index');
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product.show',
                'params' => [encrypt($model->id)],
                'label' => 'Details',
                'permissions' => ['product-details']
            ],
            [
                'routeName' => 'pm.product.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['product-edit']
            ],
            [
                'routeName' => 'pm.product.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['product-status']
            ],
            [
                'routeName' => 'pm.product.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['product-feature']
            ],
            [
                'routeName' => 'pm.product.backorder',
                'params' => [encrypt($model->id)],
                'label' => $model->backorder_btn_label,
                'restore' => true,
                'permissions' => ['product-backorder']
            ],
            [
                'routeName' => 'pm.product.dropshipping',
                'params' => [encrypt($model->id)],
                'label' => $model->dropshipping_btn_label,
                'restore' => true,
                'permissions' => ['product-dropshipping']
            ],
            [
                'routeName' => 'pm.product.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['product-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->productService->getProducts()
                ->with(['deleter_admin'])
                ->onlyTrashed();
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product) {
                    return "<span class='badge " . $product->status_color . "'>$product->status_label</span>";
                })
                ->editColumn('is_featured', function ($product) {
                    return "<span class='badge " . $product->featured_color . "'>" . $product->featured_label . "</span>";
                })
                ->editColumn('allow_backorder', function ($product) {
                    return "<span class='badge " . $product->backorder_color . "'>" . $product->backorder_label . "</span>";
                })
                ->editColumn('is_dropshipping', function ($product) {
                    return "<span class='badge " . $product->dropshipping_color . "'>" . $product->dropshipping_label . "</span>";
                })
                ->editColumn('deleted_by', function ($category) {
                    return $category->deleter_name;
                })
                ->editColumn('deleted_at', function ($category) {
                    return $category->deleted_at_formatted;
                })
                ->editColumn('action', function ($category) {
                    $menuItems = $this->trashedMenuItems($category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'allow_backorder', 'is_dropshipping', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.product.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['product-restore']
            ],
            [
                'routeName' => 'pm.product.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.product_management.product.create');
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
        $data = $this->productService->getProduct($id);
        $data->load(['creater_admin']);
        return dd($data);
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
        try {
            $this->productService->delete($id);
            session()->flash('success', 'Product deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $product = $this->productService->getDeletedProduct($id);
            $this->productService->restore($product);
            session()->flash('success', 'Product restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product restore failed!');
            throw $e;
        }
        return redirect()->route('pm.product.recycle-bin');
    }

    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $product = $this->productService->getDeletedProduct($id);
            $this->productService->permanentDelete($product);
            session()->flash('success', 'Product permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.product.recycle-bin');
    }
}
