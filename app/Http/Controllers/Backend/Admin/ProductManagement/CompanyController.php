<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\CompanyRequest;
use App\Services\Admin\ProductManagement\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
   protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {

        $this->companyService = $companyService;

        $this->middleware('auth:admin');
        $this->middleware('permission:company-list', ['only' => ['index']]);
        $this->middleware('permission:company-details', ['only' => ['show']]);
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
        $this->middleware('permission:company-feature', ['only' => ['feature']]);
        $this->middleware('permission:company-status', ['only' => ['status']]);
        $this->middleware('permission:company-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:company-restore', ['only' => ['restore']]);
        $this->middleware('permission:company-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->companyService->getCompanies()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($company) {
                    return "<span class='badge " . $company->status_color . "'>$company->status_label</span>";
                })
                ->editColumn('is_featured', function ($company) {
                    return "<span class='badge " . $company->featured_color . "'>$company->featured_label</span>";
                })
                ->editColumn('created_by', function ($company) {
                    return $company->creater_name;
                })
                ->editColumn('created_at', function ($company) {
                    return $company->created_at_formatted;
                })
                ->editColumn('action', function ($company) {
                    $menuItems = $this->menuItems($company);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.company.index');
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['company-details']
            ],
            [
                'routeName' => 'pm.company.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['company-edit']
            ],
            [
                'routeName' => 'pm.company.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['company-status']
            ],
            [
                'routeName' => 'pm.company.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['company-feature']
            ],
            [
                'routeName' => 'pm.company.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['company-delete']
            ]

        ];
    }



    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->companyService->getCompanies()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($company) {
                    return "<span class='badge " . $company->status_color . "'>$company->status_label</span>";
                })
                ->editColumn('is_featured', function ($company) {
                    return "<span class='badge " . $company->featured_color . "'>$company->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($company) {
                    return $company->deleter_name;
                })
                ->editColumn('deleted_at', function ($company) {
                    return $company->deleted_at_formatted;
                })
                ->editColumn('action', function ($company) {
                    $menuItems = $this->trashedMenuItems($company);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.company.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.company.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['company-restore']
            ],
            [
                'routeName' => 'pm.company.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['company-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.product_management.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request)
    {
        try {
            $validated = $request->validated();
            $fill = $request->$validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->companyService->createCompany($validated, $fill);
            session()->flash('success', 'Company created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company create failed!');
            throw $e;
        }

        return redirect()->route('pm.company.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = $this->companyService->getCompany($id);
        $company->load(['creater_admin', 'updater_admin']);
        return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = $this->companyService->getCompany($id);;
        return view('backend.admin.product_management.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $fill = $request->$validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->companyService->updateCompany($id, $validated, $fill);
            session()->flash('success', 'Company updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company update failed!');
            throw $e;
        }
        return redirect()->route('pm.company.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->companyService->deleteCompany($id);
            session()->flash('success', 'Company deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company delete failed!');
            throw $e;
        }
        return redirect()->route('pm.company.index');
    }


    public function status(string $id): RedirectResponse
    {
        try {
            $this->companyService->toggleStatus($id);
            session()->flash('success', 'Company status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company status update failed!');
            throw $e;
        }
        return redirect()->route('pm.company.index');
    }

    public function feature($id): RedirectResponse
    {
        try {
            $this->companyService->toggleFeature($id);
            session()->flash('success', 'Company feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.company.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->companyService->restoreCompany($id);
            session()->flash('success', 'Company restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company restore failed!');
            throw $e;
        }
        return redirect()->route('pm.company.recycle-bin');
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
            $this->companyService->permanentDeleteCompany($id);
            session()->flash('success', 'Company permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Company permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.company.recycle-bin');
    }
}
