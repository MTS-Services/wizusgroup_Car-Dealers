@extends('frontend.layouts.app', ['page_slug' => 'parts-accessories'])

@section('title', 'Parts & Accessories')
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
                    <h1 class="text-2xl lg:text-4xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Parts & Accessories') }}</h1>
                </div>
            </div>
        </div>
    </section>
    {{-- Mid Content --}}
    @include('frontend.layouts.includes.parts_filter_sidebar')
    <section class="pb-15">
        <div class="container">
            <div class="flex justify-start gap-10">
                <div class="w-1/4 hidden xl:block">
                    {{-- Sidebar Filter --}}
                    <div
                        class="space-y-6 shadow-card dark:shadow-dark-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
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
                        <div>
                            {{-- Price Filter --}}
                            <details class="collapse collapse-arrow" open>
                                <summary class="collapse-title text-base font-medium">{{ __('Price') }}</summary>
                                <div class="collapse-content">
                                    <div class="mb-3">
                                        <div class="relative w-full price-slider">
                                            <div class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full">
                                            </div>
                                            <div class="absolute h-1 z-[2] rounded-full bg-bg-primary slider-range"></div>
                                            <input type="range" min="0" max="500" value="20"
                                                class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                                            <input type="range" min="0" max="500" value="300"
                                                class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                                        </div>
                                    </div>
                                    <!-- Price display -->
                                    <div class="pt-8">
                                        <p class="text-sm lg:text-base">
                                            {{ __('Price:') }} <span
                                                class="text-text-danger min-price">{{ __("$20") }}</span> -
                                            <span class="text-text-danger max-price">{{ __("$300") }}</span>
                                        </p>
                                    </div>
                                </div>
                            </details>
                        </div>
                        <div class="px-4 pb-4">
                            <button
                                class="w-full btn-primary hover:bg-bg-tertiary py-2 rounded-md transition-all duration-300 flex items-center justify-center group">
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
                            class="openPartsFilterSidebar btn px-2 py-0 rounded-md bg-transparent border-bg-accent dark:border-bg-light dark:border-opacity-50 text-text-accent text-sm font-medium  xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                            <span><i data-lucide="sliders-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i></span>
                            <span class="">{{ __('Filter') }}</span>
                        </button>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-text-dark dark:text-text-light text-opacity-50">Loading products...</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="products-grid">
                        {{-- Product 1 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="1">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts-1.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Fuel filter or fuel water separator') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 4,800") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
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
                                    class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 2 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="2">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts-2.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Timing belt or engine drive system ') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 4,200") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
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
                                    class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 3 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="3">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts-3.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Tractor or heavy vehicle engine assembly') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 4,500") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
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
                                    class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 4 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full h-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="4">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts-4.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Pistons and connecting rods') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 3,500") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Chiba') }}
                                </div>

                                <div class="mt-auto">
                                    <!-- Bid Button -->
                                    <button onclick="openModal()"
                                        class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
                                        {{ __('Place Bid') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- Product 5 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group  shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="5">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts5.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Fuel injection system or hydraulic control system') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 4,400") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
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
                                    class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
                                    {{ __('Place Bid') }}
                                </button>
                            </div>
                        </div>
                        {{-- Product 6 --}}
                        <div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer flex flex-col"
                            data-product="6">
                            <!-- Car Image -->
                            <div class="relative">
                                <div class="w-full min-h-60 overflow-hidden">
                                    <img src="{{ asset('frontend/images/parts/parts-6.jpg') }}" alt="Kubota ZL1-215"
                                        class="w-full min-h-60 h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <!-- Timer Badge -->
                                <div
                                    class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium">
                                    {{ __('2d 04h 15m') }}
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-grow p-4">
                                <h2 class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Sales or negotiation scene') }}</h2>
                                <p class="text-text-danger text-base lg:text-md font-bold mt-1">{{ __("US$ 4,100") }}</p>
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
                                    class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm mb-4">
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
                                    class="mt-auto w-full btn-primary hover:bg-bg-tertiary rounded-md py-2 px-4">
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
                    <h2 class="text-xl font-semibold">{{ __('Place Your Bid') }}</h2>
                    <button onclick="closeModal()"
                        class="text-text-primary hover:text-text-tertiary text-2xl">&times;</button>
                </div>

                <div class="space-y-4">

                    <div>
                        <label for="bidAmount"
                            class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __('Your Bid (USD)') }}</label>
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
            const $openSidebar = $('.openPartsFilterSidebar');
            const $closeSidebar = $('.closePartsFilterSidebar');
            const $sidebar = $('.partsFilterSidebar'); // Select the sidebar element globally

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
    </script>
    {{-- Price Range Slide --}}
    <script>
        $('.price-slider').each(function() {
            const $slider = $(this);
            const $minRange = $slider.find('.min-range');
            const $maxRange = $slider.find('.max-range');
            const $sliderRange = $slider.find('.slider-range');
            const $minPrice = $slider.closest('.collapse-content').find('.min-price');
            const $maxPrice = $slider.closest('.collapse-content').find('.max-price');

            function updatePriceSlider() {
                const minVal = parseInt($minRange.val());
                const maxVal = parseInt($maxRange.val());
                const maxAttr = parseInt($minRange.attr('max'));
                const minPercent = (minVal / maxAttr) * 100;
                const maxPercent = (maxVal / maxAttr) * 100;

                $sliderRange.css({
                    left: minPercent + '%',
                    width: (maxPercent - minPercent) + '%'
                });

                $minPrice.text('$' + minVal);
                $maxPrice.text('$' + maxVal);
            }

            // Initial setup
            updatePriceSlider();

            // Update on input
            $minRange.on('input', function() {
                if (parseInt($minRange.val()) > parseInt($maxRange.val()) - 10) {
                    $minRange.val(parseInt($maxRange.val()) - 10);
                }
                updatePriceSlider();
            });

            $maxRange.on('input', function() {
                if (parseInt($maxRange.val()) < parseInt($minRange.val()) + 10) {
                    $maxRange.val(parseInt($minRange.val()) + 10);
                }
                updatePriceSlider();
            });
        });
    </script>
@endpush
