<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Backend\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\StateRequest;
use App\Models\Country;
use App\Models\Documentation;
use App\Models\State;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:state-list', ['only' => ['index']]);
        $this->middleware('permission:state-details', ['only' => ['details']]);
        $this->middleware('permission:state-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:state-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:state-delete', ['only' => ['destroy']]);
        $this->middleware('permission:state-status', ['only' => ['status']]);
        $this->middleware('permission:state-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:state-restore', ['only' => ['restore']]);
        $this->middleware('permission:state-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {

        if ($request->ajax()) {
            $query = State::with(['creater_admin', 'country'])
            ->orderBy('sort_order', 'asc')
            ->latest();
            return DataTables::eloquent($query)
                ->editColumn('country_id', function ($state) {
                    return $state->country_name;
                })
                ->editColumn('status', function ($state) {
                    return "<span class='badge " . $state->status_color . "'>$state->status_label</span>";
                })
                ->editColumn('created_by', function ($state) {
                    return $state->creater_name;
                })
                ->editColumn('created_at', function ($state) {
                    return $state->created_at_formatted;
                })
                ->editColumn('action', function ($state) {
                    $menuItems = $this->menuItems($state);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.state.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['state-list']
            ],
            [
                'routeName' => 'setup.state.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['state-edit']
            ],
            [
                'routeName' => 'setup.state.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['state-status']
            ],
            [
                'routeName' => 'setup.state.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['state-delete']
            ]

        ];
    }

        public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = State::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
              ->editColumn('country_id', function ($state) {
                    return $state->country_name;
                })
            ->editColumn('status', function ($state) {
                    return "<span class='badge " . $state->status_color . "'>$state->status_label</span>";
                })

               ->editColumn('deleted_by', function ($state) {
                    return $state->deleter_name;
                })
                ->editColumn('deleted_at', function ($state) {
                    return $state->deleted_at_formatted;
                })
                ->editColumn('action', function ($state) {
                    $menuItems = $this->trashedMenuItems($state);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.state.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.state.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['state-restore']
            ],
            [
                'routeName' => 'setup.state.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['state-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();

        $data['document'] = Documentation::where([['module_key', 'state'], ['type', 'create']])->first();
        return view('backend.admin.setup.state.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['created_by'] = admin()->id;
        State::create($validated);
        session()->flash('success',' state created successfully!');
        return redirect()->route('setup.state.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = State::with(['creater_admin', 'updater_admin', 'country'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['state'] = State::findOrFail(decrypt($id));
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'state'], ['type', 'update']])->first();
        return view('backend.admin.setup.state.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StateRequest $request, string $id)
    {
        $state = State::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updated_by'] = admin()->id;
        $state->update($validated);
        session()->flash('success', 'State updated successfully!');
        return redirect()->route('setup.state.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $state = State::findOrFail(decrypt($id));
        $state->update(['deleted_by' => admin()->id]);
        $state->delete();
        session()->flash('success', 'State deleted successfully!');
        return redirect()->route('setup.state.index');
    }
    public function status(string $id): RedirectResponse
    {
        $state = State::findOrFail(decrypt($id));
        $state->update(['status' => !$state->status, 'updated_by'=> admin()->id]);
        session()->flash('success', ' state status updated successfully!');
        return redirect()->route('setup.state.index');
    }
    public function restore(string $id): RedirectResponse
    {
        $state = State::onlyTrashed()->findOrFail(decrypt($id));
        $state->update(['updated_by' => admin()->id]);
        $state->restore();
        session()->flash('success', 'State restored successfully!');
        return redirect()->route('setup.state.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $state = State::onlyTrashed()->findOrFail(decrypt($id));
        $state->forceDelete();
        session()->flash('success', 'State permanently deleted successfully!');
        return redirect()->route('setup.state.recycle-bin');
    }
}

