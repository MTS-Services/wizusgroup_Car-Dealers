@extends('frontend.layouts.app', ['page_slug' => 'home'])

@section('title', 'Home')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    {{-- ===================== banner Section Start ===================== --}}
    <section class="lg:max-h-screen max-h-[70vh] md:max-h-[80vh] h-[calc(100vh-80px)] xs:h-[calc(100vh-60px)] relative">
        <div class="swiper banner h-full">
            <div class="swiper-wrapper h-full">
                @foreach ($banners as $banner)
                    <div
                        class="swiper-slide h-full relative after:content-[''] after:w-full after:h-full after:absolute after:top-0 after:left-0 after:bg-bg-dark/35">
                        <img class="w-full h-full object-cover bg-center" src="{{ storage_url($banner->image) }}"
                            alt="{{ $banner->name }}">

                        <div class="absolute bg-transparent inset-0 z-10">
                            <div class="container flex items-center justify-center h-full flex-col gap-5">
                                <div class="max-w-[600px] text-center">
                                    <h1
                                        class="text-xl xs:text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold pb-3 text-text-white dark:text-text-primary">
                                        {{ $banner->title }}
                                    </h1>
                                    <p
                                        class="text-base xs:text-sm sm:text-lg md:text-xl text-text-light-secondary dark:text-text-primary">
                                        {{ $banner->subtitle }}
                                    </p>
                                </div>
                                @if (isset($not_used))
                                    {{-- <form action="" class="w-full">
                                        <div class="join w-full justify-center">
                                            <input type="search" class="input input-search" placeholder="Search here..." />
                                            <button class="btn-search">Search</button>
                                        </div>
                                    </form> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ===================== banner Section End ===================== --}}
    {{-- ===================== Category Section Start ===================== --}}

    <section class="2xl:py-20 xl:py-16 lg:py-12 md:py-10 py-8">
        <div class="container">
            <div class="header text-center mb-10">
                <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase">
                    {{ __('Categories') }}</h2>
            </div>
            <div class="relative">
                <div class="swiper categories static">
                    <div class="swiper-wrapper py-4 sm:py-5">
                        @foreach ($categories as $category)
                            <div class="swiper-slide px-2">
                                <a href="{{ route('frontend.products', $category->slug) }}">
                                    <div class="text-center">
                                        <img class="w-auto rounded-xl object-cover mx-auto"
                                            src="{{ $category->modified_image }}" alt="{{ $category?->name }}">
                                        <p class="py-2">{{ __($category?->name) }} </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls (Hidden on small screens) -->
                    <div class="hidden md:block">
                        <div class="swiper-pagination z-10 !-bottom-6 lg:!-bottom-8"></div>

                        <div
                            class="swiper-button swiper-button-prev absolute top-1/2 transform -translate-y-1/2 -left-4 sm:-left-6 2xl:-left-9">
                            <i data-lucide="chevron-left" class="w-5 h-5"></i>
                        </div>
                        <div
                            class="swiper-button swiper-button-next absolute top-1/2 transform -translate-y-1/2 -right-4 sm:-right-6 2xl:-right-9">
                            <i data-lucide="chevron-right" class="w-5 h-5"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mx-auto xl:mt-10 lg:mt-8 md:mt-6 mt-4">
                <button>
                    <a href="{{ route('frontend.products') }}" class="btn-primary ">
                        {{ __('Shop Now') }}
                    </a>
                </button>
            </div>
        </div>
    </section>

    {{-- ===================== Category Section End ===================== --}}

    {{-- ===================== countdown Group Container Section Start ===================== --}}
    <section
        class="countdown_section flex justify-center items-center xl:py-20 lg:py-16 md:py-12 py-8  m-0 bg-gray-100 dark:bg-bg-dark-secondary ">
        <div class="container">
            <div
                class="bg-bg-tertiary/40 dark:bg-bg-dark-tertiary text-text-white mx-auto rounded-lg p-6 xl:py-12 lg:py-10 md:py-8 py-4 text-center w-11/12 max-w-3xl shadow-md">
                <h3 class="text-2xl font-bold mb-2">{{ __('Join Group Container - Save on Shipping') }}</h3>
                <p class="text-xl mb-5">{{ __('Next Departure: From ') }} {{ $container->shippingPort?->name }}
                    {{ __(' to ') }}{{ $container->destinationPort?->name }}</p>
                <div class="countdown-blocks py-2" data-year="{{ date('Y', strtotime($container->deadline)) }}"
                    data-month="{{ date('m', strtotime($container->deadline)) }}"
                    data-date="{{ date('d', strtotime($container->deadline)) }}"
                    data-hour="{{ date('H', strtotime($container->deadline)) }}"
                    data-minute="{{ date('i', strtotime($container->deadline)) }}"
                    data-second="{{ date('s', strtotime($container->deadline)) }}"></div>
                <a href="{{ route('frontend.group_shipping') }}" class="btn-primary mx-auto py-2 mt-2 px-10 ">
                    {{ __('Join Now') }}
                </a>
            </div>
            <div class="pt-15">
                <div class="header">
                    <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold uppercase text-center">
                        {{ __('How it Works') }}</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                    <div class="bg-bg-light-secondary dark:bg-bg-dark-tertiary py-9 p-2 shadow-lg text-center">
                        <i data-lucide="cpu" class="w-16 h-16 mx-auto text-text-secondary/40 "></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Select Your Machine') }}</p>
                    </div>
                    <div class="bg-bg-light-secondary dark:bg-bg-dark-tertiary  py-9 p-2 shadow-lg text-center">
                        <i data-lucide="ship" class="w-16 h-16 mx-auto text-text-secondary/40"></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Arrange for Export') }}</p>
                    </div>
                    <div class="bg-bg-light-secondary dark:bg-bg-dark-tertiary  py-9 p-2 shadow-lg text-center">
                        <i data-lucide="inbox" class="w-16 h-16 mx-auto text-text-secondary/40"></i>
                        <p class="py-2 text-2xl font-semibold">{{ __('Receive at Port') }}</p>
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
                                $isLong = strlen($testimonial->quote) > 200;
                                $shortQuote = Str::limit($testimonial->quote, 200, '');
                            @endphp

                            <div class="swiper-slide">
                                <div
                                    class="bg-bg-light dark:bg-bg-dark rounded-xl shadow-card dark:shadow-dark-card overflow-hidden min-h-80 lg:min-h-96 flex flex-col justify-between">

                                    <!-- Top Gradient Bar -->
                                    <div>
                                        <div
                                            class="h-1 w-full bg-gradient-to-r from-text-secondary to-text-tertiary dark:from-text-light dark:to-text-light">
                                        </div>

                                        <!-- Testimonial Content -->
                                        <div class="p-6 pb-0 md:p-8 md:pb-0">
                                            <div
                                                class="text-text-secondary dark:text-text-light text-6xl font-serif mb-4 leading-none">
                                                “</div>

                                            <!-- Message -->
                                            <p
                                                class="text-lg md:text-xl font-light leading-relaxed font-montserrat mb-6 text-text-primary dark:text-text-dark-secondary">
                                                <span class="quote-preview">{{ $shortQuote }}</span>
                                                @if ($isLong)
                                                    <span class="quote-full hidden">{{ $testimonial->quote }}</span>
                                                    <span class="text-blue-600 cursor-pointer read-toggle text-sm items-center">Read more<i data-lucide="chevrons-right" class="w-4 h-4 inline-block "></i></span>
                                                    @endif
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Author Info -->
                                    <div>
                                        <div
                                            class="border-t border-border-gray dark:border-border-dark-secondary flex items-center gap-4 p-6 pt-6 md:p-8 md:pt-6">
                                            <img src="{{ $testimonial->modified_image }}"
                                                alt="{{ $testimonial->author_name }}"
                                                class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover">

                                            <div>
                                                <p
                                                    class="text-text-secondary dark:text-text-light font-bold text-lg uppercase font-playfair">
                                                    {{ $testimonial->author_name }}
                                                </p>
                                                <p
                                                    class="text-sm uppercase tracking-wide mt-1 text-text-gray dark:text-text-light">
                                                    {{ __('Country') }}: {{ $testimonial->author_country }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Bottom Gradient Bar -->
                                        <div
                                            class="h-1 w-full bg-gradient-to-r from-text-tertiary to-text-secondary dark:from-text-light dark:to-text-light">
                                        </div>
                                    </div>
                                </div>
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

    {{-- ===================== Testimonial Section End ===================== --}}

@endsection


@push('js')
    <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';
        const bannerEl = document.querySelector('.banner');
        new Swiper(bannerEl, {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            spaceBetween: 20,
            on: {
                init: function() {
                    hideControlsIfNotEnoughSlides(bannerEl, this, 1);
                }
            }
        });

        // CATEGORY SWIPER
        const categorySwiperEl = document.querySelector('.categories');
        new Swiper(categorySwiperEl, {
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


        // Testimonial SWIPER
        const testimonialSwiperEl = document.querySelector('.testimonials');
        new Swiper(testimonialSwiperEl, {
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
