@extends('frontend.layouts.app', ['page_slug' => 'my-container'])
@section('title', 'My Container')

@section('content')
    <section class="py-10">
        <div class="container">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-xl md:text-2xl font-semibold mb-0 ps-2">{{ __('My Container Details') }}</h4>
                <a href="{{ route('user.profile') }}" class="btn-primary py-2  bg-bg-primary rounded-md hover:bg-bg-tertiary">
                    {{ __('Back') }}
                </a>
            </div>
            <div
                class="{{ isset($container) ? 'col-span-9' : 'col-span-12' }} bg-white dark:bg-bg-dark-tertiary shadow-md dark:shadow-lg overflow-hidden border border-gray-200 dark:border-border-dark-secondary rounded-lg">
                <!-- Header -->
                <div class="p-5 border-b border-gray-200 dark:border-border-dark-secondary">
                    <div class="flex justify-between items-baseline flex-wrap gap-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                            {{ $container->container?->title ?? __('Untitled') }}
                        </h3>
                        <div>
                            <p class="text-base uppercase font-medium text-text-primary dark:text-text-light">
                                {{ __('From') }}
                            </p>
                            <p class="text-sm text-text-primary dark:text-text-light">
                                {{ $container->container?->shippingPort?->name ?? __('N/A') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-base uppercase font-medium text-text-primary dark:text-text-light">
                                {{ __('Destination') }}
                            </p>
                            <p class="text-sm text-text-primary dark:text-text-light">
                                {{ $container->container?->destinationPort?->name ?? __('N/A') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 bg-green-600 text-white rounded-full text-sm font-medium">
                            {{ $container->status_label ?? __('Active') }}
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
                            <img src="{{ storage_url($container->container?->image) }}" alt="{{ $container->container?->title ?? 'Untitled' }}"
                                class="w-full max-h-80 h-full object-cover rounded-md">
                        </div>

                        <!-- Specs -->
                        <div class="col-span-3">
                            <div class="grid grid-cols-2 gap-4">
                                @php
                                    $specs = [
                                        __('Length') => "{$container->length_m} cm",
                                        __('Width') => "{$container->width_m} cm",
                                        __('Height') => "{$container->height_m} cm",
                                        __('Max Weight') => "{$container->container?->max_weight_kg} kg",
                                        __('Base Cost') => '$' . number_format($container->container?->base_cost, 2),
                                        __('Per Kilogram Cost') => '$' . number_format($container->container?->per_kg_cost, 2),
                                        __('Per Cubic Meter Cost') => '$' . number_format($container->container?->per_cbm_cost, 2),
                                    ];
                                @endphp

                                @foreach ($specs as $label => $value)
                                    <div
                                        class="bg-gray-100 dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center">
                                        <p class="text-base uppercase font-medium">{{ $label }}</p>
                                        <p class="text-base font-bold">{{ $value }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Capacity Bar -->
                            <div class="pt-4">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium text-base">{{ __('Capacity') }}</span>
                                    <span>{{ $container->container?->getFilledPercentageAttribute() }}%
                                        {{ __('filled') }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full"
                                        style="width: {{ $container->container?->getFilledPercentageAttribute() }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
