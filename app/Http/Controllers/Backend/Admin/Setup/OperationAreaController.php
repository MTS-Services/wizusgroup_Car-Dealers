<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\OperationAreaRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Documentation;
use App\Models\OperationArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperationAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:operation-area-list', ['only' => ['index']]);
        $this->middleware('permission:operation-area-details', ['only' => ['details']]);
        $this->middleware('permission:operation-area-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:operation-area-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:operation-area-delete', ['only' => ['destroy']]);
        $this->middleware('permission:operation-area-status', ['only' => ['status']]);
        $this->middleware('permission:operation-area-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:operation-area-restore', ['only' => ['restore']]);
        $this->middleware('permission:operation-area-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = OperationArea::with(['creater_admin','city','country','state'])
            ->orderBy('sort_order', 'asc')
            ->latest();
            return DataTables::eloquent($query)
                ->editColumn('country_id', function ($operationArea) {
                    return $operationArea->country_name . ($operationArea->state_name ? "(". $operationArea->state_name .")": "");
                })
                ->editColumn('city_id', function ($operationArea) {
                    return  $operationArea->city_name;
                })
                ->editColumn('status', function ($operationArea) {
                    return "<span class='badge " . $operationArea->status_color . "'>$operationArea->status_label</span>";
                })
                ->editColumn('created_by', function ($operationArea) {
                    return $operationArea->creater_name;
                })
                ->editColumn('created_at', function ($operationArea) {
                    return $operationArea->created_at_formatted;
                })
                ->editColumn('action', function ($operationArea) {
                    $menuItems = $this->menuItems($operationArea);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','city_id','status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.operation_area.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['operation-area-list']
            ],
            [
                'routeName' => 'setup.operation-area.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['operation-area-edit']
            ],
            [
                'routeName' => 'setup.operation-area.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['operation-area-status']
            ],
            [
                'routeName' => 'setup.operation-area.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['operation-area-delete']
            ]

        ];
    }



        public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = OperationArea::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
              ->editColumn('country_id', function ($operationArea) {
                    return $operationArea->country_name;
                })
                ->editColumn('city_id', function ($operationArea) {
                    return  $operationArea->city_name;
                })
            ->editColumn('status', function ($operationArea) {
                    return "<span class='badge " . $operationArea->status_color . "'>$operationArea->status_label</span>";
                })

               ->editColumn('deleted_by', function ($operationArea) {
                    return $operationArea->deleter_name;
                })
                ->editColumn('deleted_at', function ($operationArea) {
                    return $operationArea->deleted_at_formatted;
                })
                ->editColumn('action', function ($operationArea) {
                    $menuItems = $this->trashedMenuItems($operationArea);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','city_id','status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.operation_area.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.operation-area.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['operation-area-restore']
            ],
            [
                'routeName' => 'setup.operation-area.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['operation-area-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'operation area'], ['type', 'create']])->first();
        return view('backend.admin.setup.operation_area.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperationAreaRequest $request)
    {
        $validated = $request->validated();
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city;
        $validated['created_by'] = admin()->id;
        OperationArea::create($validated);
        session()->flash('success','Operation area created successfully!');
        return redirect()->route('setup.operation-area.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = OperationArea::with(['creater_admin', 'updater_admin','city','country','state'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['operation_area'] = OperationArea::findOrFail(decrypt($id));
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'operation area'], ['type', 'update']])->first();
        return view('backend.admin.setup.operation_area.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperationAreaRequest $request, string $id): RedirectResponse
    {
        $operation_area = OperationArea::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city;
        $validated['updated_by'] = admin()->id;
        $operation_area->update($validated);
        session()->flash('success','Operation area updated successfully!');
        return redirect()->route('setup.operation-area.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $operation_area = OperationArea::findOrFail(decrypt($id));
        $operation_area->update(['deleted_by'=> admin()->id]);
        $operation_area->delete();
        session()->flash('success', 'Operation area deleted successfully!');
        return redirect()->route('setup.operation-area.index');
    }

    public function status(string $id): RedirectResponse
    {
        $operation_area = OperationArea::findOrFail(decrypt($id));
        $operation_area->update(['status' => !$operation_area->status, 'updated_by'=> admin()->id]);
        session()->flash('success', 'Operation area status updated successfully!');
        return redirect()->route('setup.operation-area.index');
    }
           public function restore(string $id): RedirectResponse
    {
        $operation_area = OperationArea::onlyTrashed()->findOrFail(decrypt($id));
        $operation_area->update(['updated_by' => admin()->id]);
        $operation_area->restore();
        session()->flash('success', 'Operation Area restored successfully!');
        return redirect()->route('setup.operation-area.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $operation_area = OperationArea::onlyTrashed()->findOrFail(decrypt($id));
        $operation_area->forceDelete();
        session()->flash('success', 'Operation Area permanently deleted successfully!');
        return redirect()->route('setup.operation-area.recycle-bin');
    }
}
