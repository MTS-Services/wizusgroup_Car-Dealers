<?php

namespace App\Http\Controllers\Backend\Admin\ProductManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductManagement\CategoryRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Admin\ProductManagement\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->middleware('auth:admin');
        $this->middleware('permission:category-list', ['only' => ['index']]);
        $this->middleware('permission:category-details', ['only' => ['show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:category-status', ['only' => ['status']]);
        $this->middleware('permission:category-feature', ['only' => ['feature']]);
        $this->middleware('permission:category-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:category-restore', ['only' => ['restore']]);
        $this->middleware('permission:category-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $query = $this->categoryService->getCategories()
                ->isMainCategory()->with(['creater_admin'])
                ->withCount(['activeChildrens']);
            return DataTables::eloquent($query)
                ->editColumn('name', function ($category) {
                    return $category->name . "<sup class='badge bg-info'>$category->active_childrens_count</sup>";
                })
                ->editColumn('status', function ($category) {
                    return "<span class='badge " . $category->status_color . "'>$category->status_label</span>";
                })
                ->editColumn('is_featured', function ($category) {
                    return "<span class='badge " . $category->featured_color . "'>" . $category->featured_label . "</span>";
                })
                ->editColumn('created_by', function ($category) {
                    return $category->creater_name;
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at_formatted;
                })
                ->editColumn('action', function ($category) {
                    $menuItems = $this->menuItems($category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['name', 'status', 'is_featured', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.category.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['category-list']
            ],
            [
                'routeName' => 'pm.category.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['category-edit']
            ],
            [
                'routeName' => 'pm.category.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['category-status']
            ],
            [
                'routeName' => 'pm.category.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['category-feature']
            ],
            [
                'routeName' => 'pm.category.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['category-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->categoryService->getCategories()
                ->with(['deleter_admin'])
                ->withCount(['activeChildrens'])
                ->onlyTrashed()
                ->isMainCategory();
            return DataTables::eloquent($query)
                ->editColumn('name', function ($category) {
                    return $category->name . "<sup class='badge bg-info'>$category->active_childrens_count</sup>";
                })
                ->editColumn('status', function ($category) {
                    return "<span class='badge " . $category->status_color . "'>$category->status_label</span>";
                })
                ->editColumn('is_featured', function ($category) {
                    return "<span class='badge " . $category->featured_color . "'>$category->featured_label</span>";
                })
                ->editColumn('deleted_by', function ($category) {
                    return $category->deleter_name;
                })
                ->editColumn('deleted_at', function ($category) {
                    return $category->deleted_at_formatted;
                })
                ->editColumn('action', function ($category) {
                    $menuItems = $this->trashedMenuItems($category);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['name', 'status', 'is_featured', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.product_management.category.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'pm.category.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['category-restore']
            ],
            [
                'routeName' => 'pm.category.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['category-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.admin.product_management.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->categoryService->createCategory($validated, $request->image ?? null);
            session()->flash('success', 'Category created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category create failed!');
            throw $e;
            session()->flash('error', 'Category create failed!');
        }
        return redirect()->route('pm.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {

        $data = $this->categoryService->getCategory($id);
        $data->load(['creater_admin', 'updater_admin'])->withCount(['activeChildrens']);
        return response()->json($data);
    }

    public function edit(string $id)
    {
        $data['category'] = $this->categoryService->getCategory($id);
        return view('backend.admin.product_management.category.edit', $data);
    }

    public function update(CategoryRequest $request, string $id): RedirectResponse
    {
        try {
            $category = $this->categoryService->getCategory($id);
            $validated = $request->validated();
            $this->categoryService->updateCategory($category, $validated, $request->image ?? null);
            session()->flash('success', 'Category updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category update failed!');
            throw $e;
        }
        return redirect()->route('pm.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $category = $this->categoryService->getCategory($id);
            $this->categoryService->deleteCategory($category);
            session()->flash('success', 'Category deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category delete failed!');
            throw $e;
        }
        return redirect()->route('pm.category.index');
    }

    public function status(string $id): RedirectResponse
    {
        try {
            $category = $this->categoryService->getCategory($id);
            $this->categoryService->toggleStatus($category);
            session()->flash('success', 'Category status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category status update failed!');
            throw $e;
        }
        return redirect()->route('pm.category.index');
    }
    public function feature(string $id): RedirectResponse
    {
        try {
            $category = $this->categoryService->getCategory($id);
            $this->categoryService->toggleFeature($category);
            session()->flash('success', 'Category feature updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category feature update failed!');
            throw $e;
        }
        return redirect()->route('pm.category.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $category = $this->categoryService->getDeletedCategory($id);
            $this->categoryService->restoreCategory($category);
            session()->flash('success', 'Category restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category restore failed!');
            throw $e;
        }
        return redirect()->route('pm.category.recycle-bin');
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
            $category = $this->categoryService->getDeletedCategory($id);
            $this->categoryService->permanentDeleteCategory($category);
            session()->flash('success', 'Category permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Category permanent delete failed!');
            throw $e;
        }
        return redirect()->route('pm.category.recycle-bin');
    }
}
