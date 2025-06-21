@extends('frontend.layouts.app', ['page_slug' => 'home'])

@section('title', 'Home')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    
    {{-- ===================== Category Section Start ===================== --}}

   <section class="bg-bg-light-secondary dark:bg-bg-dark-secondary py-6 sm:py-10">
    <div class="w-full">
        <!-- Categories Section -->
        <div class="">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-2 sm:gap-3 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                    <!-- Category Cards -->
                    <!-- Row 1 -->
                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="relative flex items-center gap-2 sm:gap-3">
                            <div class="text-text-tertiary font-bold text-sm sm:text-lg mb-1 group-hover:text-white">ALL</div>
                            <!-- Divider -->
                            <div
                                class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                            </div>
                            <div class="text-gray-500 text-xs sm:text-sm group-hover:text-white">ALL(1406)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <!-- Icon -->
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-truck"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <!-- Text -->
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">TRUCKS(77)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">FARM(0)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">FORKLIFT(264)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">SALVAGE</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">DELIVERY FEE</div>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-car"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">CARS(1018)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-bus"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">BUS(6)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <!-- Icon Wrapper -->
                        <div class="flex items-center">
                            <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                                <i class="fas fa-tools"></i>
                            </div>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-4 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <!-- Text Wrapper -->
                        <div class="flex flex-col justify-center">
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">MACHINERY(47)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">Other(62)</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">USED ITEMS</div>
                        </div>
                    </div>

                    <div
                        class="group relative bg-bg-light-secondary dark:bg-bg-dark p-3 sm:p-4 rounded-lg shadow-sm hover:shadow-lg hover:bg-bg-primary cursor-pointer flex items-center transition-all duration-300 transform hover:-translate-y-1 border dark:border-border-dark-secondary dark:shadow-lg hover:border-blue-100">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                        <div class="text-text-tertiary text-xl sm:text-2xl group-hover:text-white transition-colors">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <!-- Divider -->
                        <div
                            class="border-l h-6 sm:h-10 mx-2 sm:mx-3 border-gray-300 dark:border-border-dark-tertiary group-hover:border-white">
                        </div>
                        <div>
                            <div class="font-medium text-xs sm:text-sm group-hover:text-white">AUTO PARTS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    {{-- ===================== Category Section End ===================== --}}

    {{-- ===================== Featured Section Start ===================== --}}
    <section class="py-15 bg-bg-light dark:bg-bg-dark">
        <div class="container">
            <div class="header">
                <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase text-center">
                    {{ __('Featured Products') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5 mt-8">
                @forelse ($featured_products as $product)
                    @php
                        $buttons = [
                            [
                                'route' => route('frontend.checkout.single', ['slug' => $product->slug]),
                                'icon' => 'shopping-cart',
                                'label' => 'Buy Now',
                                'bg' => false,
                            ],
                            [
                                'route' => 'javascript:void(0)',
                                'icon' => 'shopping-basket',
                                'label' => 'Add to Cart',
                                'bg' => true,
                                'class' => 'add-to-cart',
                                'data_id' => $product->id,
                            ],
                        ];
                    @endphp
                    <x-frontend.product :product="$product" :buttons="$buttons" />
                @empty
                @endforelse
            </div>
            <div class="text-center mx-auto xl:mt-15 lg:mt-11 md:mt-9 mt-7">
                <button>
                    <a href="{{ route('frontend.products') }}" class="btn-primary ">
                        {{ __('Shop Now') }}
                    </a>
                </button>
            </div>
        </div>
    </section>
    {{-- ===================== Featured Section End ===================== --}}

    {{-- ===================== countdown Group Container Section Start ===================== --}}
    <section
        class="countdown_section flex justify-center items-center xl:py-20 lg:py-16 md:py-12 py-8  m-0 bg-gray-100 dark:bg-bg-dark-secondary ">
        <div class="container">
            @if ($container)
                <div
                    class="bg-bg-tertiary/40 dark:bg-bg-dark-tertiary text-text-white mx-auto rounded-lg p-3 xl:py-12 lg:py-10 md:py-8 text-center w-full max-w-3xl shadow-md">
                    <h3 class="text-2xl font-bold mb-2">{{ __('Join Group Container - Save on Shipping') }}</h3>
                    <p class="text-xl mb-5">{{ __('Next Departure: From ') }} {{ $container?->shippingPort?->name }}
                        {{ __(' to ') }}{{ $container?->destinationPort?->name }}</p>
                    <div class="countdown-blocks py-2" data-year="{{ date('Y', strtotime($container->deadline)) }}"
                        data-month="{{ date('m', strtotime($container->deadline)) }}"
                        data-date="{{ date('d', strtotime($container->deadline)) }}"
                        data-hour="{{ date('H', strtotime($container->deadline)) }}"
                        data-minute="{{ date('i', strtotime($container->deadline)) }}"
                        data-second="{{ date('s', strtotime($container->deadline)) }}"></div>
                    <a href="{{ route('frontend.group_shipping') }}"
                        class="btn-primary mx-auto py-2 xl:mt-9 lg:mt-7 md:mt-5 mt-3 px-10 ">
                        {{ __('Join Now') }}
                    </a>
                </div>
            @endif
            <div class="pt-15">
                <div class="header">
                    <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase text-center">
                        {{ __('How it Works') }}</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-8">
                    <div
                        class="w-full rounded-xl p-8 bg-bg-light-secondary dark:bg-bg-dark-tertiary py-9  shadow-lg text-center">
                        <i data-lucide="cpu" class="w-16 h-16 mx-auto text-text-secondary/40 "></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Select Your Machine') }}</p>
                        <p class="text-muted-text">
                            {{ __('Browse our extensive inventory of high-quality machinery from trusted suppliers around the world.') }}
                        </p>
                    </div>
                    <div
                        class="w-full rounded-xl p-8 bg-bg-light-secondary dark:bg-bg-dark-tertiary  py-9  shadow-lg text-center">
                        <i data-lucide="ship" class="w-16 h-16 mx-auto text-text-secondary/40"></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Arrange for Export') }}</p>
                        <p class="text-muted-text">
                            {{ __("Once you've selected your machine, we handle the export process from start to finish.") }}
                        </p>
                    </div>
                    <div
                        class="w-full rounded-xl p-8 bg-bg-light-secondary dark:bg-bg-dark-tertiary  py-9  shadow-lg text-center">
                        <i data-lucide="inbox" class="w-16 h-16 mx-auto text-text-secondary/40"></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Receive at Port') }}</p>
                        <p class="text-muted-text">
                            {{ __("We'll deliver your machine safely to the destination port of your choice — anywhere in the world.") }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== countdown Group Container Section End ===================== --}}


    {{-- ===================== Testimonial Section Start ===================== --}}
    <section class="py-8 md:py-10 xl:mb-8 mb-4 lg:py-12 xl:py-16 2xl:py-20 relative">
        <div class="container mx-auto px-4">
            <div class="header text-center mb-10">
                <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase">
                    {{ __('Testimonials') }}
                </h2>
            </div>

            <!-- Testimonial Carousel -->
            <div class="relative">
                <div class="swiper testimonials static">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $testimonial)
                            @php
                                $isLong = strlen($testimonial->quote) > 130;
                                $shortQuote = Str::limit($testimonial->quote, 130, '');
                            @endphp

                            <div class="swiper-slide">
                                <x-frontend.testimonial-card :testimonial="$testimonial" :isLong="$isLong" :shortQuote="$shortQuote" />
                            </div>
                        @endforeach
                    </div>

                    <div class="hidden xl:block">
                        <div class="swiper-pagination z-10 !-bottom-6 lg:!-bottom-8"></div>
                        <!-- Navigation buttons -->
                        <div class="swiper-button swiper-button-prev 3xl:-left-13 2xl:-left-9">
                            <i data-lucide="chevron-left" class="w-5 h-5 dark:text-text-white"></i>
                        </div>

                        <div class="swiper-button swiper-button-next 3xl:-right-13 2xl:-right-9">
                            <i data-lucide="chevron-right" class="w-5 h-5 dark:text-text-white"></i>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    {{-- ===================== Testimonial Section End ===================== --}}

