<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\TaxClassRequest;
use App\Models\TaxClass;
use App\Services\Admin\ProductManagement\TaxClassService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxClassController extends Controller
{
    protected TaxClassService $taxClassService;
    public function __construct(TaxClassService $taxClassServic)
    {
        $this->taxClassService = $taxClassServic;

        $this->middleware('auth:admin');
        $this->middleware('permission:tax-class-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:tax-class-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tax-class-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tax-class-delete', ['only' => ['destroy']]);
        $this->middleware('permission:tax-class-status', ['only' => ['status']]);
        $this->middleware('permission:tax-class-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:tax-class-restore', ['only' => ['restore']]);
        $this->middleware('permission:tax-class-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request): JsonResponse|View
    {

        if ($request->ajax()) {
            $query = $this->taxClassService->getTaxClasses()
                ->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($tax_class) {
                    return "<span class='badge " . $tax_class->status_color . "'>$tax_class->status_label</span>";
                })
                ->editColumn('created_by', function ($tax_class) {
                    return $tax_class->creater_name;
                })
                ->editColumn('created_at', function ($tax_class) {
                    return $tax_class->created_at_formatted;
                })
                ->editColumn('action', function ($tax_class) {
                    $menuItems = $this->menuItems($tax_class);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.tax_class.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['tax-class-details']
            ],
            [
                'routeName' => 'pm.tax-class.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['tax-class-edit']
            ],
            [
                'routeName' => 'pm.tax-class.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['tax-class-status']
            ],
            [
                'routeName' => 'pm.tax-class.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['tax-class-delete']
            ]

        ];
    }
    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->taxClassService->getTaxClasses()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)

                ->editColumn('status', function ($tax_class) {
                    return "<span class='badge " . $tax_class->status_color . "'>$tax_class->status_label</span>";
                })
                ->editColumn('deleted_by', function ($tax_class) {
                    return $tax_class->deleter_name;
                })
                ->editColumn('deleted_at', function ($tax_class) {
                    return $tax_class->deleted_at_formatted;
                })
                ->editColumn('action', function ($tax_class) {
                    $menuItems = $this->trashedMenuItems($tax_class);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.tax_class.recycle-bin');
    }
    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.tax-class.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['tax-class-restore']
            ],
            [
                'routeName' => 'pm.tax-class.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['tax-class-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.product_management.tax_class.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxClassRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->taxClassService->createTaxClass($validated);
            session()->flash('success', 'Tax Class created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax Class create failed!');
            throw $e;
        }

        return redirect()->route('pm.tax-class.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tax_class = $this->taxClassService->getTaxClass($id);
        $tax_class->load(['creater_admin', 'updater_admin']);
        return response()->json($tax_class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tax_class = $this->taxClassService->getTaxClass($id);
        return view('backend.admin.product_management.tax_class.edit', compact('tax_class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaxClassRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $this->taxClassService->updateTaxClass($id, $validated);
            session()->flash('success', 'Tax Class updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax Class update failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-class.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->taxClassService->deleteTaxClass($id);
            session()->flash('success', 'Tax Class deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax Class delete failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-class.index');
    }
    public function status(string $id): RedirectResponse
    {
        try {
            $this->taxClassService->toggleStatus($id);
            session()->flash('success', 'Tax class status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax class status update failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-class.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->taxClassService->restoreTaxClass($id);
            session()->flash('success', 'Tax class restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax class restore failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-class.recycle-bin');
    }

    public function permanentDelete(string $id): RedirectResponse
    {
         try {
            $this->taxClassService->permanentDeleteTaxClass($id);
            session()->flash('success', 'Tax class permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Tax class permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.tax-class.recycle-bin');
    }
}
