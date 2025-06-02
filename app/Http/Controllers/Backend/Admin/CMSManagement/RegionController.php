<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\RegionRequest;
use App\Models\Documentation;
use App\Services\Admin\CMSManagement\RegionsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{
    protected RegionsService $regionService;
    public function __construct(RegionsService $regionService)
    {
        $this->regionService = $regionService;

        $this->middleware('auth:admin');
        $this->middleware('permission:region-list', ['only' => ['index']]);
        $this->middleware('permission:region-details', ['only' => ['show']]);
        $this->middleware('permission:region-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:region-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:region-delete', ['only' => ['destroy']]);
        $this->middleware('permission:region-status', ['only' => ['status']]);
        $this->middleware('permission:region-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:region-restore', ['only' => ['restore']]);
        $this->middleware('permission:region-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->regionService->getRegions()
                ->with(['creater_admin']);
            return DataTables::eloquent($query)

                ->editColumn('status', function ($region) {
                    return "<span class='badge " . $region->status_color . "'>$region->status_label</span>";
                })
                ->editColumn('created_by', function ($region) {
                    return $region->creater_name;
                })
                ->editColumn('created_at', function ($region) {
                    return $region->created_at_formatted;
                })
                ->editColumn('action', function ($region) {
                    $menuItems = $this->menuItems($region);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns([ 'status', 'created_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.region.index');
    }

      protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['region-details']
            ],
            [
                'routeName' => 'cms.region.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['region-edit']
            ],
            [
                'routeName' => 'cms.region.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['region-status']
            ],
            [
                'routeName' => 'cms.region.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['region-delete']
            ]

        ];
    }


       public function recycleBin(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->regionService->getRegions()->onlyTrashed()
                ->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($region) {
                    return "<span class='badge " . $region->status_color . "'>$region->status_label</span>";
                })
                ->editColumn('deleted_by', function ($region) {
                    return $region->deleter_name;
                })
                ->editColumn('deleted_at', function ($region) {
                    return $region->deleted_at_formatted;
                })
                ->editColumn('action', function ($region) {
                    $menuItems = $this->trashedMenuItems($region);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns([ 'status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.region.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.region.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['region-restore']
            ],
            [
                'routeName' => 'cms.region.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['region-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
     public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'region'], ['type', 'create']])->first();
        return view('backend.admin.cms_management.region.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
       public function store(RegionRequest $request): RedirectResponse
    {
      
        try {
            $validated = $request->validated();
            $this->regionService->createRegion($validated);
            session()->flash('success', 'Region created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region create failed!');
            throw $e;
        }

        return redirect()->route('cms.region.index');
    }

    /**
     * Display the specified resource.
     */
    
    public function show(string $id)
    {
        $region = $this->regionService->getRegion($id);
        $region->load(['creater_admin', 'updater_admin']);
        return response()->json($region);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['region'] = $this->regionService->getRegion($id);
        $data['document'] = Documentation::where([['module_key', 'region'], ['type', 'update']])->first();
        return view('backend.admin.cms_management.region.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(RegionRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $this->regionService->updateRegion($id, $validated);
            session()->flash('success', 'Region updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region update failed!');
            throw $e;
        }
        return redirect()->route('cms.region.index');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy(string $id)
    {
        try {
            $this->regionService->delete($id);
            session()->flash('success', 'Region deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region delete failed!');
            throw $e;
        }
        return redirect()->route('cms.region.index');
    }

     public function restore(string $id): RedirectResponse
    {
        try {
            $this->regionService->restore($id);
            session()->flash('success', 'Region restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', value: 'Region restore failed!');
            throw $e;
        }
        return redirect()->route('cms.region.recycle-bin');
    }
    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->regionService->permanentDelete($id);
            session()->flash('success', 'Region permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region permanent delete failed!');
            throw $e;
        }
        return redirect()->route('cms.region.recycle-bin');
    }
     public function status(string $id): RedirectResponse
    {
        try {
            $region = $this->regionService->getRegion($id);
            $this->regionService->toggleStatus($region);
            session()->flash('success', 'Region status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region status update failed!');
            throw $e;
        }
        return redirect()->route('cms.region.index');
    }
}
