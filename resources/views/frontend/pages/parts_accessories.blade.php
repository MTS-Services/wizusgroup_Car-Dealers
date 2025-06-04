@extends('frontend.layouts.app', ['page_slug' => 'parts-accessories'])

@section('title', 'Parts & Accessories')
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

    {{-- <div class="w-1/4 hidden xl:block">

        <div class="space-y-6 shadow-card dark:shadow-dark-card rounded-lg dark:bg-bg-dark-tertiary overflow-hidden mt-3">
            <h2
                class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light dark:bg-bg-light dark:bg-opacity-20 border-border-gray dark:border-opacity-50 p-4">
                {{ __(' Auction fillters') }}</h2>
            <div class="p-4 pb-0">
                <div data-target="category-filter">
                    <h3 class="text-xl font-medium">{{ __('Category') }}</h3>
                </div>

                <div class="filter-content" id="category-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-20 rounded-md px-3 py-2"
                            name="subcategory" id="subcategory">
                            <option value="">{{ __('All Agricultural') }}</option>
                            @foreach ($categories as $children)
                                <option value="{{ $children->slug }}"
                                    {{ request()->category == $children->slug ? 'selected' : '' }}>
                                    {{ $children->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                <select class="select mt-2" name="company">
                    <option value="" selected>Select Make</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->slug }}" {{ request()->company == $company->slug ? 'selected' : '' }}>
                            {{ $company->name }}</option>
                    @endforeach
                </select>
                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company']" />
            </div>
            <div>

                <details class="collapse collapse-arrow" open>
                    <summary class="collapse-title text-xl font-medium">{{ __('Price') }}</summary>
                    <div class="collapse-content">
                        <div class="mb-3">
                            <div class="relative w-full price-slider">
                                <div class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full">
                                </div>
                                <div class="absolute h-1 z-[2] rounded-full bg-bg-primary slider-range"></div>
                                <input type="range" name="start_price" min="0" max="500000"
                                    value="{{ request()->start_price ?? 20 }}"
                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                                <input type="range" min="0" name="end_price" max="500000"
                                    value="{{ request()->end_price ?? 500000 }}"
                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                            </div>
                        </div>

                        <div class="pt-8">
                            <p class="text-sm lg:text-base">
                                {{ __('Price:') }} <span
                                    class="text-text-danger min-price">${{ request()->start_price ?? 20 }}</span>
                                -
                                <span class="text-text-danger max-price">${{ request()->end_price ?? 50000 }}</span>
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
                        class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div> --}}
    {{-- Mid Content --}}
    <section class="pb-15">
        <div class="container">
            <div class="flex justify-start gap-10 overflow-hidden 2xl:overflow-visible p-1">
                <div
                    class="w-full filter-sidebar fixed 2xl:sticky 2xl:w-1/4 top-0 2xl:top-24 left-0 h-screen 2xl:h-screen max-h-screen 2xl:max-h-fit bg-bg-black/50 2xl:bg-transparent z-[99999] 2xl:z-0 -translate-x-full 2xl:translate-x-0 transition-all duration-300 ease-in-out overflow-y-auto px-2 2xl:p-0 py-5">
                    <form action="{{ route('frontend.parts-accessories.filter') }}" method="post"
                        class="w-5/6 sm:w-4/6 md:w-3/6 lg:w-2/5 2xl:w-full h-full 2xl:h-fit flex flex-col gap-2">
                        @csrf
                        <div class="bg-bg-light dark:bg-bg-dark-tertiary rounded-lg p-4 flex justify-between items-center">
                            <h3 class="text-lg md:text-xl font-semibold  capitalize">
                                {{ __('Customize Your Results') }}</h3>
                            <button type="button" class="closeFilterSidebar btn btn-sm btn-circle btn-ghost 2xl:hidden"><i
                                    data-lucide="x" class="w-5 h-5"></i></button>
                        </div>
                        <div
                            class="space-y-3 shadow-card dark:shadow-dark-card rounded-lg bg-bg-secondary dark:bg-bg-dark-tertiary overflow-hidden h-full py-3">
                            <div class="p-4 pb-0">
                                <div data-target="category-filter">
                                    <h3 class="text-xl font-medium">{{ __('Category') }}</h3>
                                </div>

                                <div class="filter-content" id="category-filter">
                                    <div class="mt-2">
                                        <select class="select select2" name="subcategory" id="subcategory">
                                            <option value="">{{ __('All Agricultural') }}</option>
                                            @foreach ($categories as $children)
                                                <option value="{{ $children->slug }}"
                                                    {{ request()->category == $children->slug ? 'selected' : '' }}>
                                                    {{ $children->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4">
                                <h3 class="text-sm md:text-base font-medium">{{ __('Make') }}</h3>
                                <select class="select mt-2 select2" name="company">
                                    <option value="" selected>Select Make</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->slug }}"
                                            {{ request()->company == $company->slug ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'company']" />
                            </div>
                            <div>

                                <details class="collapse collapse-arrow" open>
                                    <summary class="collapse-title text-xl font-medium">{{ __('Price') }}</summary>
                                    <div class="collapse-content">
                                        <div class="mb-3">
                                            <div class="relative w-full price-slider">
                                                <div
                                                    class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full">
                                                </div>
                                                <div class="absolute h-1 z-[2] rounded-full bg-bg-primary slider-range">
                                                </div>
                                                <input type="range" name="start_price" min="0" max="500000"
                                                    value="{{ request()->start_price ?? 20 }}"
                                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                                                <input type="range" min="0" name="end_price" max="500000"
                                                    value="{{ request()->end_price ?? 500000 }}"
                                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                                            </div>
                                        </div>

                                        <div class="pt-8">
                                            <p class="text-sm lg:text-base">
                                                {{ __('Price:') }} <span
                                                    class="text-text-danger min-price">${{ request()->start_price ?? 20 }}</span>
                                                -
                                                <span
                                                    class="text-text-danger max-price">${{ request()->end_price ?? 50000 }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </details>
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

                <div class="w-full xl:w-3/4">
                    {{-- Products Grid --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-2 md:gap-3">
                            <button
                                class="openFilterSidebar btn px-2 py-0 rounded-md bg-transparent border border-bg-accent text-text-accent text-xs font-medium xs:text-sm xs:px-5 xs:py-2 lg:text-base w-fit text-nowrap xl:hidden">
                                <span><i data-lucide="sliders-horizontal" class="w-5 h-5"></i></span>
                                <span class="ml-2 text-base">{{ __('Filter') }}</span>
                            </button>
                            <h2 class="text-sm xs:text-base md:text-lg  font-semibold">{{ __('Sort') }}
                                <span>{{ number_format(count($products)) }}</span>
                            </h2>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('frontend.parts-accessories.filter', $categories) }}" method="POST"
                                id="filter_form">
                                @csrf
                                <select name="sort" id="sort-select" class="select select2">
                                    <option value="" {{ request()->sort == '' ? 'selected' : '' }}>Default
                                    </option>
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
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-gray-600">{{ __('Loading products...') }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="products-grid">
                        @foreach ($products as $product)
                            <x-frontend.parts-accessories :product="$product" /> 
                        @endforeach

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
    <script script>
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
