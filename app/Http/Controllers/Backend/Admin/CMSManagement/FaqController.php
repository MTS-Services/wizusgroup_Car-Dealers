<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CMS\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Admin\CMSManagement\FaqService;
use App\Http\Traits\FileManagementTrait;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    private  $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
        $this->middleware('auth:admin');
        $this->middleware('permission:faq-list', ['only' => ['index']]);
        $this->middleware('permission:faq-details', ['only' => ['show']]);
        $this->middleware('permission:faq-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:faq-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
        $this->middleware('permission:faq-status', ['only' => ['status']]);
        $this->middleware('permission:faq-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:faq-restore', ['only' => ['restore']]);
        $this->middleware('permission:faq-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $query = $this->faqService->getFaqs()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('type', function ($faq) {
                    return $faq->type_label;
                })
                ->editColumn('status', function ($faq) {
                    return "<span class='badge " . $faq->status_color . "'>$faq->status_label</span>";
                })
                ->editColumn('creater_by', function ($faq) {
                    return $faq->creater_name;
                })
                ->editColumn('created_at', function ($faq) {
                    return $faq->created_at_formatted;
                })
                ->editColumn('action', function ($faq) {
                    $menuItems = $this->menuItems($faq);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['type', 'status', 'creater_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.faq.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['faq-details']
            ],
            [
                'routeName' => 'cms.faq.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['faq-status']
            ],
            [
                'routeName' => 'cms.faq.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['faq-edit']
            ],

            [
                'routeName' => 'cms.faq.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['faq-delete']
            ]

        ];
    }



    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->faqService->getFaqs()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)

                ->editColumn('type', function ($faq) {
                    return $faq->type_label;
                })
                ->editColumn('status', function ($faq) {
                    return "<span class='badge " . $faq->status_color . "'>$faq->status_label</span>";
                })
                ->editColumn('deleter_by', function ($faq) {
                    return $faq->deleter_name;
                })
                ->editColumn('deleted_at', function ($faq) {
                    return $faq->deleted_at_formatted;
                })
                ->editColumn('action', function ($faq) {
                    $menuItems = $this->trashedMenuItems($faq);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['type',  'status',  'deleter_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.faq.recycle-bin');
    }



    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.faq.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['admin-restore']
            ],
            [
                'routeName' => 'cms.faq.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['admin-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['document'] = Documentation::where([['module_key', 'faq'], ['type', 'create']])->first();
        return view('backend.admin.cms_management.faq.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request): RedirectResponse
    {

        try {
            $validated = $request->validated();
            $this->faqService->createFaq($validated, $request->image ?? null);
            session()->flash('success', 'Faq created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Faq create failed!');
            throw $e;
        }

        return redirect()->route('cms.faq.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq = $this->faqService->getFaq($id);
        $faq->load(['creater_admin', 'updater_admin']);
        return response()->json($faq);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['faq'] = $this->faqService->getFaq($id);
        $data['document'] = Documentation::where([['module_key', 'faq'], ['type', 'update']])->first();
        return view('backend.admin.cms_management.faq.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, string $id)
    {
        try {
            $validated = $request->validated();
            $this->faqService->updateFaq($id, $validated, $request->image ?? null);
            session()->flash('success', 'Faq updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Faq update failed!');
            throw $e;
        }
        return redirect()->route('cms.faq.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->faqService->deleteFaq($id);
            session()->flash('success', 'Faq deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Faq delete failed!');
            throw $e;
        }
        return redirect()->route('cms.faq.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $this->faqService->restoreFaq($id);
            session()->flash('success', 'Faq restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', value: 'Faq restore failed!');
            throw $e;
        }
        return redirect()->route('cms.faq.recycle-bin');
    }
    public function permanentDelete(string $id): RedirectResponse
    {
        try {
            $this->faqService->permanentDeleteFaq($id);
            session()->flash('success', 'Faq permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Faq permanent delete failed!');
            throw $e;
        }
        return redirect()->route('cms.faq.recycle-bin');
    }

    public function status(string $id): RedirectResponse
    {
        try {
            $this->faqService->toggleStatus($id);
            session()->flash('success', 'Faq status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Faq status update failed!');
            throw $e;
        }
        return redirect()->route('cms.faq.index');
    }
}
