<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Documentation;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Admin\AdminManagement\PermissionService;
use App\Services\Admin\AdminManagement\RoleService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    protected RoleService $roleService;
    protected PermissionService $permissionService;
    public function __construct( RoleService $roleService , PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->middleware('auth:admin');
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-details', ['only' => ['show']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
        $this->middleware('permission:role-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:role-restore', ['only' => ['restore']]);
        $this->middleware('permission:role-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->roleService->getRoles()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('created_by', function ($role) {
                    return $role->creater_name;
                })
                ->editColumn('created_at', function ($role) {
                    return $role->created_at_formatted;
                })
                ->editColumn('action', function ($role) {
                    $menuItems = $this->menuItems($role);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.role.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['role-list', 'role-delete']
            ],
            [
                'routeName' => 'am.role.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['role-edit']
            ],

            [
                'routeName' => 'am.role.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['role-delete']
            ]
        ];
    }
    // Recycle Bin
    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->roleService->getRoles()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('deleted_by', function ($role) {
                    return $role->deleter_name;
                })
                ->editColumn('deleted_at', function ($role) {
                    return $role->deleted_at_formatted;
                })
                ->editColumn('action', function ($role) {
                    $menuItems = $this->trashedMenuItems($role);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.role.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'am.role.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['role-restore']
            ],
            [
                'routeName' => 'am.role.permanent-delete',
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
        $permissions = $this->permissionService->getPermissions('prefix')->select(['id', 'name', 'prefix'])->get();
        $data['document'] = Documentation::where([['module_key', 'role'], ['type', 'create']])->first();
        $data['groupedPermissions'] = $permissions->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.admin.admin_management.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        try{
            $this->roleService->createRole($request->validated());
            session()->flash('success', 'Role created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Role create failed!');
            throw $e;
        }
        return redirect()->route('am.role.index');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(string $id): JsonResponse
    {
        $data = $this->roleService->getRole($id);
        $data->load(['permissions:id,name,prefix', 'creater_admin', 'updater_admin']);
        $data->permission_names = $data->permissions->pluck('name')->implode(' | ');
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $id = decrypt($id);
        if ($id == 1) {
            session()->flash('error', 'Cannot edit Super Admin!');
            return redirect()->route('am.role.index');
        }
       try{
            $role = $this->roleService->getRole($id);
            $data['role'] = $role->load(['permissions:id,name,prefix']);
            $data['permissions'] = $this->permissionService->getPermissions('prefix')->select(['id', 'name', 'prefix'])->get();
        $data['document'] = Documentation::where([['module_key', 'role'], ['type', 'update']])->first();
            $data['groupedPermissions'] = $data['permissions']->groupBy('prefix');
       } catch (\Throwable $e) {
            session()->flash('error', 'Something went wrong, please try again!');
            throw $e;
        }
        return view('backend.admin.admin_management.role.edit', $data);
    }

    /**
     *
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id): RedirectResponse
    {

        if (decrypt($id) == 1) {
            session()->flash('error', 'Cannot update Super Admin!');
            return redirect()->route('am.role.index');
        }
        try{
            $role = $this->roleService->getRole($id);
            $this->roleService->updateRole($role, $request->validated());
            session()->flash('success','Role updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Role update failed!');
            throw $e;

        }
        return redirect()->route('am.role.index');
    }


    public function destroy(string $id): RedirectResponse
    {
        if (decrypt($id) == 1) {
            session()->flash('error', 'Cannot delete Super Admin!');
            return redirect()->route('am.role.index');
        }
        $this->roleService->delete($id);
        session()->flash('success', 'Role deleted successfully!');
        return redirect()->route('am.role.index');
    }


    public function restore(string $id): RedirectResponse
    {
        $this->roleService->restore($id);
        session()->flash('success', 'Role restored successfully!');
        return redirect()->route('am.role.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $this->roleService->permanentDelete($id);
        session()->flash('success', 'Role permanently deleted successfully!');
        return redirect()->route('am.role.recycle-bin');
    }
}
