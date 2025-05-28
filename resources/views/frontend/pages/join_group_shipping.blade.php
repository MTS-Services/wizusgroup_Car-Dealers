@extends('frontend.layouts.app', ['page_slug' => 'join_group_shipping'])

@section('title', 'Join Group Shipping')

@section('content')
<section class="py-6 sm:py-8 lg:py-20">
    <div class="container mx-auto">
        <div class="max-w-4xl mx-auto bg-bg-light dark:bg-bg-dark-secondary p-6 rounded shadow-md dark:shadow-dark-card">
            <!-- Header -->
            <div class="mb-6 border-b pb-4 border-border-gray dark:border-border-dark-secondary">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-text-primary dark:text-text-light">
                        {{ $container->title ?? 'Untitled Container' }}
                    </h2>
                    <span class="px-3 py-1 bg-bg-wiz_green text-white text-xs rounded-full font-medium">
                        {{ $container->status_label ?? 'Active' }}
                    </span>
                </div>
                <p class="text-sm mt-2 text-text-gray">
                    Destination Port: {{ $container->destinationPort?->name ?? 'N/A' }}
                </p>
                <p class="text-sm text-text-gray">Deadline: {{ $container->deadline }}</p>
            </div>

            <!-- Container Specifications -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                <div><strong>Length:</strong> {{ $container->length_cm }} cm</div>
                <div><strong>Width:</strong> {{ $container->width_cm }} cm</div>
                <div><strong>Height:</strong> {{ $container->height_cm }} cm</div>
                <div><strong>Max Weight:</strong> {{ $container->max_weight_kg }} kg</div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6">
                <div class="flex justify-between items-center text-sm mb-1">
                    <span class="font-medium">Container Fill Level</span>
                    <span>{{ $container->capacity_percent }}%</span>
                </div>
                <div class="w-full bg-bg-gray rounded-full h-2">
                    <div class="bg-bg-wiz_orange h-2 rounded-full" style="width: {{ $container->capacity_percent }}%"></div>
                </div>
            </div>

            <!-- Item List (Optional) -->
            @if(isset($container->items) && count($container->items))
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4 text-text-primary dark:text-text-light">Your Items</h3>
                    <ul class="space-y-2">
                        @foreach($container->items as $item)
                            <li class="p-4 bg-bg-white dark:bg-bg-dark rounded shadow-sm border border-border-gray dark:border-border-dark-secondary">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">{{ $item->name }}</span>
                                    <span class="text-sm text-text-gray">{{ $item->weight_kg }} kg</span>
                                </div>
                                <p class="text-sm text-text-gray mt-1">Dimensions: {{ $item->length_cm }}×{{ $item->width_cm }}×{{ $item->height_cm }} cm</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

             <!-- Back Button -->
            <div class="mt-10">
                <a href="{{ route('frontend.group_shipping') }}"
                   class="text-bg-wiz_orange hover:text-bg-wiz_orange/80 text-sm font-medium flex items-center">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Containers
                </a>
            </div> 
        </div>
    </div>
</section>
@endsection

