@extends('frontend.layouts.app', ['page_slug' => 'home'])

@section('title', 'Home')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <style>
        #countdown {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
            text-align: center;
        }

        .countdown-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 0.75rem;
            color: #022622;
            font-weight: 700;
            line-height: 1.2;
        }

        .countdown-description {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            margin-bottom: 2.5rem;
            color: #4b5563;
            line-height: 1.5;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .countdown-blocks {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            justify-content: center;
            padding: 0 1rem;
        }

        .time-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            padding: 1.25rem 0.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            min-height: 90px;
        }

        .time-block:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background-color: #e5e7eb;
        }

        .time-value {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: bold;
            color: #022622;
            margin-bottom: 0.25rem;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .time-label {
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0;
        }

        /* Animation for seconds changing */
        .seconds .time-value {
            animation: pulse 1s ease;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Small screens (mobile) */
        @media (max-width: 640px) {
            .countdown-blocks {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .time-block {
                padding: 1rem 0.5rem;
                min-height: 80px;
            }

            #countdown {
                padding: 1.5rem 0.5rem;
            }
        }

        /* Medium screens (tablets) */
        @media (min-width: 641px) and (max-width: 1023px) {
            .countdown-blocks {
                gap: 1.25rem;
            }

            .time-block {
                padding: 1.5rem 0.75rem;
            }
        }

        /* Large screens (desktops) */
        @media (min-width: 1024px) {
            .countdown-blocks {
                gap: 1.5rem;
            }

            .time-block {
                padding: 1.75rem 1rem;
                min-height: 110px;
            }

            #countdown {
                padding: 3rem 1rem;
            }
        }

        /* Extra large screens */
        @media (min-width: 1280px) {
            #countdown {
                max-width: 900px;
            }
        }

        /* Accessibility focus states */
        .time-block:focus {
            outline: 2px solid #022622;
            outline-offset: 2px;
        }
    </style> --}}
@endpush

