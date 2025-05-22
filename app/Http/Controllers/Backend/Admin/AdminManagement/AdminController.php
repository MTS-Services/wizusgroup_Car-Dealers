<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Services\Admin\AdminManagement\AdminService;
use App\Services\Admin\AdminManagement\RoleService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    protected AdminService $adminService;
    protected RoleService $roleService;
    public function __construct(AdminService $adminService, RoleService $roleService)
    {

        $this->adminService = $adminService;
        $this->roleService = $roleService;

        $this->middleware('auth:admin');
        $this->middleware('permission:admin-list', ['only' => ['index']]);
        $this->middleware('permission:admin-details', ['only' => ['show']]);
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
        $this->middleware('permission:admin-status', ['only' => ['status']]);
        $this->middleware('permission:admin-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:admin-restore', ['only' => ['restore']]);
        $this->middleware('permission:admin-permanent-delete', ['only' => ['permanentDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->adminService->getAdmins()->with(['creater_admin', 'role']);
            return DataTables::eloquent($query)

                ->editColumn('first_name', function ($admin) {
                    return $admin->full_name . ($admin->username ? " (" . $admin->username . ")" : "");
                })
                ->editColumn('role_id', function ($admin) {
                    return optional($admin->role)->name;
                })
                ->editColumn('status', function ($admin) {
                    return "<span class='badge " . $admin->status_color . "'>$admin->status_label</span>";
                })
                ->editColumn('email_verified_at', function ($user) {
                    return "<span class='badge " . $user->verify_color . "'>" . $user->verify_label . "</span>";
                })
                ->editColumn('created_by', function ($admin) {
                    return $admin->creater_name;
                })
                ->editColumn('created_at', function ($admin) {
                    return $admin->created_at_formatted;
                })
                ->editColumn('action', function ($admin) {
                    $menuItems = $this->menuItems($admin);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['first_name', 'role_id', 'status', 'email_verified_at', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.admin.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['admin-details']
            ],
            [
                'routeName' => 'am.admin.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['admin-status']
            ],
            [
                'routeName' => 'am.admin.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['admin-edit']
            ],

            [
                'routeName' => 'am.admin.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['admin-delete']
            ]

        ];
    }


    /**
     * Shows the list of soft deleted admins and also handles the Datatable AJAX request.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->adminService->getAdmins()->onlyTrashed()->with(['deleter_admin', 'role']);
            return DataTables::eloquent($query)
                ->editColumn('first_name', function ($admin) {
                    return $admin->full_name . ($admin->username ? " (" . $admin->username . ")" : "");
                })
                ->editColumn('role_id', function ($admin) {
                    return optional($admin->role)->name;
                })
                ->editColumn('status', function ($admin) {
                    return "<span class='badge " . $admin->status_color . "'>$admin->status_label</span>";
                })
                ->editColumn('email_verified_at', function ($user) {
                    return "<span class='badge " . $user->verify_color . "'>" . $user->verify_label . "</span>";
                })
                ->editColumn('deleted_by', function ($admin) {
                    return $admin->deleter_name;
                })
                ->editColumn('deleted_at', function ($admin) {
                    return $admin->deleted_at_formatted;
                })
                ->editColumn('action', function ($admin) {
                    $menuItems = $this->trashedMenuItems($admin);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['first_name', 'role_id', 'status', 'email_verified_at', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.admin_management.admin.recycle-bin');
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
                'routeName' => 'am.admin.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['admin-restore']
            ],
            [
                'routeName' => 'am.admin.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['admin-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['roles'] = $this->roleService->getRoles()->select(['id','name'])->get();
        return view('backend.admin.admin_management.admin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): RedirectResponse
    {
         try {
            $validated = $request->validated();
            $validated['role_id'] = $request->role;
            $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->adminService->createAdmin($validated, $file);
            session()->flash('success', 'Admin created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Admin create failed!');
            throw $e;
        }
        return redirect()->route('am.admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->adminService->getAdmin($id);
        $data->load(['creater_admin', 'updater_admin','role']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['admin'] = $this->adminService->getAdmin($id);
        $data['roles'] = $this->roleService->getRoles()->select('id','name')->get();
        return view('backend.admin.admin_management.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id): RedirectResponse
    {
        try {
            $admin = $this->adminService->getAdmin($id);
            $validated = $request->validated();
            $validated['role_id'] = $request->role;
            $file = $request->validated('image') &&  $request->hasFile('image') ? $request->file('image') : null;
            $this->adminService->updateAdmin($admin,$validated,  $file);
            session()->flash('success', 'Admin updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Admin update failed!');
            throw $e;
        }
        return redirect()->route('am.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $admin = $this->adminService->getAdmin($id);
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not delete Super Admin!');
            return redirect()->route('am.admin.index');
        }
        $this->adminService->delete( $admin);
        session()->flash('success', 'Admin move to recycle bin successfully!');
        return redirect()->route('am.admin.index');
    }

    /**
     * Update the specified resource status in storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function status(string $id): RedirectResponse
    {
        $admin = $this->adminService->getAdmin($id);
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not change Super Admin status!');
            return redirect()->route('am.admin.index');
        }
        $this->adminService->toggleStatus($admin);
        session()->flash('success', 'Admin status updated successfully!');
        return redirect()->route('am.admin.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function restore(string $id): RedirectResponse
    {
        $this->adminService->restore( $id );
        session()->flash('success', 'Admin restored successfully!');
        return redirect()->route('am.admin.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
       $this->adminService->permanentDelete( $id );
        session()->flash('success', 'Admin permanently deleted successfully!');
        return redirect()->route('am.admin.recycle-bin');
    }
}
