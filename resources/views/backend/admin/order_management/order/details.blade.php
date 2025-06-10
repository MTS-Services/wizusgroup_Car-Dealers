@extends('backend.admin.layouts.master', ['page_slug' => "order_{$status}"])

@section('title', 'Order Details')

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-secondary text-white d-flex align-items-center justify-content-between">
            <h1 class="h3 mb-2">
                {{ __('ORDER DETAILS') }}
            </h1>

            <p class="mb-1">{{ __('Order Number') }}: <span
                    class="badge bg-light text-dark">#{{ $order->order_number }}</span></p>
            <p class="mb-1">{{ __('Order Date') }}: <span class="fw-bold">{{ $order->created_at->format('F d, Y') }}</span>
            </p>
            <p class="mb-0">{{ __('Status') }}: <span
                    class="badge {{ $order->status_color }}">{{ $order->status_label ?? 'Pending' }}</span></p>

        </div>

        <div class="card-body p-4">
            <!-- Customer Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary">👤 {{ __('Customer Information') }}</h5>
                            <div class="small">
                                <p class="mb-2"><strong>{{ __('Name') }}:</strong>
                                    {{ $order->user?->full_name ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>{{ __('Email') }}:</strong>
                                    {{ $order->user?->email ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>{{ __('Phone') }}:</strong>
                                    {{ $order->user?->phone }}</p>
                                <p class="mb-0"><strong>{{ __('WhatsApp') }}:</strong>
                                    {{ $order->user?->whatsapp }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order->shipping)
                    <div class="col-md-6">
                        <div class="card bg-light h-100">
                            <div class="card-body">
                                <h5 class="card-title text-primary">📍 {{ __('Shipping Information') }}</h5>
                                <div class="small">
                                    @if ($order->shipping->email)
                                        <p class="mb-2"><strong>{{ __('Email') }}:</strong>
                                            {{ $order->shipping->email }}</p>
                                    @endif

                                    @if ($order->shipping->city)
                                        <p class="mb-2"><strong>{{ __('City') }}:</strong>
                                            {{ $order->shipping->city->name ?? $order->shipping->city }}</p>
                                    @endif
                                    @if ($order->shipping->state)
                                        <p class="mb-2"><strong>{{ __('State') }}:</strong>
                                            {{ $order->shipping->state->name ?? $order->shipping->state }}</p>
                                    @endif
                                    @if ($order->shipping->country)
                                        <p class="mb-0"><strong>{{ __('Country') }}:</strong>
                                            {{ $order->shipping->country->name ?? $order->shipping->country }}
                                        </p>
                                    @endif
                                    @if ($order->shipping->address_line_1)
                                        <p class="mb-2"><strong>{{ __('Address') }}:</strong>
                                            {{ $order->shipping->address_line_1 }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Shipping Route -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-info bg-opacity-10 border-info mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-info">🚢 {{ __('Shipping Route') }}</h5>
                            <div class="row text-center small">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>{{ __('From') }}:</strong></p>
                                    <p class="mb-0">{{ $order->shippingPort->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <span class="text-info h4 mb-0">→</span>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>{{ __('To') }}:</strong></p>
                                    <p class="mb-0">{{ $order->destinationPort->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="mb-0"><strong>{{ __('Container Type') }}:</strong>
                                    {{ $order->container_type_label ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Container Information (if exists) -->
                    @if (isset($order->container) && $order->container)
                        <div class="card bg-success bg-opacity-10 border-success border-start border-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-success">🚢 {{ __('Container Information') }}
                                    <span class="badge bg-success">{{ $order->container->status_label }}</span>
                                </h5>
                                <div class="row small">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>{{ __('Container') }}:</strong>
                                            {{ $order->container->title ?? 'N/A' }}</p>
                                        <p class="mb-2"><strong>{{ __('Type') }}:</strong>
                                            {{ $order->container_type_label ?? 'N/A' }}</p>
                                        <p class="mb-0"><strong>{{ __('Dimensions') }}:</strong>
                                            {{ $order->container->length_m ?? 0 }}m ×
                                            {{ $order->container->width_m ?? 0 }}m ×
                                            {{ $order->container->height_m ?? 0 }}m
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>{{ __('Max Weight') }}:</strong>
                                            {{ number_format($order->container->max_weight_kg ?? 0) }} kg</p>
                                        <p class="mb-2"><strong>{{ __('Base Cost') }}:</strong>
                                            ${{ number_format($order->container->base_cost ?? 0, 2) }}</p>
                                        <p class="mb-0"><strong>{{ __('Per CBM Cost') }}:</strong>
                                            ${{ number_format($order->container->per_cbm_cost ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Container Request Information -->
                        @php
                            $totalHeight = $order->items->sum(
                                fn($item) => optional($item->product)->height_m
                                    ? $item->product->height_m * $item->quantity
                                    : 0,
                            );
                            $totalWidth = $order->items->sum(
                                fn($item) => optional($item->product)->width_m
                                    ? $item->product->width_m * $item->quantity
                                    : 0,
                            );
                            $totalLength = $order->items->sum(
                                fn($item) => optional($item->product)->length_m
                                    ? $item->product->length_m * $item->quantity
                                    : 0,
                            );
                            $totalWeight = $order->items->sum(
                                fn($item) => optional($item->product)->weight_kg
                                    ? $item->product->weight_kg * $item->quantity
                                    : 0,
                            );
                            $totalCBM = $totalHeight * $totalWidth * $totalLength;
                        @endphp
                        <div class="card bg-warning bg-opacity-10 border-warning border-start border-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-warning">📏 {{ __('Requested Container Requirements') }}
                                </h5>
                                <div class="row small">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>{{ __('Minimum Length') }}:</strong>
                                            {{ number_format($totalLength, 2) }} meters</p>
                                        <p class="mb-2"><strong>{{ __('Minimum Width') }}:</strong>
                                            {{ number_format($totalWidth, 2) }} meters</p>
                                        <p class="mb-0"><strong>{{ __('Minimum Height') }}:</strong>
                                            {{ number_format($totalHeight, 2) }} meters</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>{{ __('Minimum Weight Capacity') }}:</strong>
                                            {{ number_format($totalWeight, 2) }} kg</p>
                                        <p class="mb-2"><strong>{{ __('Estimated CBM') }}:</strong>
                                            {{ number_format($totalCBM, 2) }} m³</p>
                                        <p class="mb-0"><strong>{{ __('Container Type Preference') }}:</strong>
                                            {{ $order->container_type_label ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">📦 {{ __('Order Items') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Product') }}</th>
                                    <th class="text-center">{{ __('Qty') }}</th>
                                    <th class="text-center">{{ __('Dimensions (L×W×H)') }}</th>
                                    <th class="text-center">{{ __('Weight') }}</th>
                                    <th class="text-end">{{ __('Unit Price') }}</th>
                                    <th class="text-end">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">
                                            {{ number_format($item->product->length_m ?? 0, 2) }}×{{ number_format($item->product->width_m ?? 0, 2) }}×{{ number_format($item->product->height_m ?? 0, 2) }}m
                                        </td>
                                        <td class="text-center">
                                            {{ number_format(($item->product->weight_kg ?? 0) * $item->quantity, 2) }}
                                            kg
                                        </td>
                                        <td class="text-end">
                                            ${{ number_format($item->product->price ?? 0, 2) }}</td>
                                        <td class="text-end">
                                            ${{ number_format($item->quantity * ($item->product->price ?? 0), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-6">
                    <!-- Order Summary -->
                    @php
                        $totalHeight = $order->items->sum(
                            fn($item) => optional($item->product)->height_m
                                ? $item->product->height_m * $item->quantity
                                : 0,
                        );
                        $totalWidth = $order->items->sum(
                            fn($item) => optional($item->product)->width_m
                                ? $item->product->width_m * $item->quantity
                                : 0,
                        );
                        $totalLength = $order->items->sum(
                            fn($item) => optional($item->product)->length_m
                                ? $item->product->length_m * $item->quantity
                                : 0,
                        );
                        $totalWeight = $order->items->sum(
                            fn($item) => optional($item->product)->weight_kg
                                ? $item->product->weight_kg * $item->quantity
                                : 0,
                        );
                        $totalCBM = $totalHeight + $totalWidth + $totalLength;

                        $order->containerPrice = 0;
                        $reservePrice = 0;
                        if (isset($order->container) && $order->container) {
                            $order->containerPrice =
                                $order->container->per_cbm_cost * $totalCBM + $order->container->base_cost;
                            $reservePrice = $order->containerPrice / 2;
                        }
                    @endphp

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">📊 {{ __('Order Summary') }}</h5>
                            <div class="row small">
                                <div class="col-md-12">
                                    <p class="mb-1"><strong>{{ __('Total Items') }}:</strong>
                                        {{ $order->items->sum('quantity') }}</p>
                                    <p class="mb-1"><strong>{{ __('Total Cargo Dimensions') }}:</strong>
                                        {{ number_format($totalLength, 2) }}m × {{ number_format($totalWidth, 2) }}m ×
                                        {{ number_format($totalHeight, 2) }}m
                                    </p>

                                    <p class="mb-1"><strong>{{ __('Total Weight') }}:</strong>
                                        {{ number_format($totalWeight, 2) }} kg</p>
                                    <p class="mb-1"><strong>{{ __('Total CBM') }}:</strong>
                                        {{ number_format($totalCBM, 2) }} m³</p>
                                    <p class="mb-0"><strong>{{ __('Order Total') }}:</strong>
                                        <span
                                            class="h5 text-primary fw-bold">${{ number_format($order->total, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Container Pricing (if container exists) -->
                @if (isset($order->container) && $order->container && $order->containerPrice > 0)
                    <div class="col-md-6">
                        <div class="card bg-info bg-opacity-10 border-info border-start border-4 mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-info">💰 {{ __('Container Shipping Cost') }}</h5>
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Base Cost') }}:</span>
                                        <span>${{ number_format($order->container->base_cost, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('Per CBM Cost') }}:</span>
                                        <span>${{ number_format($order->container->per_cbm_cost, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>{{ __('CBM Cost') }}
                                            (${{ number_format($order->container->per_cbm_cost, 2) }} ×
                                            {{ number_format($totalCBM, 2) }} m³):</span>
                                        <span>${{ number_format($order->container->per_cbm_cost * $totalCBM, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold h6">{{ __('Total Container Price') }}:</span>
                                        <span
                                            class="fw-bold h6 text-danger">${{ number_format($order->containerPrice, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold text-success">{{ __('Reserve Amount (50%)') }}:</span>
                                        <span class="fw-bold text-success">${{ number_format($reservePrice, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Grand Total -->
                        <div class="card bg-primary bg-opacity-10 border-primary border-2">
                            <div class="card-body text-center">
                                <h4 class="card-title text-primary mb-4">💰 {{ __('Total Cost Summary') }}</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex gap-2 mb-3">
                                            <span class="fw-bold">{{ __('Order Total') }}:</span>
                                            <span class="fw-bold">${{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex gap-2 mb-3">
                                            <span class="fw-bold">{{ __('Container Shipping') }}:</span>
                                            <span class="fw-bold">${{ number_format($order->containerPrice, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <hr class="d-md-none">
                                        <div class="d-flex gap-2">
                                            <span class="h4 fw-bold text-primary">{{ __('Grand Total') }}:</span>
                                            <span
                                                class="h4 fw-bold text-primary">${{ number_format($order->total + $order->containerPrice, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>



            <!-- Admin Actions -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <div class="btn-group" role="group">
                        <a href="{{ route('om.order.index', ['status' => $status]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to Orders') }}
                        </a>
                        @if ($order->status == App\Models\Order::STATUS_SUBMITTED)
                            <a href="{{ route('om.order.status', ['status' => encrypt(App\Models\Order::STATUS_CANCELED), 'order' => encrypt($order->id)]) }}"
                                class="btn btn-danger">
                                <i class="fas fa-ban"></i> {{ __('Cancel Order') }}
                            </a>
                            <a href="{{ route('om.order.status', ['status' => encrypt(App\Models\Order::STATUS_CONFIRM), 'order' => encrypt($order->id)]) }}"
                                class="btn btn-success">
                                <i class="fas fa-check"></i> {{ __('Confirm Order') }}
                            </a>
                        @elseif($order->status == App\Models\Order::STATUS_CONFIRM)
                            <a href="{{ route('om.order.status', ['status' => encrypt(App\Models\Order::STATUS_CANCELED), 'order' => encrypt($order->id)]) }}"
                                class="btn btn-danger">
                                <i class="fas fa-ban"></i> {{ __('Cancel Order') }}
                            </a>
                        @elseif($order->status == App\Models\Order::STATUS_CANCELED)
                            <a href="{{ route('om.order.status', ['status' => encrypt(App\Models\Order::STATUS_CONFIRM), 'order' => encrypt($order->id)]) }}"
                                class="btn btn-success">
                                <i class="fas fa-check"></i> {{ __('Confirm Order') }}
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
