@extends('frontend.layouts.app', ['page_slug' => 'auctions'])

@section('title', 'Auctions')
@section('content')
    <section class="py-15">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-2xl lg:text-4xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Auctions') }}</h1>
                </div>
            </div>
        </div>
    </section>
    {{-- Mid Content --}}
    @include('frontend.layouts.includes.auction_side_filter')
    <section class="pb-15">
        <div class="container">
            <div class="flex justify-start gap-10">
                <div class="w-1/4 hidden xl:block">
                    {{-- Sidebar Filter --}}
                    <form action="{{ route('frontend.auctions.filter') }}" method="post">
                        @csrf
                        <div
                            class="space-y-6 shadow-card dark:shadow-dark-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
                            <h2
                                class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light dark:bg-bg-light dark:bg-opacity-20 border-border-gray dark:border-opacity-50 p-4">
                                {{ __(' Auction fillters') }}</h2>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Category') }}</h3>
                                <div class="mt-2">
                                    <select class="select" name="category">
                                        <option value="" selected>All Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}"
                                                {{ request()->category == $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'category']" />
                                </div>
                            </div>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                                <div class="mt-2">
                                    <select class="select" name="company">
                                        <option value="" selected>Select Make</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->slug }}"
                                                {{ request()->company == $company->slug ? 'selected' : '' }}>
                                                {{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company']" />
                                </div>
                            </div>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('End Time') }}</h3>
                                <div class="mt-2">
                                    <input type="date" class="input py-0 px-4" name="date"
                                        value="{{ request()->date }}">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'date']" />
                                </div>
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
                    </form>
                </div>
                <div class="w-full xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2 md:gap-3">
                            <button
                                class="openAuctionFilterSidebar btn px-2 py-0 rounded-md bg-transparent border-bg-accent dark:border-bg-light dark:border-opacity-50 text-text-accent text-sm font-medium  xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                                <span><i data-lucide="sliders-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i></span>
                                <span class="">{{ __('Filter') }}</span>
                            </button>
                            <h2 class="text-sm xs:text-base md:text-lg  font-semibold">{{ __('Sort') }}
                                <span>{{ number_format(count($auctions)) }}</span>
                            </h2>
                        </div>
                        <div class="flex items-center">
                            <select
                                class="border border-border-gray dark:border-opacity-20 shadow-card focus:outline-none rounded-md px-2 py-1 text-sm "
                                id="sort-select">
                                <option>{{ __('Price: Low to High') }}</option>
                                <option>{{ __('Price: High to Low') }}</option>
                                <option>{{ __('Newest First') }}</option>
                                <option>{{ __('Oldest First') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-text-dark dark:text-text-light text-opacity-50">Loading products...</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="products-grid">
                        @foreach ($auctions as $auction)
                            <x-frontend.auction-card :auction="$auction" />
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('js')
    </script>
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
@endpush
