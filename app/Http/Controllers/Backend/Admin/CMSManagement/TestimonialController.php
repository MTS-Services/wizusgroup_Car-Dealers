<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\TestimonialRequest;
use App\Services\Admin\CMSManagement\TestimonialService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    protected TestimonialService $testimonialService;
    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;

        $this->middleware('auth:admin');
        $this->middleware('permission:testimonial-list', ['only' => ['index']]);
        $this->middleware('permission:testimonial-details', ['only' => ['show']]);
        $this->middleware('permission:testimonial-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);
        $this->middleware('permission:testimonial-status', ['only' => ['status']]);
        $this->middleware('permission:testimonial-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:testimonial-restore', ['only' => ['restore']]);
        $this->middleware('permission:testimonial-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->testimonialService->getTestimonials()
                ->with(['creater']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($testimonial) {
                    return "<span class='badge " . $testimonial->status_color . "'>" . $testimonial->status_label . "</span>";
                })
                ->editColumn('quote', function ($testimonial) {
                    return \Illuminate\Support\Str::limit($testimonial->quote, 30);
                })
                ->editColumn('creater_id', function ($testimonial) {
                    return $testimonial->creater_name;
                })
                ->editColumn('created_at', function ($testimonial) {
                    return $testimonial->created_at_formatted;
                })
                ->editColumn('action', function ($testimonial) {
                    $menuItems = $this->menuItems($testimonial);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'created_at', 'quote', 'creater_id', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.testimonial.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['testimonial-details']
            ],
            [
                'routeName' => 'cms.testimonial.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['testimonial-edit']
            ],
            [
                'routeName' => 'cms.testimonial.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['testimonial-status']
            ],
            [
                'routeName' => 'cms.testimonial.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['testimonial-delete']
            ]

        ];
    }
    public function recycleBin(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->testimonialService->getTestimonials()->onlyTrashed()
                ->with(['deleter']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($testimonial) {
                    return "<span class='badge " . $testimonial->status_color . "'>$testimonial->status_label</span>";
                })
                ->editColumn('deleter_id', function ($testimonial) {
                    return $testimonial->deleter_name;
                })
                ->editColumn('deleted_at', function ($testimonial) {
                    return $testimonial->deleted_at_formatted;
                })
                ->editColumn('action', function ($testimonial) {
                    $menuItems = $this->trashedMenuItems($testimonial);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.testimonial.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.testimonial.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['testimonial-restore']
            ],
            [
                'routeName' => 'cms.testimonial.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['testimonial-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.admin.cms_management.testimonial.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $this->testimonialService->createTestimonial($validated, $request->author_image);
            session()->flash('success', 'Testimonial created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial create failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.index');
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id): JsonResponse
    {
        $data = $this->testimonialService->getTestimonial($id);
        $data->load(['creater', 'updater']);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['testimonial'] = $this->testimonialService->getTestimonial($id);
        return view('backend.admin.cms_management.testimonial.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialRequest $request, string $id): RedirectResponse
    {
        try {
            $testimonial = $this->testimonialService->getTestimonial($id);
            $validated = $request->validated();
            $this->testimonialService->updateTestimonial($testimonial, $validated, $request->author_image);
            session()->flash('success', 'Testimonial updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial update failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $testimonial = $this->testimonialService->getTestimonial($id);
            $this->testimonialService->delete($testimonial);
            session()->flash('success', 'Testimonial deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial delete failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.index');
    }
    public function status(string $id): RedirectResponse
    {
        try {
            $testimonial = $this->testimonialService->getTestimonial($id);
            $this->testimonialService->toggleStatus($testimonial);
            session()->flash('success', 'Testimonial status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial status update failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.index');
    }
    public function restore(string $id): RedirectResponse
    {
        try {
            $this->testimonialService->restore($id);
            session()->flash('success', 'Testimonial restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial restore failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.recycle-bin');
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
            $this->testimonialService->permanentDelete($id);
            session()->flash('success', 'Testimonial permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Testimonial permanent delete failed!');
            throw $e;
        }
        return redirect()->route('cms.testimonial.recycle-bin');
    }
}
