@extends('frontend.layouts.app')

@section('content')
    <section class="py-6 sm:py-8 lg:py-12 bg-bg-light dark:bg-bg-dark-tertiary">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Container Details --}}
                <div
                    class="lg:col-span-6  bg-bg-white dark:bg-bg-dark-tertiary  shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg">
                    <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                {{ $container_product?->container->title ?? 'Untitled' }}
                            </h3>
                            <span
                                class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-base font-medium">  {{ $container_product?->container->status_label ?? 'Active' }}
                        </span>
                    </div>
                    <div class="grid
                                grid-cols-2 gap-2 mt-3">
                                <div>
                                    <p class="text-base text-text-primary uppercase font-medium">From</p>
                                    <p class="text-sm text-text-primary dark:text-text-light">
                                        {{ $container_product?->container->shippingPort?->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-base text-text-primary uppercase font-medium">Destination</p>
                                    <p class="text-sm text-text-primary dark:text-text-light">
                                        {{ $container_product?->container->destinationPort?->name ?? 'N/A' }}
                                    </p>
                                </div>
                        </div>
                    </div>

                    <div class="p-5 text-sm text-text-primary dark:text-text-light">
                        <div class="flex items-center mb-4">
                            <i class="far fa-calendar-alt text-text-primary dark:text-text-light mr-2 text-sm"></i>
                            <span class="font-medium text-base">Deadline:
                                {{ dateFormat($container_product?->container->deadline) }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                <p class="text-base text-text-primary uppercase font-medium">Length</p>
                                <p class="text-sm font-medium">{{ $container_product?->container->length_cm }} cm</p>
                            </div>
                            <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                <p class="text-base text-text-primary uppercase font-medium">Width</p>
                                <p class="text-sm font-medium">{{ $container_product?->container->width_cm }} cm</p>
                            </div>
                            <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                <p class="text-base text-text-primary uppercase font-medium">Height</p>
                                <p class="text-sm font-medium">{{ $container_product?->container->height_cm }} cm</p>
                            </div>
                            <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                <p class="text-base text-text-primary uppercase font-medium">Max Weight</p>
                                <p class="text-sm font-medium">{{ $container_product?->container->max_weight_kg }} kg</p>
                            </div>
                        </div>

                        <div class="pt-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium text-base">Capacity</span>
                                <span>{{ $container_product?->container->capacity_percent }}% filled</span>
                            </div>
                            <div class="w-full bg-bg-gray rounded-full h-2.5">
                                <div class="bg-bg-wiz_orange h-2.5 rounded-full text-base"
                                    style="width: {{ $container_product?->container->capacity_percent }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Details --}}
                <div class="lg:col-span-6">
                    <div
                        class=" bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg h-full">
                        <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                Product Details
                            </h3>
                        </div>

                        <div class="p-5 flex flex-col h-full">
                            <div class="flex flex-col md:flex-row gap-6 flex-grow">
                                {{-- Product Image --}}
                                <div class="w-full md:w-1/3 h-48 md:h-auto overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ $container_product?->product->primaryImage->first()?->image }}"
                                        alt="{{ $container_product?->product->name }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                </div>

                                <div class="w-full md:w-2/3">
                                    <h3 class="text-xl font-bold text-text-primary dark:text-white mb-4">
                                        {{ $container_product?->product->name }}
                                    </h3>

                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-text-primary dark:text-text-light mb-6">
                                        <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                            <p class="text-base text-text-primary uppercase font-medium">Quantity</p>
                                            <p class="text-sm font-medium">{{ $container_product?->product->quantity }}</p>
                                        </div>
                                        <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                            <p class="text-base text-text-primary uppercase font-medium">Price</p>
                                            <p class="text-sm font-medium">${{ $container_product?->product->price }}</p>
                                        </div>
                                        <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                            <p class="text-base text-text-primary uppercase font-medium">Reserve Price</p>
                                            <p class="text-sm font-medium">
                                                ${{ $container_product?->product->reserve_price }}</p>
                                        </div>
                                        <div class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg">
                                            <p class="text-base text-text-primary uppercase font-medium">Status</p>
                                            <p class="text-sm font-medium">
                                                {{ $container_product?->product->status_label ?? 'Available' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
