<?php

namespace App\Http\Controllers\Backend\Admin\GroupShipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupShipping\ShippingLocationRequest;
use App\Models\Documentation;
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
                'routeName' => 'gs.shipping-location.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['shipping-location-delete']
            ]

        ];
    }

     public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->shippingLocationService->getShippingLocations()->onlyTrashed()->with(['deleter_admin']);
            return DataTables::eloquent($query)
                ->editColumn('status', function ($shipping_location) {
                    return "<span class='badge " . $shipping_location->status_color . "'>$shipping_location->status_label</span>";
                })
                ->editColumn('deleted_by', function ($shipping_location) {
                    return $shipping_location->deleter_name;
                })
                ->editColumn('deleted_at', function ($shipping_location) {
                    return $shipping_location->deleted_at_formatted;
                })
                ->editColumn('action', function ($shipping_location) {
                    $menuItems = $this->trashedMenuItems($shipping_location);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.group_shipping.shipping_location.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'gs.shipping-location.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['shipping-location-restore']
            ],
            [
                'routeName' => 'gs.shipping-location.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['shipping-location-permanent-delete']
            ]

        ];
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $data['document'] = Documentation::where([['module_key', 'shipping-location'], ['type', 'create']])->first();
        return view('backend.admin.group_shipping.shipping_location.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingLocationRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->shippingLocationService->createShippingLocation($validated);
            session()->flash('success', 'Shipping Location created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location create failed!');
            throw $e;
        }

        return redirect()->route('gs.shipping-location.index');
    }

    /**
     * Display the specified resource.
     */
     public function show(string $id)
    {
        $shippingLocation = $this->shippingLocationService->getShippingLocation($id);
        $shippingLocation->load(['creater_admin', 'updater_admin',]);
        return response()->json($shippingLocation);
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(string $id)
    {
        $data['shipping_location'] = $this->shippingLocationService->getShippingLocation($id);
        $data['document'] = Documentation::where([['module_key', 'shipping-location'], ['type', 'update']])->first();
        return view('backend.admin.group_shipping.shipping_location.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingLocationRequest $request, string $id)
    {

        try {
            $validated = $request->validated();
            $this->shippingLocationService->updateShippingLocation($id, $validated);
            session()->flash('success', 'Shipping Location updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location update failed!');
            throw $e;
        }
        return redirect()->route('gs.shipping-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        try {
            $this->shippingLocationService->deleteShippingLocation($id);
            session()->flash('success', 'Shipping Location deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location delete failed!');
            throw $e;
        }
        return redirect()->route('gs.shipping-location.index');
    }


    public function status(string $id): RedirectResponse
    {
        try {
            $this->shippingLocationService->toggleStatus($id);
            session()->flash('success', 'Shipping Location status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location status update failed!');
            throw $e;
        }
        return redirect()->route('gs.shipping-location.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $this->shippingLocationService->restore($id);
            session()->flash('success', 'Shipping Location restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location restore failed!');
            throw $e;
        }
        return redirect()->route('gs.shipping-location.recycle-bin');
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
            $this->shippingLocationService->permanentDelete($id);
            session()->flash('success', 'Shipping Location permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Shipping Location permanent delete failed!');
            throw $e;
        }
        return redirect()->route('gs.shipping-location.recycle-bin');
    }
}
