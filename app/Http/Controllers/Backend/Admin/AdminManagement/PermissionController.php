<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Models\Permission;
use App\Services\Admin\AdminManagement\PermissionService;
use Illuminate\Http\Request;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    use DetailsCommonDataTrait;
    protected PermissionService $permissionService;
    public function __construct( PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('auth:admin');
        $this->middleware('permission:permission-list', ['only' => ['index']]);
        $this->middleware('permission:permission-details', ['only' => ['show']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
        $this->middleware('permission:permission-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:permission-restore', ['only' => ['restore']]);
        $this->middleware('permission:permission-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->permissionService->getPermissions()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('created_by', function ($permission) {
                    return $permission->creater_name;
                })
                ->editColumn('created_at', function ($permission) {
                    return $permission->created_at_formatted;
                })
                ->editColumn('action', function ($permission) {
                    $menuItems = $this->menuItems($permission);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.permission.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['permission-details']
            ],
            [
                'routeName' => 'am.permission.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['permission-edit']
            ],

            [
                'routeName' => 'am.permission.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['permission-delete']
            ]
        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->getPermissons()->onlyTrashed()->with('deleter_admin');
            return DataTables::eloquent($query)
                ->editColumn('deleted_by', function ($permission) {
                    return $permission->deleter_name;
                })
                ->editColumn('deleted_at', function ($permission) {
                    return $permission->deleted_at_formatted;
                })
                ->editColumn('action', function ($permission) {
                    $menuItems = $this->trashedMenuItems($permission);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.permission.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'am.permission.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['role-restore']
            ],
            [
                'routeName' => 'am.permission.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['role-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.admin.admin_management.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $permission = $this->permissionService->createPermission($validated);
        session()->flash('success', "$permission->name permission created successfully");
        return redirect()->route('am.permission.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->permissionService->getPermission($id);
        $data->load(['creater_admin', 'updater_admin']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['permission'] = $this->permissionService->getPermission($id);
        return view('backend.admin.admin_management.permission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, string $id): RedirectResponse
    {
        $permission = $this->permissionService->getPermission($id);
        $validated = $request->validated();
        $this->permissionService->updatePermission($permission, $validated);
        session()->flash('success', "$permission->name permission updated successfully");
        return redirect()->route('am.permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $permission = $this->permissionService->delete($id);
        session()->flash('success', "$permission->name permission deleted successfully");
        return redirect()->route('am.permission.index');
    }
    public function restore(string $id): RedirectResponse
    {
        $permission = $this->permissionService->restore($id);
        session()->flash('success', $permission->name . ' permission restored successfully!');
        return redirect()->route('am.permission.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $this->permissionService->permanentDelete($id);
        session()->flash('success', 'Permission permanently deleted successfully!');
        return redirect()->route('am.permission.recycle-bin');
    }
}
