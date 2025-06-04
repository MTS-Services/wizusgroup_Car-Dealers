<section class="py-6 sm:py-8 lg:py-20">
    <div class="container mx-auto">
        <div
            class="grid grid-cols-2 gap-6 shadow-lg dark:shadow-dark-card bg-bg-light dark:bg-bg-dark-tertiary p-4 sm:p-5 md:p-6">
            <!-- Container Card (Left Column) -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6 lg:gap-8 ">
                    @foreach ($containers as $container)
                        <div class="w-full h-full">
                            <div
                                class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary transition-transform duration-300 hover:-translate-y-1 flex flex-col justify-between">
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
                                        </div>
                                        <div class="flex space-x-2 mt-5">
                                            <a href="{{ route('frontend.join-group-shipping', ['container_slug' => $container->slug]) }}"
                                                class="flex-1 py-2 px-3 rounded-md font-semibold bg-bg-wiz_orange text-white hover:bg-bg-wiz_orange/90 shadow-md hover:shadow-lg text-center text-sm">
                                                Join Group Shipping
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Products Card (Right Column spans 2 cols) -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6 lg:gap-8 ">
                    @foreach ($container_products as $product)
                        <div
                            class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden transition-all duration-300 hover:shadow-xl group border border-border-gray dark:border-border-dark-secondary w-full">
                            <div class="w-full h-40 xs:h-44 sm:h-48 md:h-56 overflow-hidden relative">
                                <img src="{{ storage_url($product->product?->primaryImage->first()?->image) }}"
                                    alt="{{ $product->product?->name ?? 'Untitled' }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                            </div>

                            <div class="p-3 sm:p-4 flex flex-col">
                                <div class="flex-grow">
                                    <h3
                                        class="text-sm sm:text-base font-semibold text-text-primary dark:text-text-light group-hover:text-bg-wiz_orange transition-colors line-clamp-2">
                                        {{ $product->product?->name ?? 'Untitled' }}
                                    </h3>
                                    <div class="flex justify-between">
                                        <div
                                            class="text-2xs xs:text-xs sm:text-sm text-text-gray dark:text-text-light mt-1 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1 text-2xs"></i>
                                            {{ $product->container->shippingPort?->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-2 sm:mb-3">
                                        <div class="text-lg sm:text-xl font-bold text-text-dark dark:text-white">
                                            {{ "$" . $product->price }}
                                        </div>
                                        <div
                                            class="text-2xs xs:text-xs text-text-gray dark:text-text-light bg-bg-gray dark:bg-bg-dark-secondary px-1.5 py-0.5 rounded">
                                            {{ __('Reserve $') }}{{ $product->reserve_price }}
                                        </div>
                                    </div>
                                    {{-- @if ($container_quantity <= $reserve_quantity)
                                        <div class="flex space-x-2">
                                            <button
                                                class="flex-1 py-2 px-3 rounded-md font-semibold bg-bg-gray text-red-500 hover:bg-bg-gray/90 shadow-md hover:shadow-lg text-center text-sm">
                                                Full
                                            </button>
                                        </div>
                                    @else --}}
                                    <div class="flex space-x-2">
                                        <a href="{{ route('frontend.join-group-shipping', ['container_slug' => $product->container->slug, 'product_slug' => $product->product?->slug]) }}"
                                            class="flex-1 py-2 px-3 rounded-md font-semibold bg-bg-wiz_orange text-white hover:bg-bg-wiz_orange/90 shadow-md hover:shadow-lg text-center text-sm">
                                            Reserve Now
                                        </a>
                                    </div>
                                    {{-- @endif --}}

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
