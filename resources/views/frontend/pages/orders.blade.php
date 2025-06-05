@extends('frontend.layouts.app', ['page_slug' => 'orders'])

@section('title', 'Orders')

@section('content')
    <section class="py-15 bg-light dark:bg-darky">
        <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Order Summary Card -->
                @php
                    $order = [
                        'order_number' => '#ORD-2024-001234',
                        'status' => 'Shipped',
                        'placed_on' => 'January 15, 2024 at 2:30 PM',
                        'shipping_date' => 'Jan 20, 2024',
                        'shipping_port' => 'New York, NY',
                        'destination_port' => 'Los Angeles, CA',
                        'total_price' => 667.0,
                    ];
                @endphp

                <div class="2xl:col-span-3 lg:col-span-5">
                    <div
                        class="bg-bg-light dark:bg-bg-dark-tertiary border border-gray-200 dark:border-border-dark shadow-sm dark:shadow-dark-card rounded-xl p-6">

                        <!-- Top: Order number and status -->
                        <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 items-center gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-text-dark dark:text-white">{{ __('Order Summary') }}
                                </h2>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                {{ __($order['status']) }}
                            </span>
                        </div>

                        <!-- Bottom: Order info -->
                        <div class="grid grid-cols-1 gap-y-3 gap-x-12 text-sm">
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Order Number:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order['order_number'] }}
                                </p>
                            </div>
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Placed on:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order['placed_on'] }}
                                </p>
                            </div>
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Shipping Date:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order['shipping_date'] }}
                                </p>
                            </div>
                            <div>
                                <span class="font-medium text-text-dark dark:text-white">{{ __('Shipping Port:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order['shipping_port'] }}
                                </p>
                            </div>
                            <div>
                                <span
                                    class="font-medium text-text-dark dark:text-white">{{ __('Destination Port:') }}</span>
                                <p
                                    class="mt-1 text-text-gray border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ $order['destination_port'] }}
                                </p>
                            </div>
                            <div class="flex justify-between items-end">
                                <span></span>
                                <p
                                    class="mt-1 font-bold text-text-dark border-b border-border-gray/60 dark:border-border-dark dark:text-white">
                                    {{ __('Total Price:') }}
                                    <span class="font-semibold text-text-dark dark:text-white">
                                        ${{ number_format($order['total_price'], 2) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Order Items Card -->
                @php
                    $orderItems = [
                        [
                            'name' => 'JCB 3DX EcoXpert Backhoe Loader',
                            'brand' => 'JCB / JCB 3DX Backhoe Loader',
                            'quantity' => 1,
                            'unit_price' => 667.0,
                            'image' => 'frontend/images/special (2).jpg',
                        ],
                        [
                            'name' => 'CAT 424B2 Backhoe Loader',
                            'brand' => 'Caterpillar / CAT 424B2',
                            'quantity' => 2,
                            'unit_price' => 715.0,
                            'image' =>
                                'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        ],
                        [
                            'name' => 'CAT 424B2 Backhoe Loader',
                            'brand' => 'Caterpillar / CAT 424B2',
                            'quantity' => 2,
                            'unit_price' => 715.0,
                            'image' =>
                                'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        ],
                        [
                            'name' => 'CAT 424B2 Backhoe Loader',
                            'brand' => 'Caterpillar / CAT 424B2',
                            'quantity' => 2,
                            'unit_price' => 715.0,
                            'image' =>
                                'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        ],
                        [
                            'name' => 'CAT 424B2 Backhoe Loader',
                            'brand' => 'Caterpillar / CAT 424B2',
                            'quantity' => 2,
                            'unit_price' => 715.0,
                            'image' =>
                                'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        ],
                        // ... other items ...
                    ];
                @endphp

                <div class="2xl:col-span-9 lg:col-span-7">
                    <div
                        class="bg-bg-light dark:bg-bg-dark-secondary rounded-lg shadow-sm dark:shadow-bg-dark-secondary border border-border-gray dark:border-bg-dark-tertiary">
                        <div
                            class="p-5 border-b border-border-gray dark:border-border-dark-secondary dark:border-dark-tertiary">
                            <h2 class="text-xl font-semibold text-text-dark dark:text-white">{{ __('Order Items') }}</h2>
                        </div>
                        <div class="p-4 sm:p-6 max-h-[330px]">
                            <div id="orderItemsContainer"
                                class="grid grid-cols-1 2xl:grid-cols-2 gap-4 transition-all duration-300 ">


                                @foreach ($orderItems as $item)
                                    <div
                                        class="bg-bg-light-secondary dark:bg-bg-dark-tertiary flex flex-col sm:flex-row gap-4 p-2 sm:p-4 border dark:border-border-dark border-border-gray dark:border-dark-tertiary rounded-lg">
                                        <div
                                            class="w-full sm:w-24 sm:h-24 h-36 bg-gray-100 dark:bg-dark-tertiary rounded-lg flex items-center justify-center">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                class="w-full h-full object-cover rounded-lg">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-xl text-text-dark dark:text-white">{{ $item['name'] }}
                                            </h3>
                                            <p class="sm:text-sm text-xs text-text-gray dark:text-white mt-1">{{ $item['brand'] }}</p>
                                            <div class="flex items-center gap-4 mt-2">
                                                <span class="sm:text-sm text-xs text-text-gray dark:text-white">
                                                    {{ __('Quantity:') }} {{ $item['quantity'] }}
                                                </span>
                                                <span class="sm:text-sm text-xs text-text-gray dark:text-white">
                                                    {{ __('Unit Price:') }} ${{ number_format($item['unit_price'], 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="lg:text-lg sm:text-base text-sm font-semibold text-text-secondary dark:text-text-secondary">
                                                ${{ number_format($item['quantity'] * $item['unit_price'], 2) }}
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
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('orderItemsContainer');
            const itemCount = container.children.length;

            const isMobile = window.matchMedia("(max-width: 768px)").matches;

         if ((isMobile && itemCount > 1) || (!isMobile && itemCount > 4)) {
                container.style.maxHeight = '286px';
                container.style.overflowY = 'auto';
                container.style.paddingRight = '0.5rem'; // pr-2

                // Basic inline scrollbar style (WebKit only)
                container.style.scrollbarWidth = 'thin'; // Firefox
                container.style.scrollbarColor = '#a0aec0 transparent'; // gray-400

                // WebKit specific scrollbar styling
                const style = document.createElement('style');
                style.innerHTML = `
                #orderItemsContainer::-webkit-scrollbar {
                    width: 6px;
                }
                #orderItemsContainer::-webkit-scrollbar-thumb {
                    background-color: #a0aec0; /* gray-400 */
                    border-radius: 4px;
                }
                @media (prefers-color-scheme: dark) {
                    #orderItemsContainer::-webkit-scrollbar-thumb {
                        background-color: #4b5563; /* gray-700 */
                    }
                }
            `;
                document.head.appendChild(style);
            }
        });
    </script>
@endpush
