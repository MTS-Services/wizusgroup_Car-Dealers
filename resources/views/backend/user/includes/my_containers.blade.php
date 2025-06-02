<div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
    <div class="max-w-6xl mx-auto">
        <!-- My Containers Panel Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('My Containers') }}</h2>
            <p class="text-text-gray">{{ __('Track and manage your container shipments') }}</p>
        </div>
        <!-- Filters -->
        <div class="mb-6 flex flex-wrap gap-2">
            <a href="#" class="btn-item bg-bg-tertiary btn-primary hover:bg-bg-tertiary py-2 rounded-md"
                data-tab="all">
                All Containers
            </a>
            <a href="#" class="btn-item btn-primary hover:bg-bg-tertiary py-2 rounded-md" data-tab="Active">
                Active
            </a>
            <a href="#" class="btn-item btn-primary hover:bg-bg-tertiary py-2 rounded-md" data-tab="Shipped">
                {{ __('Shipped') }}
            </a>
            <a href="#" class="btn-item btn-primary hover:bg-bg-tertiary py-2 rounded-md" data-tab="Delivered">
                {{ __('Delivered') }}
            </a>
            <div class="ml-auto">
                <a href="#" class="btn-primary py-2 bg-bg-wiz_green rounded-md hover:bg-bg-tertiary">
                    <i class="fas fa-plus mr-2"></i> {{ __('Join a Shipment') }}
                </a>
            </div>
        </div>

        <!-- Containers Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Container Card 1 -->
            @foreach ($my_containers as $container)
                <!-- Container Card (Left Column) -->
                <div class="container-card" data-status="{{ $container->container?->status_label }}">
                    <div
                        class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary transition-transform duration-300 hover:-translate-y-1 rounded-md h-full flex flex-col justify-between">
                        <div class="p-5 pb-0">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ $container->container?->title ?? 'Untitled' }}
                                </h3>
                                <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-xs font-medium">
                                    {{ $container->container?->status_label }}
                                </span>
                            </div>
                            <p class="text-sm text-text-gray mt-1 py-1">
                                {{ __(' From:') }} {{ $container->container?->shippingPort?->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-text-gray mt-1 py-1">
                                {{ __('Destination:') }} {{ $container->container?->destinationPort?->name ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <div class="bg-bg-orange text-text-white w-fit px-3 py-1 rounded-md text-sm font-medium timer_countdown m-5 mt-2"
                                data-endDate="{{ $container->container?->deadline }}">
                            </div>

                            <div class="p-5 text-sm border-t border-border-gray dark:border-border-dark-secondary">
                                <div class="flex items-center mb-2">
                                    <i class="far fa-calendar-alt text-text-gray dark:text-text-light mr-2 text-sm"></i>
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
                                            <span>{{ $container->container?->max_weight_kg }} kg</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-medium">Capacity</span>
                                        <span>{{ $container->container?->getFilledPercentageAttribute() }}%
                                            filled</span>
                                    </div>
                                    <div class="w-full bg-bg-gray rounded-full h-2">
                                        <div class="bg-bg-wiz_orange h-2 rounded-full"
                                            style="width:{{ $container->container?->getFilledPercentageAttribute() }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2 mt-5">
                                    <a href="{{ route('user.container.details', encrypt($container->id)) }}"
                                        class="flex-1 py-2 px-3 rounded-md font-semibold bg-bg-wiz_orange text-white hover:bg-bg-wiz_orange/90 shadow-md hover:shadow-lg text-center text-sm">
                                        {{ __('View Details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div id="no-containers-message"
            class="hidden text-2xl font-semibold text-text-primary dark:text-text-light text-center uppercase bg-bg-white rounded-lg p-5 shadow-card">
            {{ __('No Data Found') }}
        </div>
        {{-- @if ($my_containers->count() == 0 )
            <h1
                class="text-2xl font-semibold text-text-primary dark:text-text-light text-center uppercase bg-bg-white rounded-lg p-5 shadow-card">
                No containers found</h1>
        @endif --}}

        <!-- Pagination -->
        <div
            class="px-6 py-4 mt-5 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
            <div class="text-sm text-text-gray dark:text-text-light">
                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span
                    class="font-medium">12</span>
                Containers
            </div>
            <div class="flex space-x-2">
                <a href="#"
                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm disabled:opacity-50"
                    disabled>
                    Previous
                </a>
                <a href="#" class="btn-primary py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary">
                    1
                </a>
                <a href="#"
                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                    2
                </a>
                <a href="#"
                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                    3
                </a>
                <a href="#"
                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                    4
                </a>
                <a href="#"
                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                    Next
                </a>
            </div>
        </div>
    </div>
</div>
