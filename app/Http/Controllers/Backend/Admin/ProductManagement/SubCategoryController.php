<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\SubCategoryRequest;
use App\Models\Documentation;
use App\Services\Admin\ProductManagement\CategoryService;
use Yajra\DataTables\Facades\DataTables;


class SubCategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->middleware('auth:admin');
        $this->middleware('permission:sub-category-list', ['only' => ['index']]);
        $this->middleware('permission:sub-category-details', ['only' => ['show']]);
        $this->middleware('permission:sub-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sub-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sub-category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:sub-category-status', ['only' => ['status']]);
        $this->middleware('permission:sub-category-feature', ['only' => ['feature']]);
        $this->middleware('permission:sub-category-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:sub-category-restore', ['only' => ['restore']]);
        $this->middleware('permission:sub-category-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {

        if ($request->ajax()) {
            $query = $this->categoryService->getCategories()
                ->isSubCategory()->with(['creater_admin', 'parent'])
                ->withCount(['activeChildrens']);
            return DataTables::eloquent($query)
                ->editColumn('parent_id', function ($subcategory) {
                    return $subcategory?->parent?->name;
                })
                ->editColumn('name', function ($subcategory) {
                    return $subcategory->name . "<sup class='badge bg-info'>$subcategory->active_childrens_count</sup>";
                })
                ->editColumn('status', function ($subcategory) {
                    return "<span class='badge " . $subcategory->status_color . "'>$subcategory->status_label</span>";
                })
                ->editColumn('is_featured', function ($subcategory) {
                    return "<span class='badge " . $subcategory->featured_color . "'>" . $subcategory->featured_label . "</span>";
                })
                ->editColumn('created_by', function ($subcategory) {
                    return $subcategory->creater_name;
                })
                ->editColumn('created_at', function ($subcategory) {
                    return $subcategory->created_at_formatted;
                })
                ->editColumn('action', function ($subcategory) {
                    $menuItems = $this->menuItems($subcategory);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['parent_id', 'name', 'status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.sub_category.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['sub-category-list']
            ],
            [
                'routeName' => 'pm.sub-category.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['sub-category-edit']
            ],
            [
                'routeName' => 'pm.sub-category.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['sub-category-status']
            ],
            [
                'routeName' => 'pm.sub-category.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['sub-category-feature']
            ],
            [
                'routeName' => 'pm.sub-category.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['sub-category-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->categoryService->getCategories()
                ->with(['deleter_admin', 'parent'])
                ->onlyTrashed()
                ->isSubCategory()
                ->withCount(['activeChildrens']);
            return DataTables::eloquent($query)
                ->editColumn('parent_id', function ($subcategory) {
                    return $subcategory->parent?->name;
                })
                ->editColumn('name', function ($subcategory) {
                    return $subcategory->name . "<sup class='badge bg-info'>$subcategory->active_childrens_count</sup>";
                })
                ->editColumn('status', function ($subcategory) {
                    return "<span class='badge " . $subcategory->status_color . "'>$subcategory->status_label</span>";
                })
                ->editColumn('is_featured', function ($subcategory) {
                    return "<span class='badge " . $subcategory->featured_color . "'>$subcategory->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($subcategory) {
                    return $subcategory->deleter_name;
                })
                ->editColumn('deleted_at', function ($subcategory) {
                    return $subcategory->deleted_at_formatted;
                })
                ->editColumn('action', function ($subcategory) {
                    $menuItems = $this->trashedMenuItems($subcategory);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['name', 'parent_id', 'status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.sub_category.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.sub-category.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['sub-category-restore']
            ],
            [
                'routeName' => 'pm.sub-category.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['sub-category-permanent-delete']
            ]

        ];
    }

    public function create(): View
    {
        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'sub category'], ['type', 'create']])->first();
        return view('backend.admin.product_management.sub_category.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->categoryService->createCategory($validated, $request->image ?? null);
            session()->flash('success', 'Sub category created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category create failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.index');
    }

    public function show(string $id)
    {
        $data = $this->categoryService->getSubCategory($id);
        $data->load(['parent', 'creater_admin', 'updater_admin'])->withCount(['activeChildrens']);
        $data['parent_name'] = $data?->parent?->name;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data['categories'] = $this->categoryService->getCategories()->isMainCategory()->active()->select(['id', 'name'])->get();
        $data['subcategory'] = $this->categoryService->getSubCategory($id);
        $data['document'] = Documentation::where([['module_key', 'sub category'], ['type', 'update']])->first();
        return view('backend.admin.product_management.sub_category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, string $id)
    {

        try {
            $subcategory = $this->categoryService->getSubCategory($id);
            $validated = $request->validated();
            $this->categoryService->updateCategory($subcategory, $validated, $request->image ?? null);
            session()->flash('success', 'Sub category updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $subcategory = $this->categoryService->getSubCategory($id);
            $this->categoryService->deleteCategory($subcategory);
            session()->flash('success', 'Sub category deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category delete failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.index');
    }

    public function status(string $id): RedirectResponse
    {
        try {
            $subcategory = $this->categoryService->getSubCategory($id);
            $this->categoryService->toggleStatus($subcategory);
            session()->flash('success', 'Sub category status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category status update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.index');
    }
    public function feature(string $id): RedirectResponse
    {
        try {
            $subcategory = $this->categoryService->getSubCategory($id);
            $this->categoryService->toggleFeature($subcategory);
            session()->flash('success', 'Sub category feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $subcategory = $this->categoryService->getDeletedSubCategory($id);
            $this->categoryService->restoreCategory($subcategory);
            session()->flash('success', 'Sub category restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category restore failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.recycle-bin');
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
            $subcategory = $this->categoryService->getDeletedSubCategory($id);
            $this->categoryService->permanentDeleteCategory($subcategory);
            session()->flash('success', 'Sub category permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Sub category permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.sub-category.recycle-bin');
    }
}
