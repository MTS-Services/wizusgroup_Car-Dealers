<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Contracts\View\View;
use Yajra\DataTables\Facades\DataTables;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:audit-list', ['only' => ['index']]);
        $this->middleware('permission:audit-details', ['only' => ['details']]);
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Audit::with(['user'])
            ->orderBy('sort_order', 'asc')
            ->latest();
            return DataTables::eloquent($query)
                ->editColumn('event', function ($audit) {
                    return ucfirst($audit->event);
                })
                ->editColumn('auditable_type', function ($audit) {
                    return getSubmitterType($audit->auditable_type);
                })
                ->editColumn('user_id', function ($audit) {
                    return $audit->user ? $audit->user->name : 'System';
                })
                ->editColumn('created_at', function ($audit) {
                    return $audit->created_at_formatted;
                })
                ->editColumn('action', function ($audit) {
                    $menuItems = [
                        [
                            'routeName' => 'audit.details',
                            'params' => [encrypt($audit->id)],
                            'label' => 'Details',
                            'permissions' => ['audit-details']
                        ]

                    ];
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['event', 'auditable_type', 'user_id', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.audits.index');
    }

    public function details(string $id): View
    {
        $audit = Audit::with('user')->findOrFail(decrypt($id));
        return view('backend.admin.audits.details', compact('audit'));
    }
}
