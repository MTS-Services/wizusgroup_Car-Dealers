@extends('backend.admin.layouts.master', ['page_slug' => 'container_reservation'])
@section('title', 'Container Reservation List')
@section('content')
    <section class="py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="h4 mb-0">{{ __('Container Reservation Details') }}</h4>
        </div>

        <div class="bg-white shadow-sm border rounded p-4">
            <!-- Header -->
            <div class="border-bottom pb-3 mb-4">
                <div class="row align-items-baseline gy-3">
                    <div class="col-md-3">
                        <p class="mb-0 fw-bold text-uppercase">{{ __('Container') }}</p>
                        <h5 class="mb-0">{{ $container_reserve->container?->title ?? __('Untitled') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0 fw-bold text-uppercase">{{ __('From') }}</p>
                        <p class="mb-0">{{ $container_reserve->container?->shippingPort?->name ?? __('N/A') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p class="mb-0 fw-bold text-uppercase">{{ __('Destination') }}</p>
                        <p class="mb-0">{{ $container_reserve->container?->destinationPort?->name ?? __('N/A') }}</p>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge {{ $container_reserve->status_color }}">
                            {{ $container_reserve->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div>
                <!-- Deadline -->
                <div class="d-flex align-items-center mb-4">
                    <i class="far fa-calendar-alt me-2"></i>
                    <span class="fw-medium">
                        {{ __('Deadline:') }} {{ dateFormat($container_reserve->container?->deadline) }}
                    </span>
                </div>

                <!-- Image and Specs Grid -->
                <div class="row g-4">
                    <!-- Image -->
                    <div class="col-md-5">
                        <img src="{{ storage_url($container_reserve->container?->image) }}"
                            alt="{{ $container_reserve->container?->title ?? 'Untitled' }}" class="img-fluid rounded">
                    </div>

                    <!-- Specs -->
                    <div class="col-md-7">
                        <!-- Reservations -->
                        @foreach ($container_reserve->container?->containerReservations as $key => $reservation)
                            <div
                                class="bg-light p-3 rounded mb-3 d-flex justify-content-between align-items-center flex-wrap">
                                <p class="mb-0 fw-bold text-uppercase">{{ __('Order-') . $key + 1 }}</p>
                                <p class="mb-0 fw-bold text-uppercase">#{{ $reservation->order?->order_number }}</p>
                                <p class="mb-0 fw-bold">
                                    {{ $reservation->length_m * $reservation->width_m * $reservation->height_m }} m3
                                </p>
                                <p class="mb-0 fw-bold">${{ number_format($reservation->order->total, 2) }}</p>
                                <p class="mb-0 fw-bold">
                                    <a class="text-primary text-decoration-underline"
                                        href="{{ route('user.order.details', $reservation->order?->order_number) }}">
                                        {{ __('Details') }}
                                    </a>
                                </p>
                            </div>
                        @endforeach

                        <!-- Container Specs -->
                        @php
                            $container_volume = number_format(
                                $container_reserve->container?->length_m *
                                    $container_reserve->container?->width_m *
                                    $container_reserve->container?->height_m,
                            );
                            $my_volume = number_format(
                                $container_reserve->length_m *
                                    $container_reserve->width_m *
                                    $container_reserve->height_m,
                            );

                            $specs = [
                                'Length' => "{$container_reserve->container?->length_m} m",
                                'Width' => "{$container_reserve->container?->width_m} m",
                                'Height' => "{$container_reserve->container?->height_m} m",
                                'Max Weight' => "{$container_reserve->container?->max_weight_kg} kg",
                                'Base Cost' => '$' . number_format($container_reserve->container?->base_cost, 2),
                                'Container Volume' => "{$container_volume} m3",
                                'Per Cubic Meter Cost' =>
                                    '$' . number_format($container_reserve->container?->per_cbm_cost, 2),
                                'Customer Volume' => "{$my_volume} m3",
                                'Container Cost' =>
                                    '$' .
                                    number_format(
                                        $container_reserve->container?->containerReservations->sum('price'),
                                        2,
                                    ),
                                'Reserve Cost' =>
                                    '$' .
                                    number_format(
                                        $container_reserve->container?->containerReservations->sum('reserve_price'),
                                        2,
                                    ),
                            ];
                        @endphp

                        <div class="row">
                            @foreach ($specs as $label => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="bg-light p-3 rounded d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-uppercase fw-medium">{{ __($label) }}</p>
                                        <p class="mb-0 fw-bold">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Capacity Bar -->
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium">{{ __('Capacity') }}</span>
                                <span>{{ $container_reserve->container?->filled_percentage }}%
                                    {{ __('filled') }}</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ $container_reserve->container?->filled_percentage }}%;"
                                    aria-valuenow="{{ $container_reserve->container?->filled_percentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
