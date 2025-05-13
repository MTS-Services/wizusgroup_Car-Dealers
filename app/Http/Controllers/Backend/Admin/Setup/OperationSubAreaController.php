<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\OperationSubAreaRequest;
use App\Models\Country;
use App\Models\OperationSubArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperationSubAreaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:operation-sub-area-list', ['only' => ['index']]);
        $this->middleware('permission:operation-sub-area-details', ['only' => ['details']]);
        $this->middleware('permission:operation-sub-area-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:operation-sub-area-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:operation-sub-area-delete', ['only' => ['destroy']]);
        $this->middleware('permission:operation-sub-area-status', ['only' => ['status']]);
        $this->middleware('permission:operation-sub-area-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:operation-sub-area-restore', ['only' => ['restore']]);
        $this->middleware('permission:operation-sub-area-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = OperationSubArea::with(['creater_admin','city','country','state','operationArea'])
            ->orderBy('sort_order', 'asc')
                ->latest();
                return DataTables::eloquent($query)
                ->editColumn('country_id', function ($operationSubArea) {
                    return $operationSubArea->country_name . ($operationSubArea->state_name ? "(". $operationSubArea->state_name .")": "");
                })
                ->editColumn('city_id', function ($operationSubArea) {
                    return  $operationSubArea->city_name;
                })
                ->editColumn('operation_area_id', function ($operationSubArea) {
                    return  $operationSubArea->operation_area_name;
                })
                ->editColumn('status', function ($operationSubArea) {
                    return "<span class='badge " . $operationSubArea->status_color . "'>$operationSubArea->status_label</span>";
                })
                ->editColumn('created_by', function ($operationSubArea) {
                    return $operationSubArea->creater_name;
                })
                ->editColumn('created_at', function ($operationSubArea) {
                    return $operationSubArea->created_at_formatted;
                })
                ->editColumn('action', function ($operationSubArea) {
                    $menuItems = $this->menuItems($operationSubArea);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','city_id','operation_area_id','status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.operation_sub_area.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['operation-sub-area-list']
            ],
            [
                'routeName' => 'setup.operation-sub-area.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['operation-sub-area-edit']
            ],
            [
                'routeName' => 'setup.operation-sub-area.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['operation-sub-area-status']
            ],
            [
                'routeName' => 'setup.operation-sub-area.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['operation-sub-area-delete']
            ]

        ];
    }


        public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = OperationSubArea::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
              ->editColumn('country_id', function ($operationSubArea) {
                    return $operationSubArea->country_name;
                })
                ->editColumn('city_id', function ($operationSubArea) {
                    return  $operationSubArea->city_name;
                })
                 ->editColumn('operation_area_id', function ($operationSubArea) {
                    return  $operationSubArea->operation_area_name;
                })
            ->editColumn('status', function ($operationSubArea) {
                    return "<span class='badge " . $operationSubArea->status_color . "'>$operationSubArea->status_label</span>";
                })

               ->editColumn('deleted_by', function ($operationSubArea) {
                    return $operationSubArea->deleter_name;
                })
                ->editColumn('deleted_at', function ($operationSubArea) {
                    return $operationSubArea->deleted_at_formatted;
                })
                ->editColumn('action', function ($operationSubArea) {
                    $menuItems = $this->trashedMenuItems($operationSubArea);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','city_id', 'operation_area_id', 'status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.operation_sub_area.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.operation-sub-area.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['operation-sub-area-restore']
            ],
            [
                'routeName' => 'setup.operation-sub-area.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['operation-sub-area-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        return view('backend.admin.setup.operation_sub_area.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OperationSubAreaRequest $request)
    {
        $validated = $request->validated();
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city;
        $validated['operation_area_id'] = $request->operation_area;
        $validated['created_by'] = admin()->id;
        OperationSubArea::create($validated);
        session()->flash('success','Operation sub area created successfully!');
        return redirect()->route('setup.operation-sub-area.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = OperationSubArea::with(['creater_admin', 'updater_admin','city','country','state','operationArea'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['operation_sub_area'] = OperationSubArea::findOrFail(decrypt($id));
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        return view('backend.admin.setup.operation_sub_area.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OperationSubAreaRequest $request, string $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        $validated['city_id'] = $request->city;
        $validated['operation_area_id'] = $request->operation_area;
        $validated['updated_by'] = admin()->id;
        $operation_sub_area->update($validated);
        session()->flash('success','Operation sub area updated successfully!');
        return redirect()->route('setup.operation-sub-area.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail(decrypt($id));
        $operation_sub_area->update(['deleted_by'=> admin()->id]);
        $operation_sub_area->delete();
        session()->flash('success', 'Operation sub area deleted successfully!');
        return redirect()->route('setup.operation-sub-area.index');
    }

    public function status(string $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::findOrFail(decrypt($id));
        $operation_sub_area->update(['status' => !$operation_sub_area->status, 'updated_by'=> admin()->id]);
        session()->flash('success', 'Operation sub area status updated successfully!');
        return redirect()->route('setup.operation-sub-area.index');
    }
           public function restore(string $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::onlyTrashed()->findOrFail(decrypt($id));
        $operation_sub_area->update(['updated_by' => admin()->id]);
        $operation_sub_area->restore();
        session()->flash('success', 'Operation Sub Area restored successfully!');
        return redirect()->route('setup.operation-sub-area.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $operation_sub_area = OperationSubArea::onlyTrashed()->findOrFail(decrypt($id));
        $operation_sub_area->forceDelete();
        session()->flash('success', 'Operation Sub Area permanently deleted successfully!');
        return redirect()->route('setup.operation-sub-area.recycle-bin');
    }
}
