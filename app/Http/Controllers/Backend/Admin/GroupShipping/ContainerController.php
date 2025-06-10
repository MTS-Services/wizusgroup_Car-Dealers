<?php

namespace App\Http\Controllers\Backend\Admin\GroupShipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupShipping\ContainerRequest;
use App\Models\Documentation;
use App\Services\Admin\GroupShipping\ContainerService;
use App\Services\Admin\GroupShipping\ShippingLocationService;
use App\Services\Admin\ProductManagement\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Container;

class ContainerController extends Controller
{
    protected ContainerService $containerService;
    protected ShippingLocationService $shippingLocationService;
    protected ProductService $productService;

    public function __construct(ContainerService $containerService, ShippingLocationService $shippingLocationService, ProductService $productService)
    {
        $this->containerService = $containerService;
        $this->shippingLocationService = $shippingLocationService;
        $this->productService = $productService;

        $this->middleware('auth:admin');
        $this->middleware('permission:container-list', ['only' => ['index']]);
        $this->middleware('permission:container-details', ['only' => ['show']]);
        $this->middleware('permission:container-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:container-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:container-delete', ['only' => ['destroy']]);
        $this->middleware('permission:container-status', ['only' => ['status']]);
        $this->middleware('permission:container-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:container-restore', ['only' => ['restore']]);
        $this->middleware('permission:container-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->containerService->getContainers()->with(['creater_admin', 'shippingPort', 'destinationPort']);
            return DataTables::eloquent($query)
                ->editColumn('shipping_port', function ($container) {
                    return $container->shippingPort->name ?? '';
                })
                ->editColumn('destination_port', function ($container) {
                    return $container->destinationPort->name ?? '';
                })
                ->editColumn('status', function ($container) {
                    return "<span class='badge " . $container->status_color . "'>$container->status_label</span>";
                })
                ->editColumn('created_by', function ($container) {
                    return $container->creater_name;
                })
                ->editColumn('created_at', function ($container) {
                    return $container->created_at_formatted;
                })
                ->editColumn('action', function ($container) {
                    $menuItems = $this->menuItems($container);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['status', 'shipping_port', 'destination_port', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.group_shipping.container.index');
    }

    protected function statusMenu($model): array
    {

        if ($model->status == Container::STATUS_PENDING) {
            return [
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_ACTIVE)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_ACTIVE],
                    'permissions' => ['container-status']
                ],
            ];
        }
        if ($model->status == Container::STATUS_ACTIVE) {
            return [
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_PENDING)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_PENDING],
                    'permissions' => ['container-status']
                ],
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_SHIPPED)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_SHIPPED],
                    'permissions' => ['container-status']
                ],
            ];
        }
        if ($model->status == Container::STATUS_SHIPPED) {
            return [
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_ACTIVE)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_ACTIVE],
                    'permissions' => ['container-status']
                ],
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_DELIVERED)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_DELIVERED],
                    'permissions' => ['container-status']
                ],
            ];
        }

        if ($model->status == Container::STATUS_DELIVERED) {
            return [
                [
                    'routeName' => 'gs.container.status',
                    'params' => [encrypt($model->id), encrypt(Container::STATUS_SHIPPED)],
                    'label' => $model->getStatusBtnLabels()[Container::STATUS_SHIPPED],
                    'permissions' => ['container-status']
                ],
            ];
        }
        return [];


    }




    protected function menuItems($model): array
    {
        $menus = [
            [
                'routeName' => 'javascript:void(0)',
                'data-id' => encrypt($model->id),
                'className' => 'view',
                'label' => 'Details',
                'permissions' => ['container-details']
            ],
            [
                'routeName' => 'gs.container.edit',
                'params' => [encrypt($model->id)],
                'label' => 'Edit',
                'permissions' => ['container-edit']
            ],
        ];
        $delete_menu = [
            [
                'routeName' => 'gs.container.destroy',
                'params' => [encrypt($model->id)],
                'label' => 'Delete',
                'delete' => true,
                'permissions' => ['container-delete']
            ]

        ];

        return array_merge($menus, $this->statusMenu($model), $delete_menu);
    }


    public function recycleBin(Request $request)
    {

        if ($request->ajax()) {
            $query = $this->containerService->getContainers()->onlyTrashed()->with(['deleter_admin', 'shippingPort', 'destinationPort']);
            return DataTables::eloquent($query)
                ->editColumn('shipping_port', function ($container) {
                    return $container->shippingPort->name ?? '';
                })
                ->editColumn('destination_port', function ($container) {
                    return $container->destinationPort->name ?? '';
                })
                ->editColumn('status', function ($container) {
                    return "<span class='badge " . $container->status_color . "'>$container->status_label</span>";
                })
                ->editColumn('deleted_by', function ($container) {
                    return $container->deleter_name;
                })
                ->editColumn('deleted_at', function ($container) {
                    return $container->deleted_at_formatted;
                })
                ->editColumn('action', function ($container) {
                    $menuItems = $this->trashedMenuItems($container);
                    return view('components.backend.admin.action-buttons', compact('menuItems'))->render();
                })
                ->rawColumns(['shipping_port', 'destination_port', 'status', 'deleted_by', 'deleted_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.group_shipping.container.recycle-bin');
    }

    protected function trashedMenuItems($model): array
    {
        return [
            [
                'routeName' => 'gs.container.restore',
                'params' => [encrypt($model->id)],
                'label' => 'Restore',
                'permissions' => ['container-restore']
            ],
            [
                'routeName' => 'gs.container.permanent-delete',
                'params' => [encrypt($model->id)],
                'label' => 'Permanent Delete',
                'p-delete' => true,
                'permissions' => ['container-permanent-delete']
            ]

        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['shippingLocations'] = $this->shippingLocationService->getShippingLocations()->active()->select(['id', 'name'])->get();
        $data['products'] = $this->productService->getProducts()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'shipping-location'], ['type', 'create']])->first();
        return view('backend.admin.group_shipping.container.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContainerRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                $file = $request->validated('image') && $request->hasFile('image') ? $request->file('image') : null;
                $container = $this->containerService->createContainer($validated, $file);
                // if (collect($request->validated('container_products')[0])->filter()->isNotEmpty()) {
                //     foreach ($request->validated('container_products') as $key => $value) {
                //         $value['container_id'] = $container->id;
                //         $this->containerService->createContainerProducts($value);
                //     }
                // }

            });
            session()->flash('success', 'Container created successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container create failed!');
            throw $e;
        }

        return redirect()->route('gs.container.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $container = $this->containerService->getContainer($id);
        $container->load(['creater_admin', 'updater_admin', 'shippingPort', 'destinationPort']);
        $container['shipping_port_name'] = $container?->shippingPort?->name;
        $container['destination_port_name'] = $container?->destinationPort?->name;
        return response()->json($container);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['container'] = $this->containerService->getContainer($id);
        $data['container']->load(['containerProducts.product']);
        $data['products'] = $this->productService->getProducts()->active()->select(['id', 'name'])->get();
        $data['shipping_locations'] = $this->shippingLocationService->getShippingLocations()->active()->select(['id', 'name'])->get();
        $data['document'] = Documentation::where([['module_key', 'container'], ['type', 'update']])->first();
        return view('backend.admin.group_shipping.container.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContainerRequest $request, string $id)
    {
        try {

            DB::transaction(function () use ($request, $id) {
                $validated = $request->validated();
                $file = $request->validated('image') && $request->hasFile('image') ? $request->file('image') : null;
                $container = $this->containerService->updateContainer($id, $validated, $file);
                // foreach ($request->validated('container_products') as $key => $value) {
                //     $value['container_id'] = $container->id;
                //     $value['key'] = $key;
                //     $this->containerService->createContainerProducts($value);
                // }
            });

            session()->flash('success', 'Container updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container update failed!');
            throw $e;
        }

        return redirect()->route('gs.container.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $container = $this->containerService->getContainer($id);
            $container->load('containerReservations');
            if ($container->containerReservations->count()) {
                session()->flash('error', 'You cannot delete this container. Container has already been reserved!');
                return redirect()->route('gs.container.index');
            }
            $this->containerService->deleteContainer($id);
            session()->flash('success', 'Container deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container delete failed!');
            throw $e;
        }
        return redirect()->route('gs.container.index');
    }


    public function status(string $id, string $status): RedirectResponse
    {
        try {
            if (decrypt($status) == Container::STATUS_PENDING) {
                $container = $this->containerService->getContainer($id);
                $container->load('containerReservations');
                if ($container->containerReservations->count()) {
                    session()->flash('error', 'You cannot make this container pending. Container has already been reserved!');
                    return redirect()->route('gs.container.index');
                }
            }
            $this->containerService->toggleStatus($id, $status);
            session()->flash('success', 'Container status updated successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container status update failed!');
            throw $e;
        }
        return redirect()->route('gs.container.index');
    }

    public function restore(string $id): RedirectResponse
    {
        try {
            $this->containerService->restore($id);
            session()->flash('success', 'Container restored successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container restore failed!');
            throw $e;
        }
        return redirect()->route('gs.container.recycle-bin');
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
            $this->containerService->permanentDelete($id);
            session()->flash('success', 'Container permanently deleted successfully!');
        } catch (\Throwable $e) {
            session()->flash('error', 'Container permanent delete failed!');
            throw $e;
        }
        return redirect()->route('gs.container.recycle-bin');
    }
}
