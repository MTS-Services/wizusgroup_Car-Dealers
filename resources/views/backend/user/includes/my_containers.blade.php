<div class="p-10 pt-0">
    <div class="max-w-6xl mx-auto">
        <!-- My Containers Panel Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-text-primary dark:text-text-white">{{ __('My Containers') }}</h2>
            <p class="text-text-gray dark:text-text-light">{{ __('Track and manage your container shipments') }}</p>
        </div>
        <!-- Filters -->
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="{{ route('user.profile', ['slug' => 'containers', 'tab' => 'all']) }}"
                class="btn-item {{ request('tab') == 'all' || request('tab') == null ? ' bg-bg-tertiary ' : '' }} btn-primary hover:bg-bg-tertiary py-2 rounded-md"
                data-tab="all">
                {{ __('All Containers') }}
            </a>
            <a href="{{ route('user.profile', ['slug' => 'containers', 'tab' => 'active']) }}"
                class="btn-item btn-primary {{ request('tab') == 'active' ? ' bg-bg-tertiary ' : '' }} hover:bg-bg-tertiary py-2 rounded-md"
                data-tab="Active">
                {{ __('Active') }}
            </a>
            <a href="{{ route('user.profile', ['slug' => 'containers', 'tab' => 'shipped']) }}"
                class="btn-item btn-primary {{ request('tab') == 'shipped' ? ' bg-bg-tertiary ' : '' }} hover:bg-bg-tertiary py-2 rounded-md"
                data-tab="Shipped">
                {{ __('Shipped') }}
            </a>
            <a href="{{ route('user.profile', ['slug' => 'containers', 'tab' => 'delivered']) }}"
                class="btn-item btn-primary {{ request('tab') == 'delivered' ? ' bg-bg-tertiary ' : '' }} hover:bg-bg-tertiary py-2 rounded-md"
                data-tab="Delivered">
                {{ __('Delivered') }}
            </a>
            <div class="ml-auto">
                <a href="{{ route('frontend.group_shipping') }}"
                    class="btn-primary py-2 bg-bg-wiz_green rounded-md hover:bg-bg-tertiary">
                    <i class="fas fa-plus mr-2"></i> {{ __('Join a Shipment') }}
                </a>
            </div>
        </div>

        <!-- Containers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Container Card 1 -->
            @forelse ($containers as $container)
                <!-- Container Card (Left Column) -->
                <div class="container-card" data-status="{{ $container->status_label }}">
                    <div
                        class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary transition-transform duration-300 hover:-translate-y-1 rounded-md h-full flex flex-col justify-between">
                        <div class="p-5 pb-0">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ $container->title ?? 'Untitled' }}
                                </h3>
                                <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-xs font-medium">
                                    {{ $container->status_label }}
                                </span>
                            </div>
                            <p class="text-sm text-text-gray mt-1 py-1">
                                {{ __(' From:') }} {{ $container->shippingPort?->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-text-gray mt-1 py-1">
                                {{ __('Destination:') }} {{ $container->destinationPort?->name ?? 'N/A' }}
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
                                        <span>{{ $container->getFilledPercentageAttribute() }}%
                                            {{ __('filled') }}</span>
                                    </div>
                                    <div class="w-full bg-bg-gray rounded-full h-2">
                                        <div class="bg-bg-wiz_orange h-2 rounded-full"
                                            style="width:{{ $container->getFilledPercentageAttribute() }}%">
                                        </div>
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
                                                <span
                                                    class="font-bold">${{ number_format($container->containerReservations->sum('price'), 2) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="font-bold">{{ __('Reserve Price:') }}</span>
                                                <span
                                                    class="font-bold">${{ number_format($container->containerReservations->sum('reserve_price'), 2) }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    <x-frontend.primary-button bg="true" class="mt-4"
                                        href="{{ route('user.container.details', $container->slug) }}">{{ __('View Details') }}
                                    </x-frontend.primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div id="no-containers-message"
                    class="hidden text-2xl font-semibold text-text-primary dark:text-text-light text-center uppercase bg-bg-white dark:bg-opacity-30 rounded-lg p-5 shadow-card">
                    {{ __('Containers Not Found') }}
                </div>
            @endforelse
        </div>



        <!-- Pagination -->
        @if ($containers->hasPages())
            <div
                class="px-6 py-4 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                <div class="text-sm text-text-gray dark:text-text-light">
                    Showing <span class="font-medium">{{ $containers->firstItem() }}</span> to
                    <span class="font-medium">{{ $containers->lastItem() }}</span> of
                    <span class="font-medium">{{ $containers->total() }}</span> orders
                </div>

                <div class="flex space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($containers->onFirstPage())
                        <span
                            class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm opacity-50 cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="{{ $containers->previousPageUrl() }}"
                            class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                            Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($containers->getUrlRange(1, $containers->lastPage()) as $page => $url)
                        @if ($page == $containers->currentPage())
                            <span class="btn-primary py-1 px-3 rounded-md text-sm bg-bg-tertiary text-text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($containers->hasMorePages())
                        <a href="{{ $containers->nextPageUrl() }}"
                            class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                            Next
                        </a>
                    @else
                        <span
                            class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm opacity-50 cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
