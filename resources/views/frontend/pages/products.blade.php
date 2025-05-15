@extends('frontend.layouts.app', ['page_slug' => 'products'])

@section('title', 'Products')
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
                    <h1 class="text-3xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Agricultural Machinery') }}</h1>
                </div>
            </div>
        </div>
    </section>
    {{-- Mid Content --}}
    <section class="py-15">
        <div class="container">
            <div class="flex justify-start gap-10">
                @include('frontend.layouts.includes.product_filter_sidebar')
                <div class="w-1/4 hidden xl:block">
                    {{-- Sidebar Filter --}}
                    <div class="space-y-6 shadow-card rounded-lg p-4 dark:bg-bg-dark-tertiary">
                        <!-- Category Filter -->
                        <div>
                            <div data-target="category-filter">
                                <h3 class="text-xl font-medium">Category</h3>
                            </div>

                            <div class="filter-content" id="category-filter">
                                <div class="mt-2">
                                    <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All Agricultural</option>
                                        <option>Tractors</option>
                                        <option>Harvesters</option>
                                        <option>Plows</option>
                                        <option>Seeders</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div>
                            <div data-target="brand-filter">
                                <h3 class="text-xl font-medium">Brand</h3>
                            </div>

                            <div class="filter-content" id="brand-filter">
                                <div class="mt-2">
                                    <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All</option>
                                        <option>Kubota</option>
                                        <option>Iseki</option>
                                        <option>John Deere</option>
                                        <option>Mitsubishi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Model Filter -->
                        <div>
                            <div data-target="model-filter">
                                <h3 class="text-xl font-medium">Model</h3>
                            </div>

                            <div class="filter-content" id="model-filter">
                                <div class="mt-2">
                                    <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
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

                        <!-- Year Filter -->
                        <div>
                            <div data-target="year-filter">
                                <h3 class="text-xl font-medium">Year</h3>
                            </div>

                            <div class="filter-content" id="year-filter">
                                <div class="mt-2">
                                    <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All</option>
                                        <option>2020 - Present</option>
                                        <option>2010 - 2019</option>
                                        <option>2000 - 2009</option>
                                        <option>1990 - 1999</option>
                                        <option>Before 1990</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div>
                            <div data-target="price-filter">
                                <h3 class="text-xl font-medium">Price</h3>
                            </div>

                            <div class="filter-content" id="price-filter">
                                <div class="mt-2">
                                    <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                                        <option>All</option>
                                        <option>Under $5,000</option>
                                        <option>$5,000 - $10,000</option>
                                        <option>$10,000 - $20,000</option>
                                        <option>$20,000 - $50,000</option>
                                        <option>Over $50,000</option>
                                    </select>
                                </div>
                            </div>
                        </div>

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
                <div class="w-full xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2 md:gap-3">
                            <button
                                class="openFilterSidebar btn px-2 py-0 rounded-md bg-transparent border border-bg-accent text-text-accent text-xs font-medium xs:text-sm xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                                <span><i data-lucide="sliders-horizontal" class="w-5 h-5"></i></span>
                                <span class="ml-2 text-base">{{ __('Filter') }}</span>
                            </button>
                            <h2 class="text-sm xs:text-base md:text-lg  font-semibold">Sort <span>38,001</span></h2>
                        </div>
                        <div class="flex items-center">
                            <select class="border shadow-card focus:outline-none rounded-md px-2 py-1 text-sm "
                                id="sort-select">
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Newest First</option>
                                <option>Oldest First</option>
                            </select>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-gray-600">Loading products...</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="products-grid">
                        {{-- Product 1 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="1">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 2 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="2">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 3 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="2">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 4 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="4">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 5 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="5">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 6 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="6">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 7 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="7">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 8 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="8">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
                            </div>
                        </div>
                        {{-- Product 9 --}}
                        <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                            data-product="9">
                            <div class="max-h-80 w-full  overflow-hidden">
                                {{-- transition: transform 0.7s ease; --}}
                                <img src="{{ asset('frontend/images/products/tractor-2.avif') }}" alt="Kubota ZL1-215"
                                    class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                            </div>
                            <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                <h3
                                    class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                    Kubota ZL1-215</h3>
                                <p class="text-xl font-bold text-text-danger">$3,500</p>
                                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                    <span>2001</span>
                                    <span class="mx-2">|</span>
                                    <span>Osaka</span>
                                </div>
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
