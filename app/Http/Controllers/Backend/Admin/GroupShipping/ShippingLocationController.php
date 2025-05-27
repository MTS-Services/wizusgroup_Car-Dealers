<?php

namespace App\Http\Controllers\Backend\Admin\GroupShipping;

use App\Http\Controllers\Controller;
use App\Services\Admin\GroupShipping\ShippingLocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingLocationController extends Controller
{
    protected ShippingLocationService $shippingLocationService;

    public function __construct(ShippingLocationService $shippingLocationService)
    {
        $this->shippingLocationService = $shippingLocationService;

        $this->middleware('auth:admin');
        $this->middleware('permission:shipping-location-list', ['only' => ['index']]);
        $this->middleware('permission:shipping-location-details', ['only' => ['show']]);
        $this->middleware('permission:shipping-location-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:shipping-location-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:shipping-location-delete', ['only' => ['destroy']]);
        $this->middleware('permission:shipping-location-status', ['only' => ['status']]);
        $this->middleware('permission:shipping-location-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:shipping-location-restore', ['only' => ['restore']]);
        $this->middleware('permission:shipping-location-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->shippingLocationService->getShippingLocations()->with(['creater_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($shipping_location) {
                    return "<span class='badge " . $shipping_location->status_color . "'>$shipping_location->status_label</span>";
                })
                ->editColumn('created_by', function ($shipping_location) {
                    return $shipping_location->creater_name;
                })
                ->editColumn('created_at', function ($shipping_location) {
                    return $shipping_location->created_at_formatted;
                })
                ->editColumn('action', function ($shipping_location) {
                    $menuItems = $this->menuItems($shipping_location);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.group_shipping.shipping_location.index');
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['shipping-location-details']
            ],
            [
                'routeName' => 'gs.shipping-location.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['shipping-location-edit']
            ],
            [
                'routeName' => 'gs.shipping-location.status',
                'params' => [encrypt($model->id)],
                'label' => $model->status_btn_label,
                'permissions' => ['shipping-location-status']
            ],
            [
                'routeName' => 'gs.shipping-location.feature',
                'params' => [encrypt($model->id)],
                'label' => $model->featured_btn_label,
                'permissions' => ['shipping-location-feature']
            ],
            [
                'routeName' => 'gs.shipping-location.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['shipping-location-delete']
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
