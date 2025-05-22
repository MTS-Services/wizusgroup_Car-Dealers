<?php


    namespace App\Http\Controllers\Backend\Admin\CMSManagement;

    use App\Models\Banner;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Http\Traits\FileManagementTrait;
    use Yajra\DataTables\Facades\DataTables;
    use App\Http\Requests\Admin\ProductManagement\BannerRequest;
    use App\Services\Admin\CMSManagement\BannerService;
    use Illuminate\Http\RedirectResponse;


    class BannerController extends Controller

    {
        protected BannerService $bannerService;

        public function __construct(BannerService $bannerService)
        {

            $this->bannerService = $bannerService;

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
                $query = $this->bannerService->getBanners()->with(['creater_admin']);
                return DataTables::eloquent($query)
                    ->editColumn('status', function ($banner) {
                        return "<span class='badge " . $banner->status_color . "'>$banner->status_label</span>";
                    })
                    ->editColumn('is_featured', function ($banner) {
                        return "<span class='badge " . $banner->featured_color . "'>$banner->featured_label</span>";
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
                    ->rawColumns(['status', 'is_featured', 'created_by', 'created_at', 'action'])
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
                    'routeName' => 'cms.banner.edit',
                    'params' => [encrypt($model->id)],
                    'label' => 'Edit',
                    'permissions' => ['banner-edit']
                ],
                [
                    'routeName' => 'cms.banner.status',
                    'params' => [encrypt($model->id)],
                    'label' => $model->status_btn_label,
                    'permissions' => ['banner-status']
                ],
                // [
                //     'routeName' => 'cms.banner.feature',
                //     'params' => [encrypt($model->id)],
                //     'label' => $model->featured_btn_label,
                //     'permissions' => ['banner-feature']
                // ],
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
                $query = $this->bannerService->getBanners()->onlyTrashed()->with(['deleter_admin']);
                return DataTables::eloquent($query)
                    ->editColumn('status', function ($banner) {
                        return "<span class='badge " . $banner->status_color . "'>$banner->status_label</span>";
                    })
                    ->editColumn('is_featured', function ($banner) {
                        return "<span class='badge " . $banner->featured_color . "'>$banner->featured_label</span>";
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
                    ->rawColumns(['status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                    ->make(true);
            }
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

            try {
                $validated = $request->validated();
                $this->bannerService->createBanner($validated, $request->image ?? null);
                session()->flash('success', 'Banner created successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner create failed!');
                throw $e;
            }

            return redirect()->route('cms.banner.index');
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $banner = $this->bannerService->getBanner($id);

            $banner->load(['creater_admin', 'updater_admin']);
            return response()->json($banner);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $data['banner'] = $this->bannerService->getBanner($id);;
            return view('backend.admin.cms_management.Banner.edit', $data);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(BannerRequest $request, string $id)
        {

            try {
                $validated = $request->validated();
                $this->bannerService->updateBanner($id, $validated, $request->image ?? null);
                session()->flash('success', 'Banner updated successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner update failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.index');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            try {
                $this->bannerService->deleteBanner($id);
                session()->flash('success', 'Banner deleted successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner delete failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.index');
        }


        public function status(string $id): RedirectResponse
        {
            try {
                $this->bannerService->toggleStatus($id);
                session()->flash('success', 'Banner status updated successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner status update failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.index');
        }

        public function feature($id): RedirectResponse
        {
            try {
                $this->bannerService->toggleFeature($id);
                session()->flash('success', 'Banner feature updated successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner feature update failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.index');
        }
        public function restore(string $id): RedirectResponse
        {
            try {
                $this->bannerService->restoreBanner($id);
                session()->flash('success', 'Banner restored successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner restore failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.recycle-bin');
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
                $this->bannerService->permanentDeleteBanner($id);
                session()->flash('success', 'Banner permanently deleted successfully!');
            } catch (\Throwable $e) {
                session()->flash('error', 'Banner permanent delete failed!');
                throw $e;
            }
            return redirect()->route('cms.banner.recycle-bin');
        }
    }
