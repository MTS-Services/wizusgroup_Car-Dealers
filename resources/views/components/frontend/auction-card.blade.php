@props(['auction'])

{{-- {{$auction->product->subCategory->name}}
@dd($auction->product->subCategory->name) --}}

<div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden"
    data-product="1">
    <!-- Car Image -->
    <div class="relative">
        <a href="{{ route('frontend.auction-details', $auction->slug) }}" class="w-full block h-56 overflow-hidden">
            <img src="{{ storage_url($auction->product?->primaryImage->first()?->image) }}"
                alt="{{ $auction->product?->primaryImage->first()?->alt ?? ($auction->product?->name ?? $auction->title) }}"
                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">
        </a>
        <!-- Timer Badge -->
        <div class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium"
            id="timer-{{ $auction->id }}" data-endDate="{{ $auction->end_date }}">
            {{ __('2d 04h 15m') }}
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-4 relative h-full">
        <a href="{{ route('frontend.auction-details', $auction->slug) }}"
            class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
            {{ $auction->title }}</a>
        <p class="text-text-danger text-base lg:text-lg font-bold mt-1">{{ __("$") }} {{ $auction->start_price }}
        </p>
        <div class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            {{ $auction->product?->subCategory?->name ?? __('No Category') }}
        </div>
        <div class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg> --}}
            <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
            {{ $auction->location }}
        </div>

        <!-- Bid Button -->
        <button onclick="openModal()" class="w-full btn-primary hover:bg-bg-tertiary px-4 rounded-md mt-4">
            {{ __('Place Bid') }}
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expireDate = $('#timer-{{ $auction->id }}');
        const endDate = moment(expireDate.data(
        'enddate')); // 'data-enddate' auto converts to camelCase in jQuery `.data()`

        // Display time remaining from now
        expireDate.html(endDate.fromNow());

    })
</script>