@section('content')
    {{-- ===================== banner Section Start ===================== --}}
    <section
        class="lg:max-h-screen max-h-[70vh] md:max-h-[80vh] h-[calc(100vh-80px)] xs:h-[calc(100vh-60px)] relative overflow-hidden">
        <div class="absolute bg-transparent inset-0 z-10">
            <div class="container flex items-center justify-center h-full px-4 xs:px-2">
                <div class="text-center w-full">
                    <h1 class="text-3xl xs:text-3xl sm:text-5xl md:text-5xl lg:text-6xl font-bold pb-3 text-text-white">
                        {{ __('Affordable Machines,') }} <br class="hidden xs:block"> {{ __('Shipped Worldwide') }}
                    </h1>
                    <p class="my-4 text-base xs:text-sm sm:text-lg md:text-xl text-text-white px-4 xs:px-0">
                        {{ __('Discover amazing content and features.') }}
                    </p>
                    <div
                        class="relative  2xl:max-w-[700px] xl:max-w-[600px] lg:max-w-[500px] max-w-96 mx-auto px-4 xs:px-2">
                        <input type="search" id="machine-search"
                            class="block w-full xl:py-4 md:py-3 py-2 px-1 xs:px-2 pl-4 pr-16 text-sm xs:text-xs border-none rounded-lg bg-bg-light-secondary focus:ring-blue-500 focus:border-blue-600"
                            placeholder="{{ __('Find your machine...') }}">
                        <button type="submit"
                            class="text-text-white absolute right-0 top-0 bottom-0 bg-bg-primary hover:bg-bg-primary/90 font-medium rounded-l-none rounded-r-lg text-sm px-4">
                            <svg class="w-5 h-5 text-text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper banner h-full">
            <div class="swiper-wrapper h-full">
                @foreach ($banners as $banner)
                    <div class="swiper-slide h-full">
                        <img class="w-full h-full object-cover bg-center" src="{{ storage_url($banner->image) }}"
                            alt="{{ $banner->name }}">
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
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                        <div class="swiper-slide py-8">
                                <a href="{{ route('frontend.products', $category->slug) }}">
                                <div>
                                    <div class="text-center">
                                        <img class="w-auto rounded-xl object-cover mx-auto"
                                            src="{{ $category->modified_image }}" alt="{{ $category?->name }}">
                                        <p class="py-2">{{ __($category?->name) }} </p>
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
            <div class="text-center mx-auto xl:mt-10 lg:mt-8 md:mt-6 mt-4">
                <button>
                    <a href="#" class="btn-primary ">
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
                <h3 class="text-2xl font-bold mb-2">{{ __('Join Group Container – Save on Shipping') }}</h3>
                <p class="text-xl mb-5">{{ __('Next Departure to Dakar, Senegal:') }}</p>
                <div class="countdown-blocks py-2"></div>
                <button class="btn-primary mx-auto py-3 mt-2 px-10 ">
                    {{ __('Join Now') }}
                </button>
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
                                $shortQuote = \Illuminate\Support\Str::limit($testimonial->quote, 200, '');
                            @endphp

                            <div class="swiper-slide">
                                <div
                                    class="bg-bg-light dark:bg-bg-dark rounded-xl shadow-card dark:shadow-dark-card overflow-hidden">
                                    <!-- Top Gradient Bar -->
                                    <div
                                        class="h-1 w-full bg-gradient-to-r from-text-secondary to-text-tertiary dark:from-text-light dark:to-text-light">
                                    </div>

                                    <!-- Testimonial Content -->
                                    <div class="p-6 md:p-8">
                                        <!-- Quotation Mark -->
                                        <div
                                            class="text-text-secondary dark:text-text-light text-6xl font-serif mb-4 leading-none">
                                            “</div>

                                        <!-- Message -->
                                        <p
                                            class="text-lg md:text-xl font-light leading-relaxed font-montserrat mb-6 text-text-primary dark:text-text-dark-secondary">
                                            <span
                                                class="quote-preview">{{ $isLong ? $shortQuote : $testimonial->quote }}</span>
                                            @if ($isLong)
                                                <span class="quote-full hidden">{{ $testimonial->quote }}</span>
                                                <span class="text-blue-600 cursor-pointer read-toggle">Read more</span>
                                            @endif
                                        </p>

                                        <!-- Author Info -->
                                        <div
                                            class="border-t border-border-gray dark:border-border-dark-secondary pt-6 flex items-center gap-4">
                                            <img src="{{ $testimonial->modified_image }}"
                                                alt="{{ $testimonial->author_name }}"
                                                class="w-18 h-18 rounded-full object-cover">

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
                                    </div>

                                    <!-- Bottom Gradient Bar -->
                                    <div
                                        class="h-1 w-full bg-gradient-to-r from-text-tertiary to-text-secondary dark:from-text-light dark:to-text-light">
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

                    <!-- WhatsApp Floating Icon -->
                    <div
                        class="right-10 bottom-10 z-10 fixed shadow-lg w-16 h-16 flex items-center justify-center bg-gradient-primary rounded-full">
                        <a href="#">
                            <i class="fa-brands fa-whatsapp text-5xl text-text-light"></i>
                        </a>
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
                    slidesPerView: 1
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
        const launchDate = new Date(2025, 12, 31, 0, 0, 0); // YYYY, MM (0-based), DD, HH, MM, SS
        const countdownElement = document.querySelector(".countdown-blocks");

        // Your existing createBlock function
        const createBlock = (label, value) => {
            const block = document.createElement("div");
            block.className = "time-block";

            const valueEl = document.createElement("span");
            valueEl.className = "time-value";
            // Add leading zeros for single-digit values
            valueEl.textContent = value < 10 ? `0${value}` : value;

            const labelEl = document.createElement("p");
            labelEl.className = "time-label";
            labelEl.textContent = label;

            // Add pulsing animation to seconds block
            if (label === "Seconds") {
                valueEl.style.animation = "pulse 1s infinite";
            }

            block.appendChild(valueEl);
            block.appendChild(labelEl);
            return block;
        };

        // Modified updateCountdown function
        const updateCountdown = () => {
            const now = new Date();
            const difference = launchDate - now;

            if (difference > 0) {
                const timeLeft = {
                    Days: Math.floor(difference / (1000 * 60 * 60 * 24)),
                    Hours: Math.floor((difference / (1000 * 60 * 60)) % 24),
                    Minutes: Math.floor((difference / 1000 / 60) % 60),
                    Seconds: Math.floor((difference / 1000) % 60)
                };

                countdownElement.innerHTML = "";
                for (const [label, value] of Object.entries(timeLeft)) {
                    countdownElement.appendChild(createBlock(label, value));
                }
            } else {
                // Handle countdown expiration
                countdownElement.innerHTML = "";
                document.querySelector(".countdown-title").textContent = "Launch Day!";
                document.querySelector(".countdown-description").textContent =
                    "The day has arrived!";

                const messageBlock = document.createElement("div");
                messageBlock.className = "time-block expired-message";
                messageBlock.style.gridColumn = "1 / -1";
                messageBlock.style.padding = "2rem";
                messageBlock.textContent = "We're live now!";

                countdownElement.appendChild(messageBlock);
                clearInterval(timer);
            }
        };

        // Initialize and set the interval
        updateCountdown();
        const timer = setInterval(updateCountdown, 1000);
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
