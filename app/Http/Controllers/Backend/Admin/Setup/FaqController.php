<?php

namespace App\Http\Controllers\Backend\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setup\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function __construct()
    {
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


            $query = Faq::with(['creater'])
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)
                ->editColumn('type', function ($faq) {
                    return $faq->type_label;
                })
                ->editColumn('status', function ($faq) {
                    return "<span class='badge " . $faq->status_color . "'>$faq->status_label</span>";
                })
                ->editColumn('creater_id', function ($faq) {
                    return $faq->creater_name;
                })
                ->editColumn('created_at', function ($faq) {
                    return $faq->created_at_formatted;
                })
                ->editColumn('action', function ($faq) {
                    $menuItems = $this->menuItems($faq);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['type', 'status', 'creater_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.faq.index');
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
                'routeName' => 'setup.faq.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['faq-status']
            ],
            [
                'routeName' => 'setup.faq.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['faq-edit']
            ],

            [
                'routeName' => 'setup.faq.destroy',
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


            $query = Faq::with(['deleter'])
                ->onlyTrashed()
                ->orderBy('sort_order', 'asc')
                ->latest();
            return DataTables::eloquent($query)

                ->editColumn('type', function ($faq) {
                    return $faq->type_label;
                })
                ->editColumn('status', function ($faq) {
                    return "<span class='badge " . $faq->status_color . "'>$faq->status_label</span>";
                })
                ->editColumn('deleter_id', function ($faq) {
                    return $faq->deleter_name;
                })
                ->editColumn('deleted_at', function ($faq) {
                    return $faq->deleted_at_formatted;
                })
                ->editColumn('action', function ($faq) {
                    $menuItems = $this->trashedMenuItems($faq);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['type',  'status',  'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.setup.faq.recycle-bin');
    }



    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'setup.faq.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['admin-restore']
            ],
            [
                'routeName' => 'setup.faq.permanent-delete',
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
        return view('backend.admin.setup.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request): RedirectResponse
    {

        $validated = $request->validated();
        $validated['creater_id'] = admin()->id;
        $validated['creater_type'] = get_class(admin());
        Faq::create($validated);
        session()->flash('success', 'FAQ created successfully!');
        return redirect()->route('setup.faq.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Faq::with(['creater','updater'])->findOrFail(decrypt($id));
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['faq'] = Faq::findOrFail(decrypt($id));
        return view('backend.admin.setup.faq.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FaqRequest $request, string $id)
    {
        $validated = $request->validated();
        $validated['updater_id'] = admin()->id;
        $validated['updater_type'] = get_class(admin());
        $faq = Faq::findOrFail(decrypt($id));
        $faq->update($validated);
        session()->flash('success', 'Faq updated successfully!');
        return redirect()->route('setup.faq.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail(decrypt($id));
        $faq->update(['deleter_id' => admin()->id, 'deleter_type' => get_class(admin())]);
        $faq->delete();
        session()->flash('success', 'FAQ deleted successfully!');
        return redirect()->route('setup.faq.index');
    }

    public function restore(string $id)
    {
        $faq = Faq::withTrashed()->findOrFail(decrypt($id));
        $faq->restore(['updater_id'=> admin()->id,'updater_type'=> get_class(admin())]);
        session()->flash('success', 'FAQ restored successfully!');
        return redirect()->route('setup.faq.recycle-bin');
    }
    public function permanentDelete(string $id)
    {
        $faq = Faq::withTrashed()->findOrFail(decrypt($id));
        $faq->forceDelete();
        session()->flash('success', 'FAQ permanently deleted successfully!');
        return redirect()->route('setup.faq.recycle-bin');
    }
    public function status(string $id)
    {
        $faq = Faq::findOrFail(decrypt($id));
        $faq->update(['status' => !$faq->status,'updater_id'=> admin()->id,'updater_type'=> get_class(admin())]);
        session()->flash('success', 'FAQ status updated successfully!');
        return redirect()->route('setup.faq.index');
    }
}
