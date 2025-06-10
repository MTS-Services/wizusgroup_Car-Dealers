@extends('frontend.layouts.app', ['page_slug' => 'my-container'])
@section('title', 'My Container')

@section('content')
    <section class="py-10">
        <div class="container">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl md:text-2xl font-semibold mb-0 ps-2">{{ __('My Container Details') }}</h4>
                <a href="{{ route('user.profile', ['slug' => 'containers']) }}"
                    class="btn-primary py-2  bg-bg-primary rounded-md hover:bg-bg-tertiary">
                    {{ __('Back') }}
                </a>
            </div>
            <div
                class="{{ isset($container) ? 'col-span-9' : 'col-span-12' }} bg-white dark:bg-bg-dark-tertiary shadow-md dark:shadow-lg overflow-hidden border border-gray-200 dark:border-border-dark-secondary rounded-lg">
                <!-- Header -->
                <div class="p-5 border-b border-gray-200 dark:border-border-dark-secondary">
                    <div class="flex justify-between items-baseline flex-wrap gap-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                            {{ $container->title ?? __('Untitled') }}
                        </h3>
                        <div>
                            <p class="text-base uppercase font-medium text-text-primary dark:text-text-light">
                                {{ __('From') }}
                            </p>
                            <p class="text-sm text-text-primary dark:text-text-light">
                                {{ $container->shippingPort?->name ?? __('N/A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-base uppercase font-medium text-text-primary dark:text-text-light">
                                {{ __('Destination') }}
                            </p>
                            <p class="text-sm text-text-primary dark:text-text-light">
                                {{ $container->destinationPort?->name ?? __('N/A') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 bg-green-600 text-white rounded-full text-sm font-medium">
                            {{ $container->status_label }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 text-sm text-text-primary dark:text-text-light">
                    <!-- Deadline -->
                    <div class="flex items-center mb-4">
                        <i class="far fa-calendar-alt mr-2 text-sm"></i>
                        <span class="font-medium text-base">
                            {{ __('Deadline:') }} {{ dateFormat($container->deadline) }}
                        </span>
                    </div>

                    <!-- Image and Specs Grid -->
                    <div class="grid grid-cols-5 gap-4">
                        <!-- Image -->
                        <div class="col-span-2">
                            <img src="{{ storage_url($container->image) }}" alt="{{ $container->title ?? 'Untitled' }}"
                                class="w-full max-h-80 h-full object-cover rounded-md">
                        </div>

                        <!-- Specs -->
                        <div class="col-span-3">
                            <div class="grid grid-cols-1 gap-4 mb-5">
                                @foreach ($container->containerReservations as $key => $reservation)
                                    <div
                                        class="bg-gray-100 dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center">
                                        <p class="text-base uppercase font-bold">
                                            {{ __('Order-') . $key + 1 }}</p>
                                        <p class="text-base uppercase font-bold">
                                            #{{ $reservation->order?->order_number }}</p>
                                        <p class="text-base font-bold">
                                            {{ $reservation->length_m * $reservation->width_m * $reservation->height_m }}
                                            m3
                                        </p>
                                        <p class="text-base font-bold">
                                            ${{ number_format($reservation->order->total, 2) }}
                                        </p>
                                        <p class="text-base font-bold">
                                            <a class="text-blue-600"
                                                href="{{ route('user.order.details', $reservation->order?->order_number) }}">{{ __('Details') }}</a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                @php
                                    $container_volume =
                                        $container->length_m * $container->width_m * $container->height_m;
                                    $my_volume =
                                        $container->containerReservations->sum('length_m') *
                                        $container->containerReservations->sum('width_m') *
                                        $container->containerReservations->sum('height_m');
                                    $specs = [
                                        'Length' => "{$container->length_m} m",
                                        'Width' => "{$container->width_m} m",
                                        'Height' => "{$container->height_m} m",
                                        'Max Weight' => "{$container->max_weight_kg} kg",
                                        'Base Cost' => '$' . number_format($container->base_cost, 2),
                                        'Container Volume' => "{$container_volume} m3",
                                        'Per Cubic Meter Cost' => '$' . number_format($container->per_cbm_cost, 2),
                                        'My Volume' => "{$my_volume} m3",
                                        'Container Cost' =>
                                            '$' . number_format($container->containerReservations->sum('price'), 2),
                                        'Reserve Cost' =>
                                            '$' .
                                            number_format($container->containerReservations->sum('reserve_price'), 2),
                                    ];
                                @endphp



                                @foreach ($specs as $label => $value)
                                    <div
                                        class="bg-gray-100 dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center">
                                        <p class="text-base uppercase font-medium">{{ __($label) }}</p>
                                        <p class="text-base font-bold">{{ $value }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Capacity Bar -->
                            <div class="pt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium text-base">{{ __('Capacity') }}</span>
                                    <span>{{ $container->getFilledPercentageAttribute() }}%
                                        {{ __('filled') }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full"
                                        style="width: {{ $container->getFilledPercentageAttribute() }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
