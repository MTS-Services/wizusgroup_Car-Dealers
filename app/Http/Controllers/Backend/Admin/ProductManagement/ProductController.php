<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ProductImageRequest;
use App\Http\Requests\Admin\ProductManagement\ProductInfoFileRequest;
use App\Http\Requests\Admin\ProductManagement\ProductInfoRemarkRequest;
use App\Http\Requests\Admin\ProductManagement\ProductInfoRequest;
use App\Http\Requests\Admin\ProductManagement\ProductRelationRequest;
use App\Http\Requests\Admin\ProductManagement\ProductRequest;
use App\Models\Supplier;
use App\Services\Admin\ProductManagement\CategoryService;
use App\Services\Admin\ProductManagement\CompanyService;
use App\Services\Admin\ProductManagement\ProductInfoCategoryService;
use App\Services\Admin\ProductManagement\ProductService;
use App\Services\Admin\SupllierManagement\SupplierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

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
        // $this->middleware('permission:product-backorder', ['only' => ['backorder']]);
        // $this->middleware('permission:product-dropshipping', ['only' => ['dropshipping']]);
        $this->middleware('permission:product-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:product-restore', ['only' => ['restore']]);
        $this->middleware('permission:product-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $product_type = $request->product_type;
        if ($request->ajax()) {
            $query = $this->productService->getProducts()
                ->with(['creater_admin']);
            switch ($product_type) {
                case 'out-of-stock':
                    $query->outOfStock();
                    break;
                default:
                    $query->where('product_type', $product_type)->inStock();
                    break;
            }
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product) {
                    return "<span class='badge " . $product->status_color . "'>$product->status_label</span>";
                })
                ->editColumn('is_featured', function ($product) {
                    return "<span class='badge " . $product->featured_color . "'>" . $product->featured_label . "</span>";
                })
                ->editColumn('created_by', function ($product) {
                    return $product->creater_name;
                })
                ->editColumn('created_at', function ($product) {
                    return $product->created_at_formatted;
                })
                ->editColumn('action', function ($product) use($product_type) {
                    $menuItems = $this->menuItems($product, $product_type);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product.index', compact('product_type'));
    }


    protected function menuItems($model, $product_type): array
    {
        return [
            [
                'routeName' => 'pm.product.show',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => 'Details',
                'permissions' => ['product-details']
            ],
            [
                'routeName' => 'pm.product.edit',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => 'Edit',
                'permissions' => ['product-edit']
            ],
            [
                'routeName' => 'pm.product.status',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => $model->status_btn_label,
                'permissions' => ['product-status']
            ],
            [
                'routeName' => 'pm.product.feature',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => $model->featured_btn_label,
                'permissions' => ['product-feature']
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
        $product_type = $request->product_type;
        if ($request->ajax()) {
            // Get all the products that are in the recycle bin
            $query = $this->productService->getProducts()
                ->with(['deleter_admin'])
                ->onlyTrashed();
            switch ($product_type) {
                case 'out-of-stock':
                    $query->outOfStock();
                    break;
                default:
                    $query->where('product_type', $product_type)->inStock();
                    break;
            }
            // Define the columns that will be shown in the table
            // The editColumn method is used to customize the values of a column
            return DataTables::eloquent($query)
                ->editColumn('status', function ($product) {
                    // The status of the product is shown as a badge
                    return "<span class='badge " . $product->status_color . "'>$product->status_label</span>";
                })
                ->editColumn('is_featured', function ($product) {
                    // The featured status of the product is shown as a badge
                    return "<span class='badge " . $product->featured_color . "'>" . $product->featured_label . "</span>";
                })
                ->editColumn('deleted_by', function ($category) {
                    // The name of the user who deleted the product is shown
                    return $category->deleter_name;
                })
                ->editColumn('deleted_at', function ($category) {
                    // The date when the product was deleted is shown
                    return $category->deleted_at_formatted;
                })
                ->editColumn('action', function ($category) use($product_type) {
                    $menuItems = $this->trashedMenuItems($category, $product_type);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.product.recycle-bin');
    }

    protected function trashedMenuItems($model, $product_type): array
    {
        return [
            [
                'routeName' => 'pm.product.restore',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => 'Restore',
                'permissions' => ['product-restore']
            ],
            [
                'routeName' => 'pm.product.permanent-delete',
                'params' => ['product' => encrypt($model->id), 'product_type' => $product_type],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['product-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $data['product_type'] = $request->product_type;
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
            return redirect()->route('pm.product.relation', ['product'=>encrypt($product->id),'product_type' => request('product_type')]);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product basic information create failed!');
            throw $e;
        }
    }

    public function relation(string $pid): View
    {
        $data['product'] = $this->productService->getProduct($pid);
        $data['product']->load(['brand', 'model', 'category', 'company', 'subCategory']);
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id', 'name'])->get();
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.product.create.relation', $data);
    }

    public function relationStore(ProductRelationRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $this->productService->relationCreateOrUpdate($product, $validated);
            session()->flash('success', 'Product relations added successfully!');
            return redirect()->route('pm.product.image',['product'=>$pid,'product_type' => request('product_type')]);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product relations added failed!');
            throw $e;
        }
    }

    public function images(string $pid): View
    {
        $data['product'] = $this->productService->getProduct($pid);
        $data['product']->load(['images', 'primaryImage']);
        return view('backend.admin.product_management.product.create.image', $data);
    }

    public function imageStore(ProductImageRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $this->productService->imageCreate($product, $validated);
            session()->flash('success', 'Product images added successfully!');
            return redirect()->route('pm.product.info',['product'=>$pid,'product_type' => request('product_type')]);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product images added failed!');
            throw $e;
        }
    }

    public function info(string $pid): View
    {
        $data['infos'] = $this->productService->getInfos($pid);
        $data['product_id'] = $pid;
        $data['info_categories'] = $this->productInfoCategoryService->getProductInfoCats()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.product.create.information', $data);
    }
    public function viewInfoDetails(string $pi_id): JsonResponse
    {
        $info = $this->productService->getProductInfo($pi_id);
        $info->encryptedID = encrypt($info->id);
        $info->load(['infoCategory', 'product', 'creater_admin']);
        return response()->json($info);
    }

    public function deleteInfo(string $pi_id): RedirectResponse
    {
        $info_remark = $this->productService->getProductInfo($pi_id);
        $product_id = $info_remark->product_id;
        $info_remark->forceDelete();
        session()->flash('success', 'Product information deleted successfully!');
        return redirect()->route('pm.product.info', ['product'=>encrypt($product_id),'product_type' => request('product_type')]);
    }
    public function infoStore(ProductInfoRequest $request, string $pid): RedirectResponse
    {
        try {
            $product = $this->productService->getProduct($pid);
            $validated = $request->validated();
            $file = $request->validated('file') && $request->hasFile('file') ? $request->file('file') : null;
            $this->productService->infoCreate($product, $validated, $file);
            session()->flash('success', 'Product information added successfully!');
            return redirect()->route('pm.product.info', ['product'=>$pid,'product_type' => request('product_type')]);
            ;
        } catch (\Throwable $e) {
            session()->flash('error', 'Product information added failed!');
            throw $e;
        }
    }


    public function download(string $id)
    {
        $info = $this->productService->getProductInfo($id);
        if (Storage::disk('public')->exists($info->file)) {
            return response()->download(Storage::disk('public')->path($info->file), basename($info->file));
        } else {
            session()->flash('error', 'File not found!');
            return redirect()->route('pm.product.index', ['product_type' => 2]);
        }
    }
    public function entryComplete(string $pid): RedirectResponse
    {
        try {
            $completed = $this->productService->getProductEntryComplete($pid);
            if ($completed) {
                session()->flash('success', 'Product entry finished successfully!');
                return redirect()->route('pm.product.index', ['product_type' => request('product_type')]);
            } else {
                session()->flash('error', value: 'Product entry completed failed!');
                return redirect()->route('pm.product.info', ['product'=>$pid,'product_type' => request('product_type')]);
            }
        } catch (\Throwable $e) {
            session()->flash('error', 'Product entry completed failed!' . $e->getMessage());
            throw $e;
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['supplier'] = Supplier::select('id', 'first_name')->get();
        $data['product'] = $this->productService->getProduct($id);
        $data['product']->load(['creater_admin', 'images', 'primaryImage', 'productInformations']);
        return view('backend.admin.product_management.product.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['product'] = $this->productService->getProduct($id);
        $data['suppliers'] = Supplier::select('id', 'first_name')->get();
        return view('backend.admin.product_management.product.edit', $data);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $pid)
    {
        try {
            $validated = $request->validated();
            $this->productService->update($pid, $validated);
            session()->flash('success', 'Product updated successfully!');
            return redirect()->route('pm.product.relation', $pid);
        } catch (\Throwable $e) {
            session()->flash('error', 'Product update failed!');
            throw $e;
        }
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
        return redirect()->route('pm.product.index', ['product_type' => request('product_type')]);
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
        return redirect()->route('pm.product.index', ['product_type' => request('product_type')]);
    }

    // public function backorder(string $id): RedirectResponse
    // {
    //     try {
    //         $this->productService->toggleBackOrder($id);
    //         session()->flash('success', 'Product back order updated successfully!');
    //     } catch (\Throwable $e) {
    //         session()->flash('error', 'Product back order update failed!');
    //         throw $e;
    //     }
    //     return redirect()->route('pm.product.index');
    // }

    // public function dropshipping(string $id): RedirectResponse
    // {
    //     try {
    //         $this->productService->toggleDropshipping($id);
    //         session()->flash('success', 'Product dropshipping updated successfully!');
    //     } catch (\Throwable $e) {
    //         session()->flash('error', 'Product dropshipping update failed!');
    //         throw $e;
    //     }
    //     return redirect()->route('pm.product.index');
    // }

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
        return redirect()->route('pm.product.index', ['product_type' => 2]);
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
        return redirect()->route('pm.product.recycle-bin', ['product_type' => request('product_type')]);
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
        return redirect()->route('pm.product.recycle-bin', ['product_type' => request('product_type')]);
    }
}
