<?php

namespace App\Http\Controllers\Backend\Admin\GroupShipping;

use App\Http\Controllers\Controller;
use App\Services\Admin\GroupShipping\ContainerReservationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContainerReservationController extends Controller
{
    protected ContainerReservationService $containerReservationService;
    public function __construct(ContainerReservationService $containerReservationService)
    {
        $this->containerReservationService = $containerReservationService;

        $this->middleware('auth:admin');
        $this->middleware('permission:container-reserve-list', ['only' => ['index']]);
        $this->middleware('permission:container-reserve-details', ['only' => ['show']]);
        $this->middleware('permission:container-reserve-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:container-reserve-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:container-reserve-delete', ['only' => ['destroy']]);
        $this->middleware('permission:container-reserve-status', ['only' => ['status']]);
        $this->middleware('permission:container-reserve-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:container-reserve-restore', ['only' => ['restore']]);
        $this->middleware('permission:container-reserve-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->containerReservationService->getContainerReservations()->with(['creater_admin', 'container',]);
            return DataTables::eloquent($query)
                ->editColumn('container_id', function ($container_reserve) {
                    return $container_reserve->container?->title ?? '';
                })
                ->editColumn('status', function ($container_reserve) {
                    return "<span class='badge " . $container_reserve->status_color . "'>$container_reserve->status_label</span>";
                })
                ->editColumn('created_by', function ($container_reserve) {
                    return $container_reserve->creater_name;
                })
                ->editColumn('created_at', function ($container_reserve) {
                    return $container_reserve->created_at_formatted;
                })
                ->editColumn('action', function ($container) {
                    $menuItems = $this->menuItems($container);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'container_id', 'created_by', 'created_at', ])
                ->make(true);
        }
        return view('backend.admin.group_shipping.container_reservation.index');
    }

    
    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['container-reserve-details']
            ],
            [
                'routeName' => 'gs.container-reserve.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['container-reserve-edit']
            ],
            // [
            //     'routeName' => 'gs.container-reserve.status',
            //     'params' => [encrypt($model->id)],
            //     'label' => $model->status_btn_label,
            //     'permissions' => ['container-reserve-status']
            // ],
            [
                'routeName' => 'gs.container-reserve.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['container-reserve-delete']
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
        //
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
        //
    }
}
