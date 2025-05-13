<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use FileManagementTrait, DetailsCommonDataTrait;
    public function __construct()
    {
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


            $query = Admin::with(['creater_admin', 'role'])
                ->orderBy('sort_order', 'asc')
                ->latest();
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
                ->editColumn('is_verify', function ($user) {
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
                ->rawColumns(['first_name', 'role_id', 'status', 'is_verify', 'created_by', 'created_at', 'action'])
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


            $query = Admin::with(['deleter_admin', 'role'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
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
                ->editColumn('is_verify', function ($user) {
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
                ->rawColumns(['first_name', 'role_id', 'status', 'is_verify', 'deleted_by', 'deleted_at', 'action'])
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
        $data['roles'] = Role::select(['id', 'name'])->latest()->get();
        return view('backend.admin.admin_management.admin.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): RedirectResponse
    {

        DB::transaction(function () use ($request) {
            try{
                $validated= $request->validated();
                $validated['role_id'] = $request->role;
                $validated['created_by'] = admin()->id;

                if (isset($request->image)) {
                    $validated['image'] = $this->handleFilepondFileUpload(Admin::class, $request->image, admin(), 'admins/');
                }
                $admin = Admin::create($validated);
                $admin->assignRole($admin->role->name);
                session()->flash('success', 'Admin created successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Admin create failed!');
                throw $e;
            }
        });
        return redirect()->route('am.admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = Admin::with(['creater_admin', 'updater_admin', 'role'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['admin'] = Admin::findOrFail(decrypt($id));
        $data['roles'] = Role::select(['id', 'name'])->latest()->get();
        return view('backend.admin.admin_management.admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id): RedirectResponse
    {
        $admin = Admin::findOrFail(decrypt($id));
        if ($admin->role_id == 1 && $request->role != 1) {
            session()->flash('error', 'Can not update Super Admin role!');
            return redirect()->route('am.admin.index');
        }

        DB::transaction(function () use ($request, $id, $admin) {
            try {
                $validated = $request->validated();
                $validated['password'] = ($request->password ? $request->password : $admin->password);
                if (isset($request->image)) {
                    $validated['image'] = $this->handleFilepondFileUpload($admin, $request->image, admin(), 'admins/');
                }
                $validated['role_id'] = $request->role;
                $validated['updated_by'] = admin()->id;
                $admin->update($validated);
                $admin->syncRoles($admin->role->name);
                session()->flash('success', 'Admin updated successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Admin update failed!');
                throw $e;
            }
        });
        return redirect()->route('am.admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $admin = Admin::with('role')->findOrFail(decrypt($id));
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not delete Super Admin!');
            return redirect()->route('am.admin.index');
        }
        $admin->update(['deleted_by' => admin()->id]);
        $admin->delete();
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
        $admin = Admin::findOrFail(decrypt($id));
        if ($admin->role_id == 1) {
            session()->flash('error', 'Can not change Super Admin status!');
            return redirect()->route('am.admin.index');
        }
        $admin->update(['status' => !$admin->status, 'updated_by' => admin()->id]);
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
        $admin = Admin::onlyTrashed()->findOrFail(decrypt($id));
        $admin->update(['updated_by' => admin()->id]);
        $admin->restore();
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
        $admin = Admin::onlyTrashed()->findOrFail(decrypt($id));
        if($admin->image){
            $this->fileDelete($admin->image);
        }
        $admin->forceDelete();
        session()->flash('success', 'Admin permanently deleted successfully!');
        return redirect()->route('am.admin.recycle-bin');
    }
}