@endsection


@push('js')
    <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';
      
        // Testimonial SWIPER
        const testimonialSwiperEl = document.querySelector('.testimonials');
        const testimonialSwiper = new Swiper(testimonialSwiperEl, {
            loop: true,
            slidesPerView: 3,
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
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
            },
        });

        // On hover stop autoplay
        testimonialSwiperEl.addEventListener('mouseenter', () => {
            testimonialSwiper.autoplay.stop();
        });

        testimonialSwiperEl.addEventListener('mouseleave', () => {
            testimonialSwiper.autoplay.start();
        });
    </script>
    {{-- countdown --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countdownElement = document.querySelector(".countdown-blocks");

            // ✅ Safely check if countdown element exists
            if (!countdownElement) return;

            // Read date from data-* attributes
            const year = parseInt(countdownElement.getAttribute("data-year"));
            const month = parseInt(countdownElement.getAttribute("data-month")) -
                1; // JavaScript months are 0-based
            const date = parseInt(countdownElement.getAttribute("data-date"));
            const hour = parseInt(countdownElement.getAttribute("data-hour"));
            const minute = parseInt(countdownElement.getAttribute("data-minute"));
            const second = parseInt(countdownElement.getAttribute("data-second"));

            const launchDate = new Date(year, month, date, hour, minute, second);

            const createBlock = (label, value) => {
                const block = document.createElement("div");
                block.className = "time-block";

                const valueEl = document.createElement("span");
                valueEl.className = "time-value";
                valueEl.textContent = value < 10 ? `0${value}` : value;

                const labelEl = document.createElement("p");
                labelEl.className = "time-label";
                labelEl.textContent = label;

                if (label === "Seconds") {
                    valueEl.style.animation = "pulse 1s infinite";
                }

                block.appendChild(valueEl);
                block.appendChild(labelEl);
                return block;
            };

            const updateCountdown = () => {
                const now = new Date();
                const difference = launchDate - now;

                countdownElement.innerHTML = "";

                if (difference > 0) {
                    const timeLeft = {
                        Days: Math.floor(difference / (1000 * 60 * 60 * 24)),
                        Hours: Math.floor((difference / (1000 * 60 * 60)) % 24),
                        Minutes: Math.floor((difference / 1000 / 60) % 60),
                        Seconds: Math.floor((difference / 1000) % 60)
                    };

                    for (const [label, value] of Object.entries(timeLeft)) {
                        countdownElement.appendChild(createBlock(label, value));
                    }
                } else {
                    const messageBlock = document.createElement("div");
                    messageBlock.className = "time-block expired-message text-danger";
                    messageBlock.style.gridColumn = "1 / -1";
                    messageBlock.style.padding = "2rem";
                    messageBlock.textContent = "Closed!";
                    countdownElement.appendChild(messageBlock);
                    clearInterval(timer); // ✅ timer is now defined earlier
                }
            };

            const timer = setInterval(updateCountdown, 1000); // ✅ defined before use
            updateCountdown(); // initial call
        });
    </script>
    {{-- quote Read more functionality --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".read-toggle").forEach(function(toggleBtn) {
                toggleBtn.addEventListener("click", function() {
                    const container = this.closest("p");
                    const preview = container.querySelector(".quote-preview");
                    const full = container.querySelector(".quote-full");

                    if (preview.classList.contains("hidden")) {
                        // Show short version
                        preview.classList.remove("hidden");
                        full.classList.add("hidden");
                        this.innerText = "Read more";
                    } else {
                        // Show full version
                        preview.classList.add("hidden");
                        full.classList.remove("hidden");
                        this.innerText = "Show less";
                    }
                });
            });
        });
    </script>
@endpush
