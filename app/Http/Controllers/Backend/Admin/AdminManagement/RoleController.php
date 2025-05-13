<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\DetailsCommonDataTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
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
            $query = Role::with(['permissions:id,name,prefix', 'creater_admin'])
                ->orderBy('sort_order', 'asc')
                ->latest();
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
            $query = Role::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
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
        $permissions = Permission::select(['id', 'name', 'prefix'])->orderBy('prefix')->get();
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
        DB::transaction(function () use ($request) {
            try {
                $validated = $request->validated();
                $validated['created_by'] = admin()->id;
                $validated['guard_name'] = 'admin';
                $role = Role::create($validated);
                $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
                $role->givePermissionTo($permissions);
                session()->flash('success', "$role->name role created successfully");
            } catch (\Throwable $e) {
                session()->flash('error', "Role value: create failed!");
                throw $e;
            }
        });
        return redirect()->route('am.role.index');
    }

    // /**
    //  * Display the specified resource.
    //  */
    public function show(string $id): JsonResponse
    {
        $data = Role::with(['permissions:id,name,prefix', 'creater_admin', 'updater_admin'])->findOrFail(decrypt($id));
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
        $data['role'] = Role::with('permissions:id,name,prefix')->findOrFail($id);
        $data['permissions'] = Permission::orderBy('prefix')->get();
        $data['groupedPermissions'] = $data['permissions']->groupBy(function ($permission) {
            return $permission->prefix;
        });
        return view('backend.admin.admin_management.role.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id): RedirectResponse
    {
        $id = decrypt($id);
        if ($id == 1) {
            session()->flash('error', 'Cannot update Super Admin!');
            return redirect()->route('am.role.index');
        }
        DB::transaction(function () use ($request, $id) {
            try {
                $role = Role::findOrFail($id);
                $validated = $request->validated();
                $validated['updated_by'] = admin()->id;
                $validated['guard_name'] = 'admin';
                $role->update($validated);

                $permissions = Permission::whereIn('id', $request->permissions ?? [])->pluck('name')->toArray();
                $role->syncPermissions($permissions);
                session()->flash('success', "$role->name role updated successfully");
            } catch (\Throwable $e) {
                session()->flash('error', "Role update failed!");
                throw $e;
            }
        });
        return redirect()->route('am.role.index');
    }


    public function destroy(string $id): RedirectResponse
    {
        $id = decrypt($id);
        if ($id == 1) {
            session()->flash('error', 'Cannot delete Super Admin!');
            return redirect()->route('am.role.index');
        }
        $role = Role::findOrFail($id);
        $role->update(['deleted_by' => admin()->id]);
        $role->delete();
        session()->flash('success', 'Role deleted successfully!');
        return redirect()->route('am.role.index');
    }


    public function restore(string $id): RedirectResponse
    {
        $role = Role::onlyTrashed()->findOrFail(decrypt($id));
        $role->update(['updated_by' => admin()->id]);
        $role->restore();
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
        $role = Role::onlyTrashed()->findOrFail(decrypt($id));
        $role->forceDelete();
        session()->flash('success', 'Role permanently deleted successfully!');
        return redirect()->route('am.role.recycle-bin');
    }
}
