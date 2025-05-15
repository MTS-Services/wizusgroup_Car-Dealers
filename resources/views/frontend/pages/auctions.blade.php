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

        /* Loading Spinner */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top-color: #3B82F6;
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
    <section class="py-15">
        <div class="container">
            <div class="flex justify-start gap-10">
                {{-- @include('frontend.layouts.includes.auction_side_filter') --}}
                <div class="w-1/4 hidden xl:block">
                    {{-- Sidebar Filter --}}
                    <div class="space-y-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary">
                        <h2
                            class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light border-border-gray dark:border-opacity-50 p-4">
                            Auction fillters</h2>
                        <div class="px-4">
                            <div data-target="category-filter">
                                <h3 class="text-sm md:text-base font-medium">Category</h3>
                            </div>

                            <div class="filter-content" id="category-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All Agricultural</option>
                                        <option>Tractors</option>
                                        <option>Harvesters</option>
                                        <option>Plows</option>
                                        <option>Seeders</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4">
                            <div data-target="brand-filter">
                                <h3 class="text-sm md:text-base font-medium">Make</h3>
                            </div>

                            <div class="filter-content" id="brand-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All</option>
                                        <option>Kubota</option>
                                        <option>Iseki</option>
                                        <option>John Deere</option>
                                        <option>Mitsubishi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4">
                            <div data-target="model-filter">
                                <h3 class="text-sm md:text-base font-medium">End Time</h3>
                            </div>

                            <div class="filter-content" id="model-filter">
                                <div class="mt-2">
                                    <select
                                        class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All</option>
                                        <option>ZL1-215</option>
                                        <option>TM15</option>
                                        <option>GL-29</option>
                                        <option>1070</option>
                                        <option>MT200</option>
                                        <option>TU1500F</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <button
                                class="w-full bg-bg-primary text-white py-2 rounded-md transition-colors duration-200 flex items-center justify-center group">
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
                            class="openFilterSidebar btn px-2 py-0 rounded-md bg-transparent border border-bg-accent text-text-accent text-xs font-medium xs:text-sm xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                            <span><i data-lucide="sliders-horizontal" class="w-5 h-5"></i></span>
                            <span class="ml-2 text-base">{{ __('Filter') }}</span>
                        </button>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-gray-600">Loading products...</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="products-grid">
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                        {{-- Product 1 --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-md w-full">
                            <!-- Car Image -->
                            <div class="relative">
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                <!-- Timer Badge -->
                                <div
                                    class="absolute bottom-[-10px] left-3 bg-orange-500 text-white px-3 py-1 rounded-md text-sm font-medium">
                                    2d 04h 15m
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">Honda CR-V</h2>
                                <p class="text-red-600 font-bold text-lg mt-1">US$ 4,500</p>
                                <div class="flex items-center mt-3 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    All Categories
                                </div>
                                <div class="flex items-center mt-2 text-gray-600 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Chiba
                                </div>

                                <!-- Bid Button -->
                                <button
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded mt-4 transition duration-300">
                                    Place Bid
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            const $openSidebar = $('.openFilterSidebar');
            const $closeSidebar = $('.closeFilterSidebar');
            const $sidebar = $('.filterSidebar'); // Select the sidebar element globally

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

        // Sort functionality
        document.getElementById('sort-select').addEventListener('change', function() {
            simulateLoading();
        });
    </script>
@endpush
