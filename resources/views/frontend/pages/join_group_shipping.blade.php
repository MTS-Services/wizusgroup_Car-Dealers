@extends('frontend.layouts.app')

@section('content')
    {{-- details section --}}
    <section class="py-6 sm:py-8 lg:py-12 bg-bg-light dark:bg-bg-dark-tertiary/50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Container Details --}}
                <div
                    class="lg:col-span-6  bg-bg-white dark:bg-bg-dark-tertiary  shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg">
                    <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                {{ $container->title ?? 'Untitled' }}
                            </h3>
                            <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-base font-medium">
                                {{ $container->status_label ?? 'Active' }}
                            </span>
                        </div>
                        <div class="grid
                                grid-cols-2 gap-2 mt-3">
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">From</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container->shippingPort?->name ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    Destination</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container->destinationPort?->name ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 text-sm text-text-primary dark:text-text-light">
                        <div class="flex items-center mb-4">
                            <i class="far fa-calendar-alt text-text-primary dark:text-text-light mr-2 text-sm"></i>
                            <span class="font-medium text-base">Deadline:
                                {{ dateFormat($container->deadline) }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">Length</p>
                                <p class="text-base font-bold">{{ $container->length_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">Width</p>
                                <p class="text-base font-bold">{{ $container->width_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">Height</p>
                                <p class="text-base font-bold">{{ $container->height_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">Max Weight
                                </p>
                                <p class="text-base font-bold">{{ $container->max_weight_kg }} kg</p>
                            </div>
                        </div>

                        <div class="pt-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium text-base">Capacity</span>
                                <span>{{ $container->getFilledPercentageAttribute() }}% filled</span>
                            </div>
                            <div class="w-full bg-bg-gray rounded-full h-2.5">
                                <div class="bg-bg-wiz_orange h-2.5 rounded-full text-base"
                                    style="width: {{ $container->getFilledPercentageAttribute() }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Details --}}
                <div class="lg:col-span-6">
                    <div
                        class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg h-full">
                        <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                Product Details
                            </h3>
                        </div>

                        <div class="p-5">
                            <div class="flex flex-col lg:flex-row gap-6">
                                {{-- Product Image --}}
                                <div class="w-full lg:w-1/2 h-64 lg:h-auto overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ storage_url($container_product->product?->primaryImage->first()?->image) }}"
                                        alt="{{ $container_product->product?->name }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                </div>

                                {{-- Product Details --}}
                                <div class="w-full lg:w-1/2">
                                    <h3 class="text-xl font-bold text-text-primary dark:text-white mb-4">
                                        {{ $container_product?->product->name }}
                                    </h3>

                                    <div class="space-y-4">
                                        {{-- Full width details --}}
                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    Quantity</p>
                                                <p class="text-base font-bold">
                                                    {{ $container_product->quantity }}/{{ $container->containerReservations()->where('product_id', $container_product->product_id)->sum('quantity') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    Price</p>
                                                <p class="text-base font-bold">${{ $container_product->price }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    Reserve Price</p>
                                                <p class="text-base font-bold">
                                                    ${{ $container_product->reserve_price }}</p>
                                            </div>
                                        </div>

                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    Status</p>
                                                <p class="text-base font-bold">
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
        </div>
    </section>

    {{-- Form Section --}}
    <section class="py-6 sm:py-8 lg:py-12">
        <div class="container">
            <div class="bg-bg-white dark:bg-bg-dark-tertiary  overflow-hidden  rounded-lg">
                <form action="" method="post" class="space-y-5 p-5">
                    <div class="grid grid-cols-1 tablet:grid-cols-2 gap-4">
                        <!-- First Input Field -->
                        <div class="form-group">
                            <label for="field1"
                                class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                Field 1
                            </label>
                            <input type="text" id="field1" name="field1"
                                class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light  border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <!-- Second Input Field -->
                        <div class="form-group">
                            <label for="field2"
                                class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                Field 2
                            </label>
                            <input type="text" id="field2" name="field2"
                                class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Textarea -->
                    <div class="form-group">
                        <label for="message"
                            class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                            Message
                        </label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class=" btn-primary !bg-bg-wiz_orange">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
    </section>
@endsection
