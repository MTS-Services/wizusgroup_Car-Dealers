<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Models\Brand;
use App\Services\Admin\ProductManagement\CompanyService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductManagement\BrandRequest;
use App\Services\Admin\ProductManagement\BrandService;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    protected BrandService $brandService;
    protected CompanyService $companyService;

    public function __construct(BrandService $brandService, CompanyService $companyService)
    {

        $this->brandService = $brandService;
        $this->companyService = $companyService;

        $this->middleware('auth:admin');
        $this->middleware('permission:brand-list', ['only' => ['index']]);
        $this->middleware('permission:brand-details', ['only' => ['show']]);
        $this->middleware('permission:brand-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:brand-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
        $this->middleware('permission:brand-feature', ['only' => ['feature']]);
        $this->middleware('permission:brand-status', ['only' => ['status']]);
        $this->middleware('permission:brand-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:brand-restore', ['only' => ['restore']]);
        $this->middleware('permission:brand-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->brandService->getBrands()->with(['creater_admin','company']);
            return DataTables::eloquent($query)
                ->editColumn('company_id', function ($brand) {
                    return $brand?->company?->name;
                })
                ->editColumn('status', function ($brand) {
                    return "<span class='badge " . $brand->status_color . "'>$brand->status_label</span>";
                })
                ->editColumn('is_featured', function ($brand) {
                    return "<span class='badge " . $brand->featured_color . "'>$brand->featured_label</span>";
                })
                ->editColumn('created_by', function ($brand) {
                    return $brand->creater_name;
                })
                ->editColumn('created_at', function ($brand) {
                    return $brand->created_at_formatted;
                })
                ->editColumn('action', function ($brand) {
                    $menuItems = $this->menuItems($brand);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['company_id','status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.brand.index');
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['brand-details']
            ],
            [
                'routeName' => 'pm.brand.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['brand-edit']
            ],
            [
                'routeName' => 'pm.brand.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['brand-status']
            ],
            [
                'routeName' => 'pm.brand.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['brand-feature']
            ],
            [
                'routeName' => 'pm.brand.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['brand-delete']
            ]

        ];
    }



    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->brandService->getBrands()->onlyTrashed()->with(['deleter_admin','company']);
            return DataTables::eloquent($query)
                ->editColumn('company_id', function ($brand) {
                    return $brand?->company?->name;
                })
                ->editColumn('status', function ($brand) {
                    return "<span class='badge " . $brand->status_color . "'>$brand->status_label</span>";
                })
                ->editColumn('is_featured', function ($brand) {
                    return "<span class='badge " . $brand->featured_color . "'>$brand->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($brand) {
                    return $brand->deleter_name;
                })
                ->editColumn('deleted_at', function ($brand) {
                    return $brand->deleted_at_formatted;
                })
                ->editColumn('action', function ($brand) {
                    $menuItems = $this->trashedMenuItems($brand);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['company_id','status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.brand.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.brand.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['brand-restore']
            ],
            [
                'routeName' => 'pm.brand.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['brand-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.brand.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        try {
            $validated = $request->validated();
            $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->brandService->createBrand($validated, $file);
            session()->flash('success', 'Brand created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand create failed!');
            throw $e;
        }

        return redirect()->route('pm.brand.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = $this->brandService->getBrand($id);
        $brand->load(['creater_admin', 'updater_admin','company']);
        $brand['company_name'] = $brand?->company?->name;
        return response()->json($brand);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['brand'] = $this->brandService->getBrand($id);
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id', 'name'])->get();
        return view('backend.admin.product_management.brand.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->brandService->updateBrand($id, $validated, $file);
            session()->flash('success', 'Brand updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand update failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->brandService->deleteBrand($id);
            session()->flash('success', 'Brand deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand delete failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.index');
    }


    public function status(string $id): RedirectResponse
    {
        try {
            $this->brandService->toggleStatus($id);
            session()->flash('success', 'Brand status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand status update failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.index');
    }

    public function feature($id): RedirectResponse
    {
        try {
            $this->brandService->toggleFeature($id);
            session()->flash('success', 'Brand feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->brandService->restoreBrand($id);
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
            $this->brandService->permanentDeleteBrand($id);
            session()->flash('success', 'Brand permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Brand permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.brand.recycle-bin');
    }
}
