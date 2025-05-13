<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\BannerRequest;
use App\Http\Traits\FileManagementTrait;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{

    use FileManagementTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:banner-list', ['only' => ['index']]);
        $this->middleware('permission:banner-details', ['only' => ['show']]);
        $this->middleware('permission:banner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
        $this->middleware('permission:banner-status', ['only' => ['status']]);
        $this->middleware('permission:banner-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:banner-restore', ['only' => ['restore']]);
        $this->middleware('permission:banner-permanent-delete', ['only' => ['permanentDelete']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $query = Banner::with(['creater_admin'])
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)

                ->editColumn('status', function ($banner) {
                    return "<span class='badge " . $banner->status_color . "'>$banner->status_label</span>";
                })

                ->editColumn('created_by', function ($banner) {
                    return $banner->creater_name;
                })
                ->editColumn('created_at', function ($banner) {
                    return $banner->created_at_formatted;
                })
                ->editColumn('action', function ($banner) {
                    $menuItems = $this->menuItems($banner);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.banner.index');
    }
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['banner-details']
            ],
            [
                'routeName' => 'cms.banner.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['banner-status']
            ],

            [
                'routeName' => 'cms.banner.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['banner-edit']
            ],

            [
                'routeName' => 'cms.banner.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['banner-delete']
            ]

        ];
    }

      public function recycleBin(Request $request)
    {

        if ($request->ajax()) {


            $query = Banner::with(['deleter_admin'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
                ->editColumn('status', function ($banner) {
                    return "<span class='badge " . $banner->status_color . "'>$banner->status_label</span>";
                })
                ->editColumn('deleted_by', function ($banner) {
                    return $banner->deleter_name;
                })
                ->editColumn('deleted_at', function ($banner) {
                    return $banner->deleted_at_formatted;
                })
                ->editColumn('action', function ($banner) {
                    $menuItems = $this->trashedMenuItems($banner);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        };
        return view('backend.admin.cms_management.banner.recycle-bin');
    }
    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.banner.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['banner-restore']
            ],
            [
                'routeName' => 'cms.banner.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['banner-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.cms_management.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = admin()->id;
        if (isset($request->image)) {
            $validated['image'] = $this->handleFilepondFileUpload(Banner::class, $request->image, admin(), 'banners/');
        }
        Banner::create($validated);
        session()->flash('success', 'Banner created successfully!');
        return redirect()->route('cms.banner.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Banner::with(['creater_admin', 'updater_admin'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['banner'] = Banner::findOrFail(decrypt($id));
        return view('backend.admin.cms_management.banner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, string $id)
    {
        $banner = Banner::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updated_by'] = admin()->id;
        if (isset($request->image)) {
            $validated['image'] = $this->handleFilepondFileUpload($banner, $request->image, admin(), 'banners/');
        }
        $banner->update($validated);
        session()->flash('success', 'Banner updated successfully!');
        return redirect()->route('cms.banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail(decrypt($id));
        $banner->update(['deleted_by' => admin()->id]);
        $banner->delete();
        session()->flash('success', 'Banner deleted successfully!');
        return redirect()->route('cms.banner.index');
    }
    public function status(string $id): RedirectResponse
    {
        $banner = Banner::findOrFail(decrypt($id));
        $banner->update(['status' => !$banner->status, 'updated_by' => admin()->id]);
        session()->flash('success', 'Banner status updated successfully!');
        return redirect()->route('cms.banner.index');
    }

    public function restore(string $id): RedirectResponse
    {
        $banner = Banner::onlyTrashed()->findOrFail(decrypt($id));
        $banner->update(['updated_by' => admin()->id]);
        $banner->restore();
        session()->flash('success', 'Banner restored successfully!');
        return redirect()->route('cms.banner.recycle-bin');
    }

    public function permanentDelete(string $id): RedirectResponse
    {
        $banner = Banner::onlyTrashed()->findOrFail(decrypt($id));
        if($banner->image){
            $this->fileDelete($banner->image);
        }
        $banner->forceDelete();
        session()->flash('success', 'Banner permanently deleted successfully!');
        return redirect()->route('cms.banner.recycle-bin');
    }
}
