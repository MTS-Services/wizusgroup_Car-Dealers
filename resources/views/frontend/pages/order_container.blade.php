@extends('frontend.layouts.app', ['page_slug' => 'orders'])

@section('title', 'Orders')

@section('content')
    <section class="xl:py-20 lg:py-16 md:py-12 py-8 bg-light dark:bg-dark">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="2xl:col-span-3 lg:col-span-5">
                    <div
                        class="bg-bg-light dark:bg-bg-dark-tertiary border border-border-gray dark:border-border-dark shadow-sm dark:shadow-dark-card rounded-xl p-6 grid grid-rows-[auto_1fr] h-full">

                        <!-- Top: Order number and status -->
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 items-center gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-text-dark dark:text-white">{{ __('Order Summary') }}
                                </h2>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                {{ $order->status_label }}
                            </span>
                        </div>

                        <!-- Bottom: Order info -->
                        <div class="grid grid-cols-1 gap-y-3 gap-x-12 text-sm">
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Order Number:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order->order_number }}
                                </p>
                            </div>
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Placed on:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order->created_at_formatted }}
                                </p>
                            </div>
                            {{-- <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Shipping Date:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order->container?->deadline_formatted }}
                                </p>
                            </div> --}}
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Shipping Port:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order->shippingPort?->name }}
                                </p>
                            </div>
                            <div>
                                <span
                                    class="font-medium text-text-dark dark:text-white">{{ __('Destination Port:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order->destinationPort?->name }}
                                </p>
                            </div>
                            <div class="flex justify-between items-end">
                                <span></span>
                                <p
                                    class="mt-1 font-bold text-text-dark border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ __('Order Price:') }}
                                    <span class="font-semibold text-text-dark dark:text-white">
                                        ${{ number_format($order->total, 2) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Order Items Card -->
                <div class="2xl:col-span-9 lg:col-span-7">
                    <div
                        class="bg-bg-light dark:bg-bg-dark-secondary rounded-lg shadow-sm dark:shadow-bg-dark-secondary border border-border-gray dark:border-bg-dark-tertiary">
                        <div class="p-5 border-b border-border-gray dark:border-border-dark dark:border-dark-tertiary">
                            <h2 class="text-xl font-semibold text-text-dark dark:text-white">{{ __('Order Items') }}</h2>
                        </div>
                        <div class="p-4 sm:p-6 max-h-[330px]">
                            <div id="orderItemsContainer"
                                class="grid grid-cols-1 2xl:grid-cols-2 gap-4 transition-all duration-300 ">


                                @foreach ($order->items as $item)
                                    <div
                                        class="bg-bg-light-secondary dark:bg-bg-dark-tertiary flex flex-col sm:flex-row gap-4 p-2 sm:p-4 border dark:border-border-dark border-border-gray dark:border-dark-tertiary rounded-lg">
                                        <div
                                            class="w-full sm:w-24 sm:h-24 h-36 bg-gray-100 dark:bg-dark-tertiary rounded-lg flex items-center justify-center">
                                            <img src="{{ storage_url($item->product?->primaryImage?->first()?->image) }}"
                                                alt="{{ $item->product?->primaryImage?->first()?->alt ?? $item->product?->name }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-xl text-text-dark dark:text-white">
                                                {{ $item->product?->name }}
                                            </h3>
                                            <p class="sm:text-sm text-xs text-text-gray dark:text-white mt-1">
                                                {{ $item->product?->brand?->name }}</p>
                                            <div class="flex items-center gap-4 mt-2">
                                                <span class="sm:text-sm text-xs text-text-gray dark:text-white">
                                                    {{ __('Quantity:') }} {{ $item->quantity }}
                                                </span>
                                                <span class="sm:text-sm text-xs text-text-gray dark:text-white">
                                                    {{ __('Unit Price:') }} ${{ number_format($item->unit_price, 2) }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-4 mt-2">
                                                <span class="sm:text-sm text-xs text-text-gray dark:text-white">
                                                    {{ __('Total Cubic Meter:') }}
                                                    {{ $item->product?->height_m * $item->product?->width_m * $item->product?->length_m }}
                                                    m
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="lg:text-lg sm:text-base text-sm font-semibold text-text-secondary dark:text-text-secondary">
                                                ${{ number_format($item->total, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="bg-bg-light dark:bg-bg-dark py-12">
        <div class="container">
            <div class="pb-5">
                <h1 class="text-xl md:text-2xl lg:text-3xl capitalize font-semibold text-text-primary dark:text-text-light">
                    {{ __('Available Containers - ') }}{{ $order->container_type == App\Models\Order::GROUP_SHIPPING ? 'Group Shipping' : 'Full Container' }}
                </h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 xl:grid-cols-3 2xl:grid-cols-3 gap-6 rounded-lg">
                @forelse ($containers as $container)
                    <div class="w-full h-full">
                        <div
                            class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden  transition-transform duration-300 hover:-translate-y-1 rounded-md flex flex-col justify-between">
                            <div class="p-5 pb-0">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                        {{ $container->title ?? 'Untitled' }}
                                    </h3>
                                    <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-xs font-medium">
                                        {{ $container->status_label ?? 'Active' }}
                                    </span>
                                </div>
                                <p class="text-sm text-text-gray mt-1 py-1">
                                    {{ __(' From:') }} {{ $container?->shippingPort?->name ?? 'N/A' }}
                                </p>
                                <p class="text-sm text-text-gray mt-1 py-1">
                                    {{ __('Destination:') }} {{ $container?->destinationPort?->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <div class="bg-bg-orange text-text-white w-fit px-3 py-1 rounded-md text-sm font-medium timer_countdown m-5 mt-2"
                                    data-endDate="{{ $container->deadline }}">
                                </div>
                                <div class="p-5 text-sm border-t border-border-gray dark:border-border-dark-secondary">
                                    <div class="flex items-center mb-2">
                                        <i class="far fa-calendar-alt text-text-gray dark:text-text-light mr-2 text-sm"></i>
                                        <span>{{ __('Deadline:') }} {{ dateFormat($container->deadline) }}</span>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <span>{{ __('Length:') }}</span>
                                                <span>{{ $container->length_m }} m</span>
                                            </div>
                                            <div>
                                                <span>{{ __('Width:') }}</span>
                                                <span>{{ $container->width_m }} m</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between">
                                            <div>
                                                <span>{{ __('Height:') }}</span>
                                                <span>{{ $container->height_m }} m</span>
                                            </div>
                                            <div>
                                                <span>{{ __('Max Weight:') }}</span>
                                                <span>{{ $container->max_weight_kg }} kg</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-medium">{{ __('Capacity') }}</span>
                                            <span>{{ $container->filled_percentage }}%
                                                {{ __('filled') }}</span>
                                        </div>
                                        <div class="w-full bg-bg-gray rounded-full h-2">
                                            <div class="bg-bg-wiz_orange h-2 rounded-full"
                                                style="width:{{ $container->filled_percentage }}%">
                                            </div>
                                        </div>
                                        <div class="py-3">
                                            <div class="space-y-3">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <span>{{ __('Base Cost:') }}</span>
                                                        <span>${{ number_format($container->base_cost, 2) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span>{{ __('Per CBM Cost:') }}</span>
                                                        <span>${{ number_format($container->per_cbm_cost, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between">
                                                    <div>
                                                        <span class="font-bold">{{ __('Total Cost:') }}</span>
                                                        @php
                                                            if (
                                                                $order->container_type ==
                                                                App\Models\Order::FULL_CONTAINER
                                                            ) {
                                                                $totalHeight = $container->height_m;
                                                                $totalWidth = $container->width_m;
                                                                $totalLength = $container->length_m;
                                                            }
                                                            $total_price =
                                                                $container->per_cbm_cost *
                                                                ($totalHeight + $totalWidth + $totalLength);
                                                            $total_price += $container->base_cost;
                                                        @endphp
                                                        <span class="font-bold">${{ number_format($total_price, 2) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="font-bold">{{ __('Reserve Price:') }}</span>
                                                        <span class="font-bold">${{ number_format($total_price / 2, 2) }}
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                            <x-frontend.primary-button bg="true"
                                                href="{{ route('frontend.order.join-container', ['orderNumber' => $order->order_number, 'containerSlug' => $container->slug]) }}"
                                                class="w-full mt-4">{{ __('Join Container') }}
                                            </x-frontend.primary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h3 class="text-sm text-text-gray dark:text-text-gray-50">
                        {{ __('Container not available for your delivery location') }}</h3>


                    <x-frontend.primary-button
                        href="{{ route('frontend.order.request-container', ['orderNumber' => $order->order_number]) }}">{{ __('Request a container') }}</x-frontend.primary-button>
                @endforelse
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('orderItemsContainer');
            const itemCount = container.children.length;

            const isMobile = window.matchMedia("(max-width: 768px)").matches;

            const applyScroll = () => {
                container.style.maxHeight = isMobile ? '200px' : '286px'; // Mobile e aro chhoto height
                container.style.overflowY = 'auto';
                container.style.paddingRight = '0.5rem';

                container.style.scrollbarWidth = 'thin'; // Firefox
                container.style.scrollbarColor = '#a0aec0 transparent';

                const style = document.createElement('style');
                style.innerHTML = `
            #orderItemsContainer::-webkit-scrollbar {
                width: 6px;
            }
            #orderItemsContainer::-webkit-scrollbar-thumb {
                background-color: #a0aec0;
                border-radius: 4px;
            }
            @media (prefers-color-scheme: dark) {
                #orderItemsContainer::-webkit-scrollbar-thumb {
                    background-color: #4b5563;
                }
            }
        `;
                document.head.appendChild(style);
            };

            // Instead of checking itemCount, we rely on actual height to decide scroll behavior
            // Use setTimeout to ensure rendering complete
            setTimeout(() => {
                const containerHeight = container.scrollHeight;
                const currentHeight = container.clientHeight;

                if ((isMobile && containerHeight > 200) || (!isMobile && containerHeight > 286)) {
                    applyScroll();
                }
            }, 50);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timers = document.querySelectorAll('.timer_countdown');

            timers.forEach(timer => {
                const endDate = moment(timer.dataset.enddate); // Use moment.js to parse the deadline

                function updateCountdown() {
                    const now = moment();
                    const duration = moment.duration(endDate.diff(now));

                    if (duration.asSeconds() <= 0) {
                        timer.innerText = 'Closed';
                        clearInterval(timer._interval);
                        return;
                    }

                    const days = Math.floor(duration.asDays());
                    const hours = duration.hours();
                    const minutes = duration.minutes();
                    const seconds = duration.seconds();

                    timer.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }

                updateCountdown(); // Initial render
                timer._interval = setInterval(updateCountdown, 1000); // Store interval on the element
            });
        });
    </script>
@endpush
