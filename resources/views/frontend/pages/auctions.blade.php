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
                    <div
                        class="space-y-6 shadow-card dark:shadow-dark-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
                        <h2
                            class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light dark:bg-bg-light dark:bg-opacity-20 border-border-gray dark:border-opacity-50 p-4">
                            {{ __(' Auction fillters') }}</h2>
                        <div class="px-4">
                            <h3 class="text-sm md:text-base font-medium">{{ __('Category') }}</h3>
                            <div class="mt-2">
                                <select class="select">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="px-4">
                            <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                            <div class="mt-2">
                                <select class="select">
                                    <option value="" selected disabled>Select Make</option>
                                    @foreach ($companies as $make)
                                        <option value="{{ $make->slug }}">{{ $make->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="px-4">
                            <h3 class="text-sm md:text-base font-medium">{{ __('End Time') }}</h3>
                            <div class="mt-2">
                                <input type="date" name="date" hidden id="date">

                                <button popovertarget="cally-popover1" class="input input-border" id="cally1"
                                    style="anchor-name:--cally1">
                                    {{ __('Pick a date') }}
                                </button>

                                <div popover id="cally-popover1" class="dropdown bg-base-100 rounded-box shadow-lg"
                                    style="position-anchor:--cally1">
                                    <calendar-date class="cally" id="calendar"
                                        onchange="
        document.getElementById('cally1').innerText = this.value;
        document.getElementById('date').value = this.value;
    ">
                                        <svg aria-label="Previous" class="fill-current size-4" slot="previous"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M15.75 19.5 8.25 12l7.5-7.5"></path>
                                        </svg>
                                        <svg aria-label="Next" class="fill-current size-4" slot="next"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                                        </svg>
                                        <calendar-month></calendar-month>
                                    </calendar-date>
                                </div>

                                <script type="module" src="https://unpkg.com/cally"></script>
                                <script type="module">
                                    import "cally";
                                </script>
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
                </div>
                <div class="w-full xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex items-center gap-2 md:gap-3 mb-4">
                        <button
                            class="openAuctionFilterSidebar btn px-2 py-0 rounded-md bg-transparent border-bg-accent dark:border-bg-light dark:border-opacity-50 text-text-accent text-sm font-medium  xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
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
                        @foreach ($auctions as $auction)
                            <x-frontend.auction-card :auction="$auction" />
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('js')
    <script type="module" src="https://unpkg.com/cally"></script>
    <script type="module">
        import "cally";
    </script>

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
