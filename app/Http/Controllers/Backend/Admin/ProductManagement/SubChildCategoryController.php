<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\SubChildCategoryRequest;
use App\Http\Traits\FileManagementTrait;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubChildCategoryController extends Controller
{
    use FileManagementTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:sub-child-category-list', ['only' => ['index']]);
        $this->middleware('permission:sub-child-category-details', ['only' => ['show']]);
        $this->middleware('permission:sub-child-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sub-child-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sub-child-category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:sub-child-category-status', ['only' => ['status']]);
        $this->middleware('permission:sub-child-category-feature', ['only' => ['feature']]);
        $this->middleware('permission:sub-child-category-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:sub-child-category-restore', ['only' => ['restore']]);
        $this->middleware('permission:sub-child-category-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {

        if ($request->ajax()) {
            $query = Category::isSubChildCategory()->with(['creater', 'parent.parent'])
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
                ->editColumn('parent_id', function ($subcategory) {
                    return $subcategory?->parent?->parent->name . " > " . $subcategory?->parent?->name;
                })
                ->editColumn('status', function ($subcategory) {
                    return "<span class='badge " . $subcategory->status_color . "'>$subcategory->status_label</span>";
                })
                ->editColumn('is_featured', function ($subcategory) {
                    return "<span class='badge " . $subcategory->featured_color . "'>" . $subcategory->featured_label . "</span>";
                })
                ->editColumn('creater_id', function ($subcategory) {
                    return $subcategory->creater_name;
                })
                ->editColumn('created_at', function ($subcategory) {
                    return $subcategory->created_at_formatted;
                })
                ->editColumn('action', function ($subcategory) {
                    $menuItems = $this->menuItems($subcategory);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['parent_id','status', 'is_featured', 'creater_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.sub_child_category.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['sub-child-category-list']
            ],
            [
                'routeName' => 'pm.sub-child-category.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['sub-child-category-edit']
            ],
            [
                'routeName' => 'pm.sub-child-category.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['sub-child-category-status']
            ],
            [
                'routeName' => 'pm.sub-child-category.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['sub-child-category-feature']
            ],
            [
                'routeName' => 'pm.sub-child-category.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['sub-child-category-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = Category::with(['deleter','parent.parent'])
                ->onlyTrashed()
                ->isSubChildCategory()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
               ->editColumn('parent_id', function ($subcategory) {
                    return $subcategory?->parent?->parent->name . " > " . $subcategory?->parent?->name;
                })
                ->editColumn('status', function ($subcategory) {
                    return "<span class='badge " . $subcategory->status_color . "'>$subcategory->status_label</span>";
                })
                ->editColumn('is_featured', function ($subcategory) {
                    return "<span class='badge " . $subcategory->featured_color . "'>$subcategory->featured_label</span>";
                })
                ->editColumn('deleter_id', function ($subcategory) {
                    return $subcategory->deleter_name;
                })
                ->editColumn('deleted_at', function ($subcategory) {
                    return $subcategory->deleted_at_formatted;
                })
                ->editColumn('action', function ($subcategory) {
                    $menuItems = $this->trashedMenuItems($subcategory);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['parent_id','status', 'is_featured', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.sub_child_category.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.sub-child-category.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['sub-child-category-restore']
            ],
            [
                'routeName' => 'pm.sub-child-category.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['sub-child-category-permanent-delete']
            ]

        ];
    }

    public function create(): View
    {
        $data['categories'] = Category::isMainCategory()->active()->latest()->get();
        return view('backend.admin.product_management.sub_child_category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubChildCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['creater_id'] = admin()->id;
        $validated['creater_type'] = get_class(admin());
        if (isset($request->image)) {
            $validated['image'] = $this->handleFilepondFileUpload(Category::class, $request->image, admin(), 'subchildcategories/');
        }
        Category::create($validated);
        session()->flash('success', 'Sub Category created successfully!');
        return redirect()->route('pm.sub-child-category.index');
    }

    public function show(string $id)
    {
        $data = Category::with(['creater', 'updater', 'parent'])->withCount(['activeChildrens'])->findOrFail(decrypt($id));
        $data['parent_name'] = $data?->parent?->parent?->name;
        $data['sub_parent_name'] = $data?->parent?->name;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['categories'] = Category::isMainCategory()->active()->latest()->get();
        $data['subcategory'] = Category::isSubChildCategory()->findOrFail(decrypt($id));
        return view('backend.admin.product_management.sub_child_category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubChildCategoryRequest $request, string $id)
    {

        $subchildcategory = Category::findOrFail(decrypt($id));
        $validated = $request->validated();
        $validated['updater_id'] = admin()->id;
        $validated['updater_type'] = get_class(admin());
        if (isset($request->image)) {
            $validated['image'] = $this->handleFilepondFileUpload($subchildcategory, $request->image, admin(), 'subchildcategories/');
        }
        $subchildcategory->update($validated);
        session()->flash('success', 'Sub child category updated successfully!');
        return redirect()->route('pm.sub-child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subcategory = Category::findOrFail(decrypt($id));
        $subcategory->update(['deleter_id' => admin()->id, 'deleter_type' => get_class(admin())]);
        $subcategory->delete();
        session()->flash('success', 'Sub child category deleted successfully!');
        return redirect()->route('pm.sub-child-category.index');
    }
    public function status(string $id): RedirectResponse
    {
        $subcategory = Category::findOrFail(decrypt($id));
        $subcategory->update(['status' => !$subcategory->status, 'updated_by' => admin()->id]);
        session()->flash('success', 'Sub child category status updated successfully!');
        return redirect()->route('pm.sub-child-category.index');
    }
    public function feature(string $id): RedirectResponse
    {
        $subcategory = Category::findOrFail(decrypt($id));
        $subcategory->update(['is_featured' => !$subcategory->is_featured, 'updated_by' => admin()->id]);
        session()->flash('success', 'Sub child category feature status updated successfully!');
        return redirect()->route('pm.sub-child-category.index');
    }
          public function restore(string $id): RedirectResponse
    {
        $subcategory = Category::onlyTrashed()->findOrFail(decrypt($id));
        $subcategory->update(['updated_by' => admin()->id]);
        $subcategory->restore();
        session()->flash('success', 'Sub child category restored successfully!');
        return redirect()->route('pm.sub-child-category.recycle-bin');
    }

    /**
     * Remove the specified resource from storage permanently.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function permanentDelete(string $id): RedirectResponse
    {
        $subcategory = Category::onlyTrashed()->findOrFail(decrypt($id));
        if($subcategory->image){
            $this->fileDelete($subcategory->image);
        }
        $subcategory->forceDelete();
        session()->flash('success', 'Sub child category permanently deleted successfully!');
        return redirect()->route('pm.sub-child-category.recycle-bin');
    }
}
