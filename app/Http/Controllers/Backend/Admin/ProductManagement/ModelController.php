<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\ModelRequest;
use App\Services\Admin\ProductManagement\BrandService;
use App\Services\Admin\ProductManagement\CompanyService;
use App\Services\Admin\ProductManagement\ModelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModelController extends Controller
{
 protected ModelService $modelService;
 protected CompanyService $companyService;


    public function __construct(ModelService $modelService, CompanyService $companyService)
    {

        $this->modelService = $modelService;
        $this->companyService = $companyService;

        $this->middleware('auth:admin');
        $this->middleware('permission:model-list', ['only' => ['index']]);
        $this->middleware('permission:model-details', ['only' => ['show']]);
        $this->middleware('permission:model-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:model-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:model-delete', ['only' => ['destroy']]);
        $this->middleware('permission:model-feature', ['only' => ['feature']]);
        $this->middleware('permission:model-status', ['only' => ['status']]);
        $this->middleware('permission:model-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:model-restore', ['only' => ['restore']]);
        $this->middleware('permission:model-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->modelService->getModels()->with(['creater_admin','brand','company']);
            return DataTables::eloquent($query)
                ->addColumn('company_id', function ($model) {
                    return $model?->company?->name;
                })
                ->editColumn('brand_id', function ($model) {
                    return $model?->brand?->name;
                })
                ->editColumn('status', function ($model) {
                    return "<span class='badge " . $model->status_color . "'>$model->status_label</span>";
                })
                ->editColumn('is_featured', function ($model) {
                    return "<span class='badge " . $model->featured_color . "'>$model->featured_label</span>";
                })
                ->editColumn('created_by', function ($model) {
                    return $model->creater_name;
                })
                ->editColumn('created_at', function ($model) {
                    return $model->created_at_formatted;
                })
                ->editColumn('action', function ($model) {
                    $menuItems = $this->menuItems($model);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['company_id','brand_id','status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.model.index');
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['model-details']
            ],
            [
                'routeName' => 'pm.model.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['model-edit']
            ],
            [
                'routeName' => 'pm.model.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['model-status']
            ],
            [
                'routeName' => 'pm.model.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['model-feature']
            ],
            [
                'routeName' => 'pm.model.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['model-delete']
            ]

        ];
    }



    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->modelService->getModels()->onlyTrashed()->with(['deleter_admin','brand','company']);
            return DataTables::eloquent($query)
                ->editColumn('company_id', function ($model) {
                    return $model?->company?->name;
                })
                ->editColumn('brand_id', function ($model) {
                    return $model?->brand?->name;
                })
                ->editColumn('status', function ($model) {
                    return "<span class='badge " . $model->status_color . "'>$model->status_label</span>";
                })
                ->editColumn('is_featured', function ($model) {
                    return "<span class='badge " . $model->featured_color . "'>$model->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($model) {
                    return $model->deleter_name;
                })
                ->editColumn('deleted_at', function ($model) {
                    return $model->deleted_at_formatted;
                })
                ->editColumn('action', function ($model) {
                    $menuItems = $this->trashedMenuItems($model);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['company_name','brand_id','status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.model.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.model.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['model-restore']
            ],
            [
                'routeName' => 'pm.model.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['model-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id','name'])->get();
        return view('backend.admin.product_management.model.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModelRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->modelService->createModel($validated, $request->image ?? null);
            session()->flash('success', 'Model created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model create failed!');
            throw $e;
        }

        return redirect()->route('pm.model.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->modelService->getModel($id);
        $data->load(['creater_admin', 'updater_admin', 'brand','company']);
        $data['brand_name'] = $data?->brand?->name;
        $data['company_name'] = $data?->company?->name;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['model'] = $this->modelService->getModel($id);
        $data['companies'] = $this->companyService->getCompanies()->active()->select(['id','name'])->get();
        return view('backend.admin.product_management.model.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModelRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->modelService->updateModel($id, $validated, $request->image ?? null);
            session()->flash('success', 'Model updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model update failed!');
            throw $e;
        }
        return redirect()->route('pm.model.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->modelService->deleteModel($id);
            session()->flash('success', 'Model deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model delete failed!');
            throw $e;
        }
        return redirect()->route('pm.model.index');
    }


    public function status(string $id): RedirectResponse
    {
        try {
            $this->modelService->toggleStatus($id);
            session()->flash('success', 'Model status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model status update failed!');
            throw $e;
        }
        return redirect()->route('pm.model.index');
    }

    public function feature($id): RedirectResponse
    {
        try {
            $this->modelService->toggleFeature($id);
            session()->flash('success', 'Model feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.model.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->modelService->restoreModel($id);
            session()->flash('success', 'Model restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model restore failed!');
            throw $e;
        }
        return redirect()->route('pm.model.recycle-bin');
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
            $this->modelService->permanentDeleteModel($id);
            session()->flash('success', 'Model permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Model permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.model.recycle-bin');
    }
}
