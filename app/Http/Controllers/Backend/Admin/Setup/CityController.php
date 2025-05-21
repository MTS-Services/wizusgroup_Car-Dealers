<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\CityRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Documentation;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:city-list', ['only' => ['index']]);
        $this->middleware('permission:city-details', ['only' => ['details']]);
        $this->middleware('permission:city-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
        $this->middleware('permission:city-status', ['only' => ['status']]);
        $this->middleware('permission:city-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:city-restore', ['only' => ['restore']]);
        $this->middleware('permission:city-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = City::with(['creater_admin', 'country', 'state'])
            ->orderBy('sort_order', 'asc')
            ->latest();
            return DataTables::eloquent($query)
                ->editColumn('country_id', function ($city) {
                    return $city->country_name  . ($city->state_name ? "(". $city->state_name .")": "");
                })

                ->editColumn('status', function ($city) {
                    return "<span class='badge " . $city->status_color . "'>$city->status_label</span>";
                })
                ->editColumn('created_by', function ($city) {
                    return $city->creater_name;
                })
                ->editColumn('created_at', function ($city) {
                    return $city->created_at_formatted;
                })
                ->editColumn('action', function ($city) {
                    $menuItems = $this->menuItems($city);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns([ 'country_id','status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.city.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['city-list']
            ],
            [
                'routeName' => 'setup.city.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['city-edit']
            ],
            [
                'routeName' => 'setup.city.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['city-status']
            ],
            [
                'routeName' => 'setup.city.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['city-delete']
            ]

        ];
    }

       public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = City::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
              ->editColumn('country_id', function ($city) {
                    return $city->country_name;
                })
            ->editColumn('status', function ($city) {
                    return "<span class='badge " . $city->status_color . "'>$city->status_label</span>";
                })

               ->editColumn('deleted_by', function ($city) {
                    return $city->deleter_name;
                })
                ->editColumn('deleted_at', function ($city) {
                    return $city->deleted_at_formatted;
                })
                ->editColumn('action', function ($city) {
                    $menuItems = $this->trashedMenuItems($city);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['country_id','status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.city.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.city.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['city-restore']
            ],
            [
                'routeName' => 'setup.city.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['city-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'city'], ['type', 'create']])->first();
        return view('backend.admin.setup.city.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = admin()->id;
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        City::create($validated);
        session()->flash('success','City created successfully!');
        return redirect()->route('setup.city.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = City::with(['creater_admin', 'updater_admin', 'country', 'state'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['city'] = City::findOrFail(decrypt($id));
        $data['countries'] = Country::active()->select('id','name','slug')->orderBy('name')->get();
        $data['document'] = Documentation::where([['module_key', 'city'], ['type', 'update']])->first();
        return view('backend.admin.setup.city.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, string $id): RedirectResponse
    {
        $city = City::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['country_id'] = $request->country;
        $validated['state_id'] = $request->state;
        $validated['updated_by'] = admin()->id;
        $city->update($validated);
        session()->flash('success','City updated successfully!');
        return redirect()->route('setup.city.index');
    }

    public function destroy(string $id): RedirectResponse
    {
        $city = City::findOrFail(decrypt($id));
        $city->update(['deleted_by'=> admin()->id]);
        $city->delete();
        session()->flash('success', 'City deleted successfully!');
        return redirect()->route('setup.city.index');
    }

    public function status(string $id): RedirectResponse
    {
        $city = City::findOrFail(decrypt($id));
        $city->update(['status' => !$city->status, 'updated_by'=> admin()->id]);
        session()->flash('success', 'City status updated successfully!');
        return redirect()->route('setup.city.index');
    }
            public function restore(string $id): RedirectResponse
    {
        $city = City::onlyTrashed()->findOrFail(decrypt($id));
        $city->update(['updated_by' => admin()->id]);
        $city->restore();
        session()->flash('success', 'City restored successfully!');
        return redirect()->route('setup.city.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $city = City::onlyTrashed()->findOrFail(decrypt($id));
        $city->forceDelete();
        session()->flash('success', 'City permanently deleted successfully!');
        return redirect()->route('setup.city.recycle-bin');
    }
}
