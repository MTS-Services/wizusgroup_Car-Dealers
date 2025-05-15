@extends('frontend.layouts.app', ['page_slug' => 'auctions'])

@section('title', 'Auctions')
@push('css')
    <style>
        /* General Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideInUp 0.5s ease-out forwards;
        }

        .animate-pulse {
            animation: pulse 1.5s infinite;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
@endpush

@section('content')
    <section class="py-15">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-3xl lg:text-4xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Auctions') }}</h1>
                </div>
            </div>
        </div>
    </section>
    {{-- Mid Content --}}
    @include('frontend.layouts.includes.auction_side_filter')
    <section class="py-15">
        <div class="container">
            <div class="flex justify-start gap-10">
                <div class="w-1/4 hidden xl:block">
                    {{-- Sidebar Filter --}}
                    <div class="space-y-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
                        <h2
                            class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light dark:bg-bg-light dark:bg-opacity-20 border-border-gray dark:border-opacity-50 p-4">
                            {{ __(' Auction fillters') }}</h2>
                        <div class="px-4">
                            <div data-target="category-filter">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Category') }}</h3>
                            </div>

                            <div class="filter-content" id="category-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>{{ __('All Agricultural') }}</option>
                                        <option>{{ __('Tractors') }}</option>
                                        <option>{{ __('Harvesters') }}</option>
                                        <option>{{ __('Plows') }}</option>
                                        <option>{{ __('Seeders') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4">
                            <div data-target="brand-filter">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                            </div>

                            <div class="filter-content" id="brand-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>{{ __('All') }}</option>
                                        <option>{{ __('Kubota') }}</option>
                                        <option>{{ __('Iseki') }}</option>
                                        <option>{{ __('John Deere') }}</option>
                                        <option>{{ __('Mitsubishi') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4">
                            <div data-target="model-filter">
                                <h3 class="text-sm md:text-base font-medium">{{ __('End Time') }}</h3>
                            </div>

                            <div class="filter-content" id="model-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>{{ __('All') }}</option>
                                        <option>{{ __('ZL1-215') }}</option>
                                        <option>{{ __('TM15') }}</option>
                                        <option>{{ __('GL-29') }}</option>
                                        <option>{{ __('1070') }}</option>
                                        <option>{{ __('MT200') }}</option>
                                        <option>{{ __('TU1500F') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <button
                                class="w-full bg-bg-primary hover:bg-bg-tertiary text-white py-2 rounded-md transition-colors duration-200 flex items-center justify-center group">
                                <span>Sherch</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex items-center gap-2 md:gap-3 mb-4">
                        <button
                            class="openAuctionFilterSidebar btn px-2 py-0 rounded-md bg-transparent border border-bg-accent text-text-accent text-xs font-medium xs:text-sm xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                            <span><i data-lucide="sliders-horizontal" class="w-5 h-5"></i></span>
                            <span class="ml-2 text-base">{{ __('Filter') }}</span>
                        </button>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-text-dark dark:text-text-light text-opacity-50">Loading products...</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="products-grid">
                        {{-- Product 1 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="1">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 2 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="2">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 3 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="3">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 4 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="4">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 5 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="5">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 6 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  max-w-md w-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="6">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}"
                                        alt="Kubota ZL1-215"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Honda CR-V') }}</h2>
                                <p class="text-text-danger font-bold text-lg mt-1">{{ __("US$ 4,500") }}</p>
                                <div
                                    class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    {{ __('All Categories') }}
                                </div>
                                <div
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <!-- Bid Button -->
                                <button onclick="openModal()"
                                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    {{-- Modal --}}
    <section>
        <!-- Modal Background -->
        <div id="bidModal"
            class="fixed inset-0 bg-bg-dark bg-opacity-50 flex items-center justify-center hidden z-50 opacity-0 transition-all duration-300">
            <!-- Modal Box -->
            <div class="bg-bg-light dark:bg-bg-dark-tertiary p-6 rounded-lg w-full max-w-sm shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">{{ __("Place Your Bid") }}</h2>
                    <button onclick="closeModal()" class="text-text-primary hover:text-text-tertiary text-2xl">&times;</button>
                </div>

                <div class="space-y-4">

                    <div>
                        <label for="bidAmount" class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __("Your Bid (USD)") }}</label>
                        <input type="number" id="bidAmount"
                            class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bg-primary"
                            placeholder="Enter your bid" />
                    </div>

                    <button onclick="submitBid()"
                        class="w-full bg-bg-primary text-text-white py-2 rounded-md hover:bg-bg-tertiary transition">
                        Submit Bid
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            const $openSidebar = $('.openAuctionFilterSidebar');
            const $closeSidebar = $('.closeAuctionFilterSidebar');
            const $sidebar = $('.auctionfilterSidebar'); // Select the sidebar element globally

            // Sidebar open functionality
            $openSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
                // $(this).addClass('hidden'); // Hide the open button
            });

            $closeSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(-100%)'); // Hide the sidebar
                setTimeout(() => {
                    // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
                }, 300); // Delay for the sidebar transition
            });
        });
        // Product card click functionality
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function() {
                const productId = this.getAttribute('data-product');
            });
        });

        // Animate product cards on page load
        function animateProductCards() {
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });
        }

        // Simulate loading
        function simulateLoading() {
            const loadingIndicator = document.getElementById('loading-indicator');
            const productsGrid = document.getElementById('products-grid');

            loadingIndicator.classList.remove('hidden');
            productsGrid.style.opacity = '0';

            setTimeout(() => {
                loadingIndicator.classList.add('hidden');
                productsGrid.style.opacity = '1';
                animateProductCards();
            }, 800);
        }

        // Initialize animations
        window.addEventListener('load', function() {
            simulateLoading();

            // Add hover effect to nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.querySelector('span').style.width = '100%';
                });

                link.addEventListener('mouseleave', function() {
                    this.querySelector('span').style.width = '0';
                });
            });
        });
    </script>
    <script>
        const bidModal = document.getElementById('bidModal');

        function openModal() {
            bidModal.classList.remove('hidden');
            setTimeout(() => {
                bidModal.classList.add('opacity-100');
            }, 10);
        }

        function closeModal() {
            bidModal.classList.add('hidden');
            bidModal.classList.remove('opacity-100');

            setTimeout(() => {
                bidModal.classList.add('hidden');
            }, 300);

        }

        function submitBid() {
            const bid = document.getElementById('bidAmount').value;
            if (bid && bid > 0) {
                alert('Your bid of $' + bid + ' has been submitted!');
                closeModal();
            } else {
                alert('Please enter a valid bid amount.');
            }
        }

        // const modal = document.getElementById('product-modal');
        // const closeModal = document.getElementById('close-modal');

        // function openModal(productId) {
        //     const product = products.find(p => p.id === parseInt(productId));

        //     if (product) {
        //         document.getElementById('modal-title').textContent = product.name;
        //         document.getElementById('modal-price').textContent = `$${product.price.toLocaleString()}`;
        //         document.getElementById('modal-year').textContent = product.year;
        //         document.getElementById('modal-location').textContent = product.location;
        //         document.getElementById('modal-hours').textContent = product.hours || 'N/A';
        //         document.getElementById('modal-condition').textContent = product.condition || 'Used';
        //         document.getElementById('modal-description').textContent = product.description;
        //         document.getElementById('modal-horsepower').textContent = product.horsepower || '15-25 HP';
        //         document.getElementById('modal-main-image').src = product.image;
        //         document.getElementById('modal-main-image').alt = product.name;

        //         // Set gallery images
        //         if (product.gallery && product.gallery.length > 0) {
        //             const galleryThumbs = document.querySelector('.gallery-thumbs');
        //             galleryThumbs.innerHTML = '';

        //             product.gallery.forEach((img, index) => {
        //                 const thumb = document.createElement('img');
        //                 thumb.src = img;
        //                 thumb.alt = `${product.name} view ${index + 1}`;
        //                 thumb.className =
        //                     `h-16 w-full object-cover rounded border-2 ${index === 0 ? 'border-blue-500' : 'border-transparent'} cursor-pointer`;
        //                 if (index === 0) thumb.classList.add('active');

        //                 thumb.addEventListener('click', function() {
        //                     document.getElementById('modal-main-image').src = img;
        //                     document.querySelectorAll('.gallery-thumbs img').forEach(t => t.classList
        //                         .remove('active', 'border-blue-500'));
        //                     this.classList.add('active', 'border-blue-500');
        //                 });

        //                 galleryThumbs.appendChild(thumb);
        //             });
        //         }
        //     }

        //     modal.classList.remove('hidden');
        //     setTimeout(() => {
        //         modal.classList.add('opacity-100');
        //     }, 10);

        //     document.body.style.overflow = 'hidden';
        // }

        // function closeModalFunc() {
        //     modal.classList.remove('opacity-100');

        //     setTimeout(() => {
        //         modal.classList.add('hidden');
        //         document.body.style.overflow = '';
        //     }, 300);
        // }
    </script>
@endpush
