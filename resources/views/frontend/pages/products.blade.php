@extends('frontend.layouts.app', ['page_slug' => 'products'])

@section('title', 'Products')

@section('content')
    @if (isset($category))
        <section class="py-15">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-3xl font-semibold text-text-primary dark:text-text-light text-center">
                            {{ $category->name }}
                        </h1>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="2xl:py-20 xl:py-16 lg:py-12 md:py-10 py-8">
            <div class="container">
                <div class="header text-center mb-10">
                    <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase">
                        {{ __('Categories') }}</h2>
                </div>
                <div class="relative">
                    <div class="swiper categories static">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $cat)
                                <div class="swiper-slide">
                                    <a href="{{ route('frontend.products', $cat->slug) }}">
                                        <div>
                                            <div class="text-center">
                                                <img class="w-full h-36 rounded-xl object-cover mx-auto"
                                                    src="{{ $cat->modified_image }}" alt="{{ $cat?->name }}">
                                                <p class="py-2">{{ __($cat?->name) }} </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="hidden xl:block">
                            <div class="swiper-pagination z-10 !-bottom-6 lg:!-bottom-8"></div>
                            <!-- Navigation buttons -->
                            <div class="swiper-button swiper-button-prev 3xl:-left-13 2xl:-left-9">
                                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                            </div>

                            <div class="swiper-button swiper-button-next 3xl:-right-13 2xl:-right-9">
                                <i data-lucide="chevron-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    
    {{-- Mid Content --}}

    <section class="py-15">
        <div class="container">
            <div class="flex justify-start gap-10 overflow-hidden 2xl:overflow-visible p-1">
                <div
                    class="w-full filter-sidebar fixed 2xl:sticky 2xl:w-1/4 top-0 2xl:top-24 left-0 h-screen 2xl:h-screen max-h-screen 2xl:max-h-fit bg-bg-black/50 2xl:bg-transparent z-[99999] 2xl:z-0 -translate-x-full 2xl:translate-x-0 transition-all duration-300 ease-in-out overflow-y-auto px-2 2xl:p-0 py-5">
                    <form action="{{ route('frontend.products.filter', isset($category) ? $category->slug : '') }}"
                        method="post"
                        class="w-5/6 sm:w-4/6 md:w-3/6 lg:w-2/5 2xl:w-full h-full 2xl:h-fit flex flex-col gap-2">
                        @csrf
                        <div class="bg-bg-light dark:bg-bg-dark-tertiary rounded-lg p-4 flex justify-between items-center">
                            <h3 class="text-lg md:text-xl font-semibold  capitalize">
                                {{ __(' Product fillters') }}</h3>
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
                                            <option value="">{{ __('All') }}</option>
                                            @foreach ($subcategories as $children)
                                                <option value="{{ $children->slug }}"
                                                    {{ request()->subcategory == $children->slug ? 'selected' : '' }}>
                                                    {{ $children->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 pb-0">
                                <div data-target="brand-filter">
                                    <h3 class="text-xl font-medium">{{ __('Brand') }}</h3>
                                </div>

                                <div class="filter-content" id="brand-filter">
                                    <div class="mt-2">
                                        <select name="brand" id="brand" class="select select2">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->slug }}"
                                                    {{ request()->brand == $brand->slug ? 'selected' : '' }}>
                                                    {{ $brand->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 pb-0">
                                <div data-target="model-filter">
                                    <h3 class="text-xl font-medium">{{ __('Model') }}</h3>
                                </div>

                                <div class="filter-content" id="model-filter">
                                    <div class="mt-2">
                                        <select name="model" id="model" class="select select2">
                                            <option value="">{{ __('All') }}</option>

                                            @foreach ($models as $model)
                                                <option value="{{ $model->slug }}"
                                                    {{ request()->model == $model->slug ? 'selected' : '' }}>
                                                    {{ $model->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 pb-0">
                                <div data-target="year-filter">
                                    <h3 class="text-xl font-medium">{{ __('Year') }}</h3>
                                </div>

                                <div class="filter-content" id="year-filter">
                                    <div class="mt-2">
                                        <select name="year" id="year" class="select select2">
                                            <option value=" ">{{ __('All') }}</option>
                                            @for ($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}"
                                                    {{ request()->year == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                            <span
                                                class="text-text-danger max-price">${{ request()->end_price ?? 50000 }}</span>
                                        </p>
                                    </div>
                                </div>
                            </details>
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
                <div class="w-full 2xl:basis-3/4">
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
                            <form
                                action="{{ route('frontend.products.filter', isset($category) ? $category->slug : '') }}"
                                method="POST" id="filter_form">
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
                    <div id="loading-indicator" class="hidden flex justify-center items-center py-12">
                        <div class="loading-spinner"></div>
                        <span class="ml-3 text-gray-600">{{ __('Loading products...') }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="products-grid">
                        @forelse ($products as $product)
                            <x-frontend.product :product="$product" />
                        @empty
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
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
    <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';
        // CATEGORY SWIPER
        const categorySwiperEl = document.querySelector('.categories');
        const categorySwiper = new Swiper(categorySwiperEl, {
            loop: true,
            slidesPerView: 6,
            spaceBetween: 20,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 2
                },
                450: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                },
                1280: {
                    slidesPerView: 5
                },
                1536: {
                    slidesPerView: 6
                },
            },
            on: {
                init: function() {
                    hideControlsIfNotEnoughSlides(categorySwiperEl, this, () => this.params.slidesPerView);
                }
            }

        });
        categorySwiperEl.addEventListener('mouseenter', () => {
            categorySwiper.autoplay.stop();
        });

        categorySwiperEl.addEventListener('mouseleave', () => {
            categorySwiper.autoplay.start();
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#sort-select").on("change", function() {
                $("#filter_form").submit();
            });
        });
    </script>
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
