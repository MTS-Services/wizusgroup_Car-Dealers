<?php

namespace App\Http\Controllers\Backend\Admin\SupplierManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupllierManagement\SupplierRequest;
use App\Services\Admin\SupllierManagement\SupplierService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SuppliersController extends Controller
{
    protected SupplierService $supplierService;
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
        $this->middleware('auth:admin');
        $this->middleware('permission:supplier-list', ['only' => ['index']]);
        $this->middleware('permission:supplier-details', ['only' => ['show']]);
        $this->middleware('permission:supplier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:supplier-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);
        $this->middleware('permission:supplier-status', ['only' => ['status']]);
        $this->middleware('permission:supplier-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:supplier-restore', ['only' => ['restore']]);
        $this->middleware('permission:supplier-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->supplierService->getSuppliers()->with(['creater_admin']);
            return DataTables::eloquent($query)
            ->editColumn('first_name', function ($supplier) {
                    return $supplier->full_name . ($supplier->username ? " (" . $supplier->username . ")" : "");
                })
                ->editColumn('status', function ($supplier) {
                    return "<span class='badge " . $supplier->status_color . "'>$supplier->status_label</span>";
                })
                ->editColumn('email_verified_at', function ($supplier) {
                    return "<span class='badge " . $supplier->verify_color . "'>" . $supplier->verify_label . "</span>";
                })
                ->editColumn('created_by', function ($supplier) {
                    return $supplier->creater_name;
                })
                ->editColumn('created_at', function ($supplier) {
                    return $supplier->created_at_formatted;
                })
                ->editColumn('action', function ($supplier) {
                    $menuItems = $this->menuItems($supplier);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'email_verified_at', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.supplier_management.supplier.index');
    }

     protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['supplier-details']
            ],
            [
                'routeName' => 'sm.supplier.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['supplier-edit']
            ],
            [
                'routeName' => 'sm.supplier.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['supplier-status']
             ],
            // [
            //     'routeName' => 'pm.supplier.feature',
            //     'params' => [encrypt($model->id)],
            //     'label' => $model->featured_btn_label,
            //     'permissions' => ['supplier-feature']
            // ],
            [
                'routeName' => 'sm.supplier.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['supplier-delete']
            ]

        ];
    }

      public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->supplierService->getSuppliers()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('first_name', function ($supplier) {
                    return $supplier->full_name . ($supplier->username ? " (" . $supplier->username . ")" : "");
                })
                ->editColumn('status', function ($supplier) {
                    return "<span class='badge " . $supplier->status_color . "'>$supplier->status_label</span>";
                })
                ->editColumn('email_verified_at', function ($user) {
                    return "<span class='badge " . $user->verify_color . "'>" . $user->verify_label . "</span>";
                })
                ->editColumn('deleted_by', function ($supplier) {
                    return $supplier->deleter_name;
                })
                ->editColumn('deleted_at', function ($supplier) {
                    return $supplier->deleted_at_formatted;
                })
                ->editColumn('action', function ($supplier) {
                    $menuItems = $this->trashedMenuItems($supplier);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['first_name', 'status', 'email_verified_at', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.supplier_management.supplier.recycle-bin');
    }
    /**
     * Define menu items for trashed items in admin list.
     *
     * @param Admin $model
     * @return array
     */
    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'sm.supplier.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['supplier-restore']
            ],
            [
                'routeName' => 'sm.supplier.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['supplier-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
   public function create(): View
    {

        return view('backend.admin.supplier_management.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(SupplierRequest $request): RedirectResponse
    {
         try {
            $validated = $request->validated();
            $this->supplierService->createSupplier($validated, $request->image ?? null);
            session()->flash('success', 'Supplier created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Supplier create failed!');
            throw $e;
        }
        return redirect()->route('sm.supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->supplierService->getSupplier($id);
        $data->load(['creater_admin', 'updater_admin',]);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['supplier'] = $this->supplierService->getSupplier($id);
        return view('backend.admin.supplier_management.supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(SupplierRequest $request, string $id): RedirectResponse
    {
        try {
            $supplier = $this->supplierService->getSupplier($id);
            $validated = $request->validated();
            $this->supplierService->updateSupplier($supplier,$validated,  $request->image ?? null);
            session()->flash('success', 'Supplier updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Supplier update failed!');
            throw $e;
        }
        return redirect()->route('sm.supplier.index');
    }


    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id): RedirectResponse
    {
        $admin = $this->supplierService->getSupplier($id);
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not delete Super Supplier!');
            return redirect()->route('sm.supplier.index');
        }
        $this->supplierService->delete( $admin);
        session()->flash('success', 'Supplier move to recycle bin successfully!');
        return redirect()->route('sm.supplier.index');
    }
     public function status(string $id): RedirectResponse
    {
        $admin = $this->supplierService->getSupplier($id);
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not change Super Admin status!');
            return redirect()->route('am.admin.index');
        }
        $this->supplierService->toggleStatus($admin);
        session()->flash('success', 'Admin status updated successfully!');
        return redirect()->route('am.admin.index');
    }

     public function restore(string $id): RedirectResponse
    {
        $this->supplierService->restore( $id );
        session()->flash('success', 'Supplier restored successfully!');
        return redirect()->route('sm.supplier.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
       $this->supplierService->permanentDelete( $id );
        session()->flash('success', 'Supplier permanently deleted successfully!');
        return redirect()->route('sm.supplier.recycle-bin');
    }
}
