<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Http\Traits\FileManagementTrait;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use FileManagementTrait, DetailsCommonDataTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-details', ['only' => ['show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-status', ['only' => ['status']]);
        $this->middleware('permission:user-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:user-restore', ['only' => ['restore']]);
        $this->middleware('permission:user-permanent-delete', ['only' => ['permanentDelete']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = User::with(['creater'])
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
                ->editColumn('first_name', function ($user) {
                    return $user->full_name . ($user->username ? " (" . $user->username . ")" : "");
                })
                ->editColumn('status', function ($user) {
                    return "<span class='badge " . $user->status_color . "'>" . $user->status_label . "</span>";
                })
                ->editColumn('email_verified_at', function ($user) {
                    return "<span class='badge " . $user->verify_color . "'>" . $user->verify_label . "</span>";
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at_formatted;
                })
                ->editColumn('creater_id', function ($user) {
                    return $user->creater_name;
                })
                ->editColumn('action', function ($user) {
                    $menuItems = $this->menuItems($user);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['first_name', 'status', 'email_verified_at', 'created_at', 'creater_id', 'action'])
                ->make(true);
        }
        return view('backend.admin.user_management.user.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['user-details']
            ],
            [
                'routeName' => 'um.user.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['user-status']
            ],
            [
                'routeName' => 'um.user.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['user-edit']
            ],

            [
                'routeName' => 'um.user.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['user-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = User::with(['deleter'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();

            return DataTables::eloquent($query)
                ->editColumn('first_name', function ($user) {
                    return $user->full_name . ($user->username ? " (" . $user->username . ")" : "");
                })
                ->editColumn('status', function ($user) {
                    return "<span class='badge " . $user->status_color . "'>$user->status_label</span>";
                })
                ->editColumn('email_verified_at', function ($user) {
                    return "<span class='badge " . $user->verify_color . "'>" . $user->verify_label . "</span>";
                })
                ->editColumn('deleter_id', function ($user) {
                    return $user->deleter_name;
                })
                ->editColumn('deleted_at', function ($user) {
                    return $user->deleted_at_formatted;
                })
                ->editColumn('action', function ($user) {
                    $menuItems = $this->trashedMenuItems($user);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['first_name', 'status', 'email_verified_at', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.user_management.user.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'um.user.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['user-restore']
            ],
            [
                'routeName' => 'um.user.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['user-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.admin.user_management.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['creater_id'] = admin()->id;
        $validated['creater_type'] = get_class(admin());
        User::create($validated);
        session()->flash('success', 'User created successfully!');
        return redirect()->route('um.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = User::with(['creater', 'updater'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['user'] = User::findOrFail(decrypt($id));
        return view('backend.admin.user_management.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): RedirectResponse
    {
        $user = User::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updater_id'] = admin()->id;
        $validated['password'] = ($request->password ? $request->password : $user->password);
        $validated['updater_type'] = get_class(admin());
        $user->update($validated);
        session()->flash('success', 'User updated successfully!');
        return redirect()->route('um.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail(decrypt($id));
        $user->update(['deleter_id' => admin()->id, 'deleter_type' => get_class(admin())]);
        $user->delete();
        session()->flash('success', 'User deleted successfully!');
        return redirect()->route('um.user.index');
    }

    public function status(string $id): RedirectResponse
    {
        $user = User::findOrFail(decrypt($id));
        $user->update(['status' => !$user->status, 'updater_id' => admin()->id, 'updater_type' => get_class(admin())]);
        session()->flash('success', 'User status updated successfully!');
        return redirect()->route('um.user.index');
    }
    public function restore(string $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail(decrypt($id));
        $user->update(['updated_by' => admin()->id]);
        $user->restore();
        session()->flash('success', 'User restored successfully!');
        return redirect()->route('um.user.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail(decrypt($id));
        $user->forceDelete();
        if($user->image){
            $this->fileDelete($user->image);
        }
        session()->flash('success', 'User permanently deleted successfully!');
        return redirect()->route('um.user.recycle-bin');
    }
}
