<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Requests\Admin\ProductManagement\ProductInfoRemarkRequest;
use App\Http\Requests\Admin\ProductManagement\ProductInfoRequest;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Category;
use App\Models\ProductInformation;
use App\Models\Supplier;
use App\Models\TaxClass;
use App\Services\Admin\ProductManagement\CategoryService;
use App\Services\Admin\ProductManagement\CompanyService;
use App\Services\Admin\ProductManagement\ProductInfoCategoryService;
use App\Services\Admin\SupllierManagement\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProductImageRequest;
use App\Http\Requests\Admin\ProductManagement\ProductRelationRequest;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Admin\ProductManagement\ProductService;
use App\Http\Requests\Admin\ProductManagement\ProductRequest;

class ProductController extends Controller
{

    protected ProductService $productService;
    protected SupplierService $supplierService;
    protected CompanyService $companyService;
    protected CategoryService $categoryService;
    protected ProductInfoCategoryService $productInfoCategoryService;

    public function __construct(ProductService $productService, SupplierService $supplierService, CompanyService $companyService, CategoryService $categoryService, ProductInfoCategoryService $productInfoCategoryService)
    {

        $this->productService = $productService;
        $this->supplierService = $supplierService;
        $this->companyService = $companyService;
        $this->categoryService = $categoryService;
        $this->productInfoCategoryService = $productInfoCategoryService;

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

    public function recycleBin(Request $request): JsonResponse|View
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
    public function create(): View
    {
        $data['suppliers'] = Supplier::select('id', 'first_name')->get();
        return view('backend.admin.product_management.product.create.basic_info', $data);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $product = $this->productService->basicInfoCreate($validated);
            session()->flash('success', 'Product basic information added successfully!');
            return redirect()->route('pm.product.relation', encrypt($product->id));
        } catch (\Throwable $e) {
            session()->flash('error', 'Product basic information create failed!');
            throw $e;
        }
    }

    public function relation(string $pid): View
    {
        $data['product_id'] = $pid;
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id', 'name'])->get();
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.product.create.relation', $data);
    }

    public function relationStore(ProductRelationRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $this->productService->relationCreate($product, $validated);
            session()->flash('success', 'Product relations added successfully!');
            return redirect()->route('pm.product.image', $pid);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product relations added failed!');
            throw $e;
        }
    }

    public function images(string $pid): View
    {
        $data['product_id'] = $pid;
        return view('backend.admin.product_management.product.create.image', $data);
    }

    public function imageStore(ProductImageRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $this->productService->imageCreate($product, $validated);
            session()->flash('success', 'Product images added successfully!');
            return redirect()->route('pm.product.info', $pid);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product images added failed!');
            throw $e;
        }
    }

    public function info(string $pid): View
    {
        $data['infos'] = $this->productService->getInfos($pid);
        $data['info_remarks'] = $this->productService->getInfoRemarks($pid);
        $data['product_id'] = $pid;
        $data['info_categories'] = $this->productInfoCategoryService->getProductInfoCats()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.product.create.information', $data);
    }
    public function viewRemarks(string $pi_id): JsonResponse
    {
        $info_remark = $this->productService->getProductInfo($pi_id);
        $info_remark->remarks = html_entity_decode($info_remark->remarks );
        $info_remark->load('infoCategory');
        return response()->json($info_remark);
    }

    public function deleteInfo(string $pi_id): RedirectResponse
    {
        $info_remark = $this->productService->getProductInfo($pi_id);
        $product_id = $info_remark->product_id;
        $info_remark->forceDelete();
        session()->flash('success', 'Product information deleted successfully!');
        return redirect()->route('pm.product.info', encrypt($product_id));
    }
    public function infoStore(ProductInfoRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct( $pid);
            $validated = $request->validated();
            $this->productService->infoCreate($product, $validated);
            session()->flash('success', 'Product information added successfully!');
            return redirect()->route('pm.product.info', $pid);
            ;
        } catch (\Throwable $e) {
            session()->flash('error', 'Product information added failed!');
            throw $e;
        }
    }
    public function infoRemarkStore(ProductInfoRemarkRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $this->productService->infoRemarkCreate($product, $validated);
            session()->flash('success', 'Product remarks added successfully!');
            return redirect()->route('pm.product.info', $pid);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product remarks added failed!');
            throw $e;
        }
    }

    public function entryComplete(string $pid): RedirectResponse
    {
        try {
            $completed = $this->productService->getProductEntryComplete($pid);
            if ($completed) {
                session()->flash('success', 'Product entry finished successfully!');
                return redirect()->route('pm.product.index');
            }else{
                session()->flash('error', value: 'Product entry completed failed!');
                return redirect()->route('pm.product.info', $pid);
            }
        } catch (\Throwable $e) {
            session()->flash('error', 'Product entry completed failed!');
            throw $e;
        }
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

      public function status(string $id): RedirectResponse
    {
        try {
            $this->productService->toggleStatus($id);
            session()->flash('success', 'Product status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product status update failed!');
            throw $e;
        }
        return redirect()->route('pm.product.index');
    }

    public function feature($id): RedirectResponse
    {
        try {
            $this->productService->toggleFeature($id);
            session()->flash('success', 'Product feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.product.index');
    }

    public function backorder(string $id): RedirectResponse
    {
        try {
            $this->productService->toggleBackOrder($id);
            session()->flash('success', 'Product back order updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product back order update failed!');
            throw $e;
        }
        return redirect()->route('pm.product.index');
    }

    public function dropshipping(string $id): RedirectResponse
    {
        try {
            $this->productService->toggleDropshipping($id);
            session()->flash('success', 'Product dropshipping updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Product dropshipping update failed!');
            throw $e;
        }
        return redirect()->route('pm.product.index');
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
