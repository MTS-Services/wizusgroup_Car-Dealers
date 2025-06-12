<?php

namespace App\Http\Controllers\Backend\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupShipping\ContainerRequest;
use App\Jobs\OrderStatusMailSend;
use App\Jobs\SendContainerJoinEmail;
use App\Models\Container;
use App\Models\ContainerReservation;
use App\Models\Documentation;
use App\Models\Order;
use App\Services\Admin\GroupShipping\ContainerService;
use App\Services\Admin\OrderManagement\OrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected ContainerService $containerService;
    public function __construct(OrderService $orderService, ContainerService $containerService)
    {
        $this->orderService = $orderService;
        $this->containerService = $containerService;

        $this->middleware('auth:admin');
        $this->middleware('permission:order-list', ['only' => ['index']]);
        $this->middleware('permission:order-details', ['only' => ['show']]);
        $this->middleware('permission:order-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
        $this->middleware('permission:order-status', ['only' => ['status']]);
        $this->middleware('permission:order-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:order-restore', ['only' => ['restore']]);
        $this->middleware('permission:order-permanent-delete', ['only' => ['permanentDelete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->status;
        if ($request->ajax()) {
            $query = $this->orderService->getOrders()->with(['creater', 'shippingPort', 'destinationPort', 'user']);
            if ($request->has('status')) {
                $query = match (strtolower($request->status)) {
                    'submitted' => $query->where('status', Order::STATUS_SUBMITTED),
                    'confirm' => $query->where('status', Order::STATUS_CONFIRM),
                    'shipped' => $query->where('status', Order::STATUS_SHIPPED),
                    'delivered' => $query->where('status', Order::STATUS_DELIVERED),
                    'pending' => $query->where('status', Order::STATUS_PENDING)->orWhere('status', Order::STATUS_INITIATED),
                    'canceled' => $query->where('status', Order::STATUS_CANCELED),
                    default => $query,
                };
            }

            return DataTables::eloquent($query)
                ->editColumn('order_number', fn($order) => "#{$order->order_number}")
                ->editColumn('shipping_port', fn($order) => $order->shippingPort?->name ?? '')
                ->editColumn('destination_port', fn($order) => $order->destinationPort?->name ?? '')
                ->editColumn('user_id', fn($order) => $order->user?->full_name ?? '')
                ->editColumn('status', fn($order) => "<span class='badge " . $order->status_color . "'>$order->status_label</span>")
                ->editColumn('created_by', fn($order) => $order->creater_name ?? '')
                ->editColumn('created_at', fn($order) => $order->created_at_formatted)
                ->editColumn('action', fn($order) => view('components.backend.admin.action-buttons', ['menuItems' => $this->menuItems($order)])->render())
                ->rawColumns(['status', 'shipping_port', 'destination_port', 'user_id', 'order_number', 'created_by', 'created_at', 'action'])
                ->make(true);
        }
        return view('backend.admin.order_management.order.index', compact('status'));
    }


    protected function menuItems($model): array
    {
        return [
            [
                'routeName' => 'om.order.details',
                'params' => [encrypt($model->id)],
                'label' => 'Details',
                'permissions' => ['order-details']
            ],
            // [
            //     'routeName' => 'gs.container-reserve.edit',
            //     'params' => [encrypt($model->id)],
            //     'label' => 'Edit',
            //     'permissions' => ['container-reserve-edit']
            // ],
            // // [
            // //     'routeName' => 'gs.container-reserve.status',
            // //     'params' => [encrypt($model->id)],
            // //     'label' => $model->status_btn_label,
            // //     'permissions' => ['container-reserve-status']
            // // ],
            // [
            //     'routeName' => 'gs.container-reserve.destroy',
            //     'params' => [encrypt($model->id)],
            //     'label' => 'Delete',
            //     'delete' => true,
            //     'permissions' => ['container-reserve-delete']
            // ]

        ];
    }

    public function show(string $id)
    {
        $order = $this->orderService->getOrder($id);
        $data['order'] = $order->load(['shippingPort', 'destinationPort', 'user', 'creater', 'updater', 'container']);

        $status = $order->status_label;
        if ($status == 'Initiated') {
            $status = 'pending';
        }
        $data['status'] = strtolower($status);
        return view('backend.admin.order_management.order.details', $data);
    }

    public function status(string $status, string $order)
    {
        try {
            return DB::transaction(function () use ($status, $order) {
                $order = $this->orderService->getOrder($order);
                $order->load(['container', 'items.product', 'containerReservation']);
                if (decrypt($status) == Order::STATUS_CONFIRM) {
                    $totalHeight = $order->items->sum(fn($item) => optional($item->product)->height_m ? $item->product?->height_m * $item->quantity : 0);
                    $totalWidth = $order->items->sum(fn($item) => optional($item->product)->width_m ? $item->product?->width_m * $item->quantity : 0);
                    $totalLength = $order->items->sum(fn($item) => optional($item->product)->length_m ? $item->product?->length_m * $item->quantity : 0);
                    $totalCbm = $totalHeight + $totalWidth + $totalLength;
                    if ($order->status == Order::STATUS_CANCELED) {
                        if ($order->container?->container_free_space_cbm < $totalCbm) {
                            throw new Exception('Container space is not enough for this order');

                        } elseif ($order->container_type == Order::FULL_CONTAINER && $order->container->filled_percentage != 0) {
                            throw new Exception('Container is not empty');
                        }

                        foreach ($order->items as $item) {
                            $item->product()->decrement('quantity', $item->quantity);
                        }
                    }
                    $order->containerReservation()->update(['status' => ContainerReservation::STATUS_ACCEPT]);
                    $order->refresh();
                    if ($order->container->container_free_space_cbm == 0) {
                        $order->container()->update([
                            'full_container_reserved' => Container::FULL_RESERVED
                        ]);
                    }
                }
                if (decrypt($status) == Order::STATUS_CANCELED) {
                    foreach ($order->items as $item) {
                        $item->product()->increment('quantity', $item->quantity);
                    }
                    $order->containerReservation()->update(['status' => ContainerReservation::STATUS_DECLINE]);
                }

                $order->update(['status' => decrypt($status), 'updater_id' => admin()->id, 'updater_type' => get_class(admin())]);
                OrderStatusMailSend::dispatch($order);
                OrderStatusMailSend::dispatch($order, true);
                session()->flash('success', "Order $order->status_label successfully!");
                return redirect()->back();
            });
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function assignContainer(string $id)
    {
        $data['order'] = $this->orderService->getOrder($id);
        $data['order']->load(['items.product', 'shippingPort', 'destinationPort']);
        $data['document'] = Documentation::where([['module_key', 'container'], ['type', 'create']])->first();
        return view('backend.admin.order_management.order.container_assign', $data);
    }

    public function assignContainerSubmit(ContainerRequest $request, string $oid)
    {
        try {
            DB::transaction(function () use ($request, $oid) {
                $validated = $request->validated();
                $file = $request->validated('image') && $request->hasFile('image') ? $request->file('image') : null;
                $validated['status'] = Container::STATUS_ACTIVE;
                $container = $this->containerService->createContainer($validated, $file);
                $order = $this->orderService->getOrder($oid);

                $totalHeight = $order->items->sum(fn($item) => optional($item->product)->height_m ? $item->product?->height_m * $item->quantity : 0);
                $totalWidth = $order->items->sum(fn($item) => optional($item->product)->width_m ? $item->product?->width_m * $item->quantity : 0);
                $totalLength = $order->items->sum(fn($item) => optional($item->product)->length_m ? $item->product?->length_m * $item->quantity : 0);
                $totalWeight = $order->items->sum(fn($item) => optional($item->product)->weight_kg ? $item->product?->weight_kg * $item->quantity : 0);
                $totalCbm = $totalHeight + $totalWidth + $totalLength;
                $total_price = $container->per_cbm_cost * $totalCbm;
                $total_price += $container->base_cost;
                $reserve_price = $total_price / 2;
                ContainerReservation::create([
                    'order_id' => $order->id,
                    'container_id' => $container->id,
                    'user_id' => $order->user_id,
                    'status' => ContainerReservation::STATUS_PENDING,
                    'email' => $order->shipping?->email,
                    'whatsapp' => $order->user?->whatsapp,
                    'quantity' => $order->items->sum('quantity'),
                    'length_m' => $totalLength,
                    'width_m' => $totalWidth,
                    'height_m' => $totalHeight,
                    'weight_kg' => $totalWeight,
                    'price' => $total_price,
                    'reserve_price' => $reserve_price,
                    'note' => null,
                    'creater_id' => $order->creater_id,
                    'creater_type' => $order->creater_type
                ]);
                $order->update([
                    'container_id' => $container->id,
                    'container_request' => Order::CONTINER_REQUEST_FALSE
                ]);
                if ($order->container_type == Order::FULL_CONTAINER || $container->container_free_space_cbm == 0) {
                    $container->update([
                        'full_container_reserved' => Container::FULL_RESERVED
                    ]);
                }

                SendContainerJoinEmail::dispatch($order, false); // for user mail notify
                SendContainerJoinEmail::dispatch($order, true);  // for admin mail notify

                session()->flash('success', 'Container assigned successfully!');
            });
        } catch (\Throwable $e) {
            session()->flash('error', 'Container assign failed!');
            throw $e;
        }
        return redirect()->route('om.order.details', $oid);
    }
}
