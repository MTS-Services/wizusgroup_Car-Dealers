@extends('frontend.layouts.app', ['page_slug' => 'orders'])

@section('title', 'Orders')

@section('content')
    <section class="xl:py-20 lg:py-16 md:py-12 py-8 bg-light dark:bg-dark">
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
                        class="bg-bg-light dark:bg-bg-dark-tertiary border border-border-gray dark:border-border-dark shadow-sm dark:shadow-dark-card rounded-xl p-6">

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
                        // [
                        //     'name' => 'CAT 424B2 Backhoe Loader',
                        //     'brand' => 'Caterpillar / CAT 424B2',
                        //     'quantity' => 2,
                        //     'unit_price' => 715.0,
                        //     'image' =>
                        //         'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        // ],
                        // [
                        //     'name' => 'CAT 424B2 Backhoe Loader',
                        //     'brand' => 'Caterpillar / CAT 424B2',
                        //     'quantity' => 2,
                        //     'unit_price' => 715.0,
                        //     'image' =>
                        //         'https://images.unsplash.com/photo-1616627982103-1c32275b87b7?auto=format&fit=crop&w=800&q=80',
                        // ],
                        // ... other items ...
                    ];
                @endphp

                <div class="2xl:col-span-9 lg:col-span-7">
                    <div
                        class="bg-bg-light dark:bg-bg-dark-secondary rounded-lg shadow-sm dark:shadow-bg-dark-secondary border border-border-gray dark:border-bg-dark-tertiary">
                        <div class="p-5 border-b border-border-gray dark:border-border-dark dark:border-dark-tertiary">
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
                                            <h3 class="font-semibold text-xl text-text-dark dark:text-white">
                                                {{ $item['name'] }}
                                            </h3>
                                            <p class="sm:text-sm text-xs text-text-gray dark:text-white mt-1">
                                                {{ $item['brand'] }}</p>
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
                                            <p
                                                class="lg:text-lg sm:text-base text-sm font-semibold text-text-secondary dark:text-text-secondary">
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
    <section>
        {{-- Available for Cotainers --}}
        @if ($containers->count() > 0)
            <section class="bg-bg-light dark:bg-bg-dark py-12">
                <div class="container">
                    <div class="pb-5">
                        <h1
                            class="text-xl md:text-2xl lg:text-3xl capitalize font-semibold text-text-primary dark:text-text-light">
                            {{ __('Available Containers') }}</h1>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6 rounded-lg">
                        @foreach ($containers as $container)
                            <div class="w-full h-full">
                                <div
                                    class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden  transition-transform duration-300 hover:-translate-y-1 rounded-md flex flex-col justify-between">
                                    <div class="p-5 pb-0">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                                {{ $container->title ?? 'Untitled' }}
                                            </h3>
                                            <span
                                                class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-xs font-medium">
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
                                        <div
                                            class="p-5 text-sm border-t border-border-gray dark:border-border-dark-secondary">
                                            <div class="flex items-center mb-2">
                                                <i
                                                    class="far fa-calendar-alt text-text-gray dark:text-text-light mr-2 text-sm"></i>
                                                <span>{{ __('Deadline:') }} {{ dateFormat($container->deadline) }}</span>
                                            </div>

                                            <div class="space-y-3">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <span>Length:</span>
                                                        <span>{{ $container->length_m }} m</span>
                                                    </div>
                                                    <div>
                                                        <span>Width:</span>
                                                        <span>{{ $container->width_m }} m</span>
                                                    </div>
                                                </div>
                                                <div class="flex justify-between">
                                                    <div>
                                                        <span>Height:</span>
                                                        <span>{{ $container->height_m }} m</span>
                                                    </div>
                                                    <div>
                                                        <span>Max Weight:</span>
                                                        <span>{{ $container->max_weight_kg }} kg</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="pt-3">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-medium">Capacity</span>
                                                    <span>{{ $container->getFilledPercentageAttribute() }}% filled</span>
                                                </div>
                                                <div class="w-full bg-bg-gray rounded-full h-2">
                                                    <div class="bg-bg-wiz_orange h-2 rounded-full"
                                                        style="width:{{ $container->getFilledPercentageAttribute() }}%">
                                                    </div>
                                                </div>
                                               <div class="py-3">
                                                     <x-frontend.primary-button bg="true" onclick="document.getElementById('-modal').showModal()" class="w-full mt-4">{{ __('Join Group Shipping') }} </x-frontend.primary-button>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

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
    <script>
        $(document).ready(function() {

            function getPrice(cbm, weight_kg) {
                let base_cost = `{{ $container->base_cost }}`;
                let per_cbm_cost = `{{ $container->per_cbm_cost }}`;
                let per_kg_cost = `{{ $container->per_kg_cost }}`;
                let price = base_cost + (cbm * per_cbm_cost);
                // let price = base_cost + (cbm * per_cbm_cost) + (weight_kg * per_kg_cost);
                $('#price').val(numberFormat(price, 2, false));
                $('#reserve_price').val(numberFormat((price / 2), 2, false));

            }

            $('#quantity').on('input', function() {

                let cbm = $('#height_m').val() * $('#width_m').val() * $('#length_m').val();
                let weight_kg = $('#weight_kg').val();
                getPrice(cbm, weight_kg);

                if ($('#quantity').val() < 1) {
                    $('#price').val(0);
                    $('#reserve_price').val(0);
                } else {
                    $('#price').val(numberFormat($('#price').val() * $(this).val(), 2, false));
                    $('#reserve_price').val(numberFormat($('#reserve_price').val() * $(this).val(), 2,
                        false));
                }

            });

            $('#product_id').on('change', async function() {
                let route = "{{ route('axios.get-product') }}";
                let product = await getProduct($(this).val(), route);
                if (product == null) {
                    $('#product_name').val('');
                    $('#height_m').val('');
                    $('#width_m').val('');
                    $('#length_m').val('');
                    $('#weight_kg').val('');
                    return;
                } else {
                    $('#product_name').val(product.name);
                    $('#height_m').val(product.height_m);
                    $('#width_m').val(product.width_m);
                    $('#length_m').val(product.length_m);
                    $('#weight_kg').val(product.weight_kg);
                    $('#quantity').val(1);
                    let cbm = product.height_m * product.width_m * product.length_m;
                    let weight_kg = product.weight_kg;
                    getPrice(cbm, weight_kg);
                }

                console.log(product); // Now logs the actual product
            });

        });
    </script>
@endpush
