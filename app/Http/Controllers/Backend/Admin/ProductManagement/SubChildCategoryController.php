<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Admin\ProductManagement\CategoryService;
use App\Http\Requests\Admin\ProductManagement\SubChildCategoryRequest;
use App\Models\Documentation;

class SubChildCategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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
            $query =  $this->categoryService->getCategories()
                ->isSubChildCategory()
                ->with(['creater_admin', 'parent.parent']);
            return DataTables::eloquent($query)
                ->editColumn('parent_id', function ($sub_child_category) {
                    return $sub_child_category?->parent?->parent?->name . " > " . $sub_child_category?->parent?->name;
                })
                ->editColumn('status', function ($sub_child_category) {
                    return "<span class='badge " . $sub_child_category->status_color . "'>$sub_child_category->status_label</span>";
                })
                ->editColumn('is_featured', function ($sub_child_category) {
                    return "<span class='badge " . $sub_child_category->featured_color . "'>" . $sub_child_category->featured_label . "</span>";
                })
                ->editColumn('created_by', function ($sub_child_category) {
                    return $sub_child_category->creater_name;
                })
                ->editColumn('created_at', function ($sub_child_category) {
                    return $sub_child_category->created_at_formatted;
                })
                ->editColumn('action', function ($sub_child_category) {
                    $menuItems = $this->menuItems($sub_child_category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['parent_id', 'status', 'is_featured', 'created_by', 'created_at', 'action'])
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
            $query = $this->categoryService->getCategories()
                ->with(['deleter_admin', 'parent.parent'])
                ->onlyTrashed()
                ->isSubChildCategory();
            return DataTables::eloquent($query)
                ->editColumn('parent_id', function ($sub_child_category) {
                    return $sub_child_category?->parent?->parent->name . " > " . $sub_child_category?->parent?->name;
                })
                ->editColumn('status', function ($sub_child_category) {
                    return "<span class='badge " . $sub_child_category->status_color . "'>$sub_child_category->status_label</span>";
                })
                ->editColumn('is_featured', function ($sub_child_category) {
                    return "<span class='badge " . $sub_child_category->featured_color . "'>$sub_child_category->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($sub_child_category) {
                    return $sub_child_category->deleter_name;
                })
                ->editColumn('deleted_at', function ($sub_child_category) {
                    return $sub_child_category->deleted_at_formatted;
                })
                ->editColumn('action', function ($sub_child_category) {
                    $menuItems = $this->trashedMenuItems($sub_child_category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['parent_id', 'status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
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
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'sub child category'], ['type', 'create']])->first();
        return view('backend.admin.product_management.sub_child_category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubChildCategoryRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->categoryService->createCategory($validated, $request->image ?? null);
            session()->flash('success', 'Sub child category created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category create failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.index');
    }

    public function show(string $id)
    {
        $data = $this->categoryService->getSubChildCategory($id);
        $data['parent_name'] = $data?->parent?->parent?->name;
        $data['sub_parent_name'] = $data?->parent?->name;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'sub child category'], ['type', 'update']])->first();
        $data['subcategory'] = $this->categoryService->getSubChildCategory($id);
        return view('backend.admin.product_management.sub_child_category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubChildCategoryRequest $request, string $id)
    {


        try {
            $sub_child_category = $this->categoryService->getSubChildCategory($id);
            $validated = $request->validated();
            $this->categoryService->updateCategory($sub_child_category, $validated, $request->image ?? null);
            session()->flash('success', 'Sub child category updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sub_child_category = $this->categoryService->getSubChildCategory($id);
            $this->categoryService->deleteCategory($sub_child_category);
            session()->flash('success', 'Sub child category deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category delete failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.index');
    }
    public function status(string $id): RedirectResponse
    {
        try {
            $sub_child_category = $this->categoryService->getSubChildCategory($id);
            $this->categoryService->toggleStatus($sub_child_category);
            session()->flash('success', 'Sub child category status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category status update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.index');
    }
    public function feature(string $id): RedirectResponse
    {
        try {
            $sub_child_category = $this->categoryService->getSubChildCategory($id);
            $this->categoryService->toggleFeature($sub_child_category);
            session()->flash('success', 'Sub child category feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $sub_child_category = $this->categoryService->getDeletedSubChildCategory($id);
            $this->categoryService->restoreCategory($sub_child_category);
            session()->flash('success', 'Sub child category restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub child category restore failed!');
            throw $e;
        }
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
        try {
            $sub_child_category = $this->categoryService->getDeletedSubChildCategory($id);
            $this->categoryService->permanentDeleteCategory($sub_child_category);
            session()->flash('success', 'Sub category permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-child-category.recycle-bin');
    }
}
