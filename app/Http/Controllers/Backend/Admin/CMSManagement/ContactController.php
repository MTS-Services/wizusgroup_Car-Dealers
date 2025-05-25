<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\ContactService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    protected ContactService $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;

        $this->middleware('auth:admin');
        $this->middleware('permission:contact-list', ['only' => ['index']]);
        $this->middleware('permission:contact-details', ['only' => ['show']]);
        $this->middleware('permission:contact-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:contact-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
        $this->middleware('permission:contact-status', ['only' => ['status']]);
        $this->middleware('permission:contact-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:contact-restore', ['only' => ['restore']]);
        $this->middleware('permission:contact-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->contactService->getContacts()->with(['creater']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($contact) {
                    return "<span class='badge " . $contact->status_color . "'>$contact->status_label</span>";
                })
                ->editColumn('creater_id', function ($contact) {
                    return $contact->creater_name;
                })
                ->editColumn('created_at', function ($contact) {
                    return $contact->created_at_formatted;
                })
                ->editColumn('action', function ($contact) {
                    $menuItems = $this->menuItems($contact);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'creater_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.contact.index');
    }

    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['contact-details']
            ],
            [
                'routeName' => 'cms.contact.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['contact-edit']
            ],
            [
                'routeName' => 'cms.contact.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['contact-status']
            ],
            [
                'routeName' => 'cms.contact.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['contact-delete']
            ]

        ];
    }

    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->contactService->getContacts()->onlyTrashed()->with(['deleter']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($contact) {
                    return "<span class='badge " . $contact->status_color . "'>$contact->status_label</span>";
                })
                ->editColumn('deleter_id', function ($contact) {
                    return $contact->deleter_name;
                })
                ->editColumn('deleted_at', function ($contact) {
                    return $contact->deleted_at_formatted;
                })
                ->editColumn('action', function ($contact) {
                    $menuItems = $this->trashedMenuItems($contact);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleter_id', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.cms_management.contact.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'cms.contact.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['contact-restore']
            ],
            [
                'routeName' => 'cms.contact.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['contact-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = $this->contactService->getContact($id);

        $contact->load(['creater', 'open_by']);
        return response()->json($contact);
    }
   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->contactService->delete($id);
            session()->flash('success', 'Contact deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Contact delete failed!');
            throw $e;
        }
        return redirect()->route('cms.contact.index');
    }
    public function status(string $id): RedirectResponse
    {
        try {
            $this->contactService->toggleStatus($id);
            session()->flash('success', 'Contacat status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Contacat status update failed!');
            throw $e;
        }
        return redirect()->route('cms.contact.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $this->contactService->restore($id);
            session()->flash('success', 'Contact restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Contact restore failed!');
            throw $e;
        }
        return redirect()->route('cms.contact.recycle-bin');
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
            $this->contactService->permanentDelete($id);
            session()->flash('success', 'Contact permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Contact permanent delete failed!');
            throw $e;
        }
        return redirect()->route('cms.contact.recycle-bin');
    }
}
