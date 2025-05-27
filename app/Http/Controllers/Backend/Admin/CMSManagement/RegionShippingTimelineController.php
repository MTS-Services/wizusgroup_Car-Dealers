<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\RegionShippingTimelineRequest;
use App\Models\Documentation;
use App\Models\Region;
use App\Services\Admin\CMSManagement\RegionShippingTimelineService;
use App\Services\Admin\CMSManagement\RegionsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegionShippingTimelineController extends Controller
{
    protected RegionShippingTimelineService $regionShippingTimelineService;
    protected RegionsService $regionService;
    public function __construct(RegionShippingTimelineService $regionShippingTimelineService, RegionsService $regionService)
    {
        $this->regionShippingTimelineService = $regionShippingTimelineService;
        $this->regionService = $regionService;

        $this->middleware('auth:admin');
        $this->middleware('permission:region-shipping-timeline-list', ['only' => ['index']]);
        $this->middleware('permission:region-shipping-timeline-details', ['only' => ['show']]);
        $this->middleware('permission:region-shipping-timeline-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:region-shipping-timeline-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:region-shipping-timeline-delete', ['only' => ['destroy']]);
        $this->middleware('permission:region-shipping-timeline-status', ['only' => ['status']]);
        $this->middleware('permission:region-shipping-timeline-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:region-shipping-timeline-restore', ['only' => ['restore']]);
        $this->middleware('permission:region-shipping-timeline-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->regionShippingTimelineService->getRegionShippingTimelines()->with(['creater_admin', 'region']);
            return DataTables::eloquent($query)
                ->editColumn('region_id', function ($region) {
                    return $region?->region?->name;
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
                ->rawColumns(['created_at', 'region_id', 'created_by', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.region_shipping_timeline.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['region-shipping-timeline-details']
            ],
            [
                'routeName' => 'cms.region-shipping-timeline.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['region-shipping-timeline-edit']
            ],
            [
                'routeName' => 'cms.region-shipping-timeline.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['region-shipping-timeline-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->regionShippingTimelineService->getRegionShippingTimelines()->onlyTrashed()
                ->with(['deleter_admin', 'region']);
            return DataTables::eloquent($query)
                ->editColumn('region_id', function ($region) {
                    return $region?->region?->name;
                })
                ->editColumn('deleted_by', function ($region) {
                    return $region->deleter_admin?->name;
                })
                ->editColumn('deleted_at', function ($region) {
                    return $region->deleted_at_formatted;
                })
                ->editColumn('action', function ($region) {
                    $menuItems = $this->trashedMenuItems($region);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['deleted_by', 'region_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.region_shipping_timeline.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.region-shipping-timeline.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['region-shipping-timeline-restore']
            ],
            [
                'routeName' => 'cms.region-shipping-timeline.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['region-shipping-timeline-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['regions'] = Region::select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'region shipping timeline'], ['type', 'create']])->first();
        return view('backend.admin.cms_management.region_shipping_timeline.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionShippingTimelineRequest $request): RedirectResponse
    {

        try {
            $validated = $request->validated();
            $this->regionShippingTimelineService->createRegionShippingTimeline($validated);
            session()->flash('success', 'Region Shipping Timeline created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region Shipping Timeline create failed!');
            throw $e;
        }

        return redirect()->route('cms.region-shipping-timeline.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = $this->regionShippingTimelineService->getRegionShippingTimeline($id);
        $region->load(['creater_admin', 'updater_admin', 'region']);
        return response()->json($region);
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
    {
        $data['regions'] = $this->regionService->getRegions()->select(['id', 'name'])->get();
        $data['region_shipping_timeline'] = $this->regionShippingTimelineService->getRegionShippingTimeline($id);
        $data['document'] = Documentation::where([['module_key', 'region shipping timeline'], ['type', 'update']])->first();
        return view('backend.admin.cms_management.region_shipping_timeline.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(RegionShippingTimelineRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->regionShippingTimelineService->updateRegionShippingTimeline($id, $validated);
            session()->flash('success', 'Region Shipping Timeline updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region Shipping Timeline update failed!');
            throw $e;
        }
        return redirect()->route('cms.region-shipping-timeline.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->regionShippingTimelineService->delete($id);
            session()->flash('success', 'Region Shipping Timeline deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region Shipping Timeline delete failed!');
            throw $e;
        }
        return redirect()->route('cms.region-shipping-timeline.index');
    }

     public function restore(string $id): RedirectResponse
    {
        try {
            $this->regionShippingTimelineService->restore($id);
            session()->flash('success', 'Region Shipping Timeline restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', value: 'Region Shipping Timeline restore failed!');
            throw $e;
        }
        return redirect()->route('cms.region-shipping-timeline.recycle-bin');
    }
    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->regionShippingTimelineService->permanentDelete($id);
            session()->flash('success', 'Region Shipping Timeline permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Region Shipping Timeline permanent delete failed!');
            throw $e;
        }
        return redirect()->route('cms.region-shipping-timeline.recycle-bin');
    }
}
