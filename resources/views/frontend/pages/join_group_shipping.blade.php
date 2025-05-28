@extends('frontend.layouts.app')

@section('content')

<section class="py-10">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Container Details --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <h2 class="text-2xl font-semibold mb-6 text-text-primary dark:text-white border-b pb-2"> Container Details</h2>
                <div class="space-y-3 text-base text-gray-700 dark:text-gray-300">
                    <p><span class="font-semibold">Title:</span> {{ $container_product?->container->title }}</p>
                    <p><span class="font-semibold">Status:</span> {{ $container_product?->container->status_label }}</p>
                    <p><span class="font-semibold">From:</span> {{ $container_product?->container->shippingPort?->name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Destination:</span> {{ $container_product?->container->destinationPort?->name ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Deadline:</span> {{ dateFormat($container_product?->container->deadline) }}</p>
                    <p><span class="font-semibold">Dimensions:</span> {{ $container_product?->container->length_cm }} x {{ $container_product?->container->width_cm }} x {{ $container_product?->container->height_cm }} cm</p>
                    <p><span class="font-semibold">Max Weight:</span> {{ $container_product?->container->max_weight_kg }} kg</p>
                    <p><span class="font-semibold">Capacity:</span> {{ $container_product?->container->capacity_percent }}% filled</p>
                </div>
            </div>

            {{-- Product Details --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <h2 class="text-2xl font-semibold mb-6 text-text-primary dark:text-white border-b pb-2"> Product Details</h2>
                <div class="flex flex-col sm:flex-row gap-6">
                    {{-- Product Image (optional) --}}
                    
                    <img src="{{ $container_product?->product->primaryImage->first()?->image }}" alt="{{ $container_product?->product->name }}"
                         class="w-full sm:w-40 h-40 object-cover rounded shadow"> 
                    

                    <div class="flex-1 space-y-4 text-base text-gray-700 dark:text-gray-300">
                        <h3 class="text-xl font-bold text-text-primary dark:text-white">{{ $container_product?->product->name }}</h3>
                        <p><span class="font-semibold">Quantity:</span> {{ $container_product?->product->quantity }}</p>
                        <p><span class="font-semibold">Price:</span> ${{ $container_product?->product->price }}</p>
                        <p><span class="font-semibold">Reserve Price:</span> ${{ $container_product?->product->reserve_price }}</p>
                      
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
