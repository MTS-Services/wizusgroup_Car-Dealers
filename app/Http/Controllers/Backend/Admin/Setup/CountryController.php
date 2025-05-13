<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\CountryRequest;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:country-list', ['only' => ['index']]);
        $this->middleware('permission:country-details', ['only' => ['details']]);
        $this->middleware('permission:country-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
        $this->middleware('permission:country-status', ['only' => ['status']]);
        $this->middleware('permission:country-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:country-restore', ['only' => ['restore']]);
        $this->middleware('permission:country-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    if ($request->ajax()) {
        $query = Country::with(['creater_admin'])
        ->orderBy('sort_order', 'asc')
        ->latest();
        return DataTables::eloquent($query)
            ->editColumn('status', function ($country) {
                return "<span class='badge " . $country->status_color . "'>$country->status_label</span>";
            })
            ->editColumn('created_by', function ($country) {
                return $country->creater_name;
            })
            ->editColumn('created_at', function ($country) {
                return $country->created_at_formatted;
            })
            ->editColumn('action', function ($country) {
                $menuItems = $this->menuItems($country);
                return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
            })
            ->rawColumns([ 'status', 'created_by', 'created_at', 'action'])
            ->make(true);
    }
        return view('backend.admin.setup.country.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['country-list']
            ],
            [
                'routeName' => 'setup.country.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['country-edit']
            ],
            [
                'routeName' => 'setup.country.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['country-status']
            ],
            [
                'routeName' => 'setup.country.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['country-delete']
            ]

        ];
    }
       public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = Country::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
            ->editColumn('status', function ($country) {
                    return "<span class='badge " . $country->status_color . "'>$country->status_label</span>";
                })

               ->editColumn('deleted_by', function ($country) {
                    return $country->deleter_name;
                })
                ->editColumn('deleted_at', function ($country) {
                    return $country->deleted_at_formatted;
                })
                ->editColumn('action', function ($country) {
                    $menuItems = $this->trashedMenuItems($country);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.country.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.country.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['country-restore']
            ],
            [
                'routeName' => 'setup.country.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['Country-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.setup.country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        $validated= $request->validated();
        $validated['created_by'] = admin()->id;
        Country::create($validated);
        session()->flash('success','Country created successfully!');
        return redirect()->route('setup.country.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $data = Country::with(['creater_admin', 'updater_admin'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['country'] = Country::findOrFail(decrypt($id));
        return view('backend.admin.setup.country.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, string $id)
    {
        $country= Country::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updated_by'] = admin()->id;
        $country->update($validated);
        session()->flash('success','Country updated successfully!');
        return redirect()->route('setup.country.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail(decrypt($id));
        $country->update(['deleted_by'=> admin()->id]);
        $country->delete();
        session()->flash('success', 'Country deleted successfully!');
        return redirect()->route('setup.country.index');
    }

    public function status(string $id): RedirectResponse
    {
        $country = Country::findOrFail(decrypt($id));
        $country->update(['status' => !$country->status, 'updated_by'=> admin()->id]);
        session()->flash('success', 'Country status updated successfully!');
        return redirect()->route('setup.country.index');
    }
          public function restore(string $id): RedirectResponse
    {
        $country = Country::onlyTrashed()->findOrFail(decrypt($id));
        $country->update(['updated_by' => admin()->id]);
        $country->restore();
        session()->flash('success', 'country restored successfully!');
        return redirect()->route('setup.country.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $country = Country::onlyTrashed()->findOrFail(decrypt($id));
        $country->forceDelete();
        session()->flash('success', 'Country permanently deleted successfully!');
        return redirect()->route('setup.country.recycle-bin');
    }
}
