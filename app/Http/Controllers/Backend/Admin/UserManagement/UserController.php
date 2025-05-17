<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Admin\UserManagement\UserService;

class UserController extends Controller
{
    use DetailsCommonDataTrait;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

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
            $query = $this->userService->getUsers()
                ->with(['creater']);
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
                'routeName' => 'um.user.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['user-edit']
            ],
            [
                'routeName' => 'um.user.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['user-status']
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
            $query = $this->userService->getUsers()->onlyTrashed()->with(['deleter']);
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
        try {
            $validated = $request->validated();
            $this->userService->createUser($validated, $request->file('image') ?? null);
            session()->flash('success', 'User created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User create failed!');
            throw $e;
        }
        return redirect()->route('um.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = $this->userService->getUser($id);
        $data->load(['creater', 'updater']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data['user'] = $this->userService->getUser($id);
        return view('backend.admin.user_management.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): RedirectResponse
    {
        try {
            $user = $this->userService->getUser($id);
            $validated = $request->validated();
            $this->userService->updateUser($user, $validated, $request->file('image') ?? null);
            session()->flash('success', 'User updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User update failed!');
            throw $e;
        }
        return redirect()->route('um.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $user = $this->userService->getUser($id);
            $this->userService->delete($user);
            session()->flash('success', 'User deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User delete failed!');
            throw $e;
        }
        return redirect()->route('um.user.index');
    }

    public function status(string $id): RedirectResponse
    {
        try {
            $user = $this->userService->getUser($id);
            $this->userService->toggleStatus($user);
            session()->flash('success', 'User status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User status update failed!');
            throw $e;
        }
        return redirect()->route('um.user.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->userService->restore($id);
            session()->flash('success', 'User restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User restore failed!');
            throw $e;
        }
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
        try {
            $this->userService->permanentDelete($id);
            session()->flash('success', 'User permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'User permanent delete failed!');
            throw $e;
        }
        return redirect()->route('um.user.recycle-bin');
    }
}
