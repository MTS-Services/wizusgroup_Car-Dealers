@extends('frontend.layouts.app', ['page_slug' => 'auctions'])
@section('title', 'Auctions')
@section('content')
    <section class="py-15">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-2xl lg:text-4xl font-semibold text-text-primary dark:text-text-light text-center">
                        {{ __('Auctions') }}</h2>
                </div>
            </div>
        </div>
    </section>
    {{-- Mid Content --}}
    <section class="pb-15">
        <div class="container">
            <div class="flex justify-start gap-10 overflow-hidden 2xl:overflow-visible p-1">

                <div
                    class="w-full filter-sidebar fixed 2xl:sticky 2xl:w-1/4 top-0 2xl:top-24 left-0 h-screen 2xl:h-screen max-h-screen 2xl:max-h-fit bg-bg-black/50 2xl:bg-transparent z-[99999] 2xl:z-0 -translate-x-full 2xl:translate-x-0 transition-all duration-300 ease-in-out overflow-y-auto px-2 2xl:p-0 py-5">
                    <form action="{{ route('frontend.auctions.filter') }}" method="post"
                        class="w-5/6 sm:w-4/6 md:w-3/6 lg:w-2/5 2xl:w-full h-full 2xl:h-fit flex flex-col gap-2">
                        @csrf
                        <div class="bg-bg-light dark:bg-bg-dark-tertiary rounded-lg p-4 flex justify-between items-center">
                            <h3 class="text-lg md:text-xl font-semibold  capitalize">
                                {{ __(' Auction fillters') }}</h3>
                            <button type="button" class="closeFilterSidebar btn btn-sm btn-circle btn-ghost 2xl:hidden"><i
                                    data-lucide="x" class="w-5 h-5"></i></button>
                        </div>
                        <div
                            class="space-y-3 shadow-card dark:shadow-dark-card rounded-lg bg-bg-secondary dark:bg-bg-dark-tertiary overflow-hidden h-full py-3">

                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Category') }}</h3>

                                <select class="select select2 mt-2" name="category">
                                    <option value="" selected>All Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}"
                                            {{ request()->category == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'category']" />

                            </div>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                                <select class="select select2 mt-2" name="company">
                                    <option value="" selected>Select Make</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->slug }}"
                                            {{ request()->company == $company->slug ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company']" />
                            </div>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('End Time') }}</h3>
                                <input type="date" class="input py-0 px-4 mt-2" name="date"
                                    value="{{ request()->date }}">
                                <span class="date-error text-xs text-red-500"></span>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'date']" />
                            </div>
                            <div class="px-4">
                                <button id="filterBtn" class="w-full btn-primary group">
                                    <span>{{ __('Filter') }}</span>
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

                <div class="w-full 2xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2 md:gap-3">
                            <button
                                class="btn openFilterSidebar px-2 py-0 rounded-md bg-transparent border-bg-accent dark:border-bg-light dark:border-opacity-50 text-text-accent text-sm font-medium  xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap 2xl:hidden">
                                <span><i data-lucide="sliders-horizontal" class="w-4 h-4 md:w-5 md:h-5"></i></span>
                                <span class="">{{ __('Filter') }}</span>
                            </button>
                            <h2 class="text-sm xs:text-base md:text-lg  font-semibold">{{ __('Sort') }}
                                <span>{{ number_format(count($auctions)) }}</span>
                            </h2>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('frontend.auctions.filter') }}" method="POST" id="filter_form">
                                @csrf
                                <select name="sort" id="sort-select" class="select select2">
                                    <option value="" {{ request()->sort == '' ? 'selected' : '' }}>Default</option>
                                    <option value="low_to_high" {{ request()->sort == 'low_to_high' ? 'selected' : '' }}>
                                        {{ __('Price: High to Low') }}</option>
                                    <option value="high_to_low" {{ request()->sort == 'high_to_low' ? 'selected' : '' }}>
                                        {{ __('Price: Low to High') }}</option>
                                    <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>
                                        {{ __('Newest First') }}</option>
                                    <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>
                                        {{ __('Oldest First') }}</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading-indicator" class="flex justify-center items-center py-12">
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
    {{-- Filter By Order  --}}
    <script>
        $(document).ready(function() {
            $("#sort-select").on("change", function() {
                $("#filter_form").submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            const $openFilterSidebar = $('.openFilterSidebar');
            const $filterSidebar = $('.filter-sidebar');
            const $closeFilterSidebar = $('.closeFilterSidebar');

            $openFilterSidebar.on('click', function() {
                $filterSidebar.css('transform', 'translateX(0)');
            });

            $closeFilterSidebar.on('click', function() {
                $filterSidebar.css('transform', 'translateX(-100%)');
            });
        })
    </script>


    {{-- Date Validation --}}
    <script>
        $(document).ready(function() {
            const $dateInput = $('input[name="date"]');
            const $errorSpan = $('.date-error');
            const $submitBtn = $('#filterBtn');

            $dateInput.on('change', function() {
                const selectedDate = new Date($dateInput.val());
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Remove time for accurate comparison

                if (selectedDate < today) {
                    $errorSpan.text('Oops! You can\'t pick a past date.');
                    $dateInput.addClass(
                        'border-red-500 focus:focus:border-red-500 focus-within:border-red-500');
                    $submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
                } else {
                    $errorSpan.text('');
                    $dateInput.removeClass(
                        'border-red-500 focus:focus:border-red-500 focus-within:border-red-500');
                    $submitBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
                }
            });
        });
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
