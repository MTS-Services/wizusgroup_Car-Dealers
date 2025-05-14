@extends('frontend.layouts.app', ['page_slug' => 'home'])

@section('title', 'Home')

@push('css')
    <style>
        #countdown {
            max-width: 600px;
            margin: 0 auto 40px;
            text-align: center;
            padding: 20px;
        }

        .countdown-title {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #022622;
            font-weight: 700;
        }

        .countdown-description {
            font-size: 1rem;
            margin-bottom: 2rem;
            color: #4b5563;
        }

        .countdown-blocks {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            justify-content: center;
        }

        .time-block {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f3f4f6;
            padding: 16px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .time-block:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .time-value {
            font-size: 2.25rem;
            font-weight: bold;
            color: #022622;
            margin-bottom: 0.25rem;
        }

        .time-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0;
        }

        /* Medium screens */
        @media (min-width: 768px) {
            .countdown-blocks {
                grid-template-columns: repeat(4, 1fr);
                gap: 22px;
            }
        }

        /* Large screens */
        @media (min-width: 1024px) {
            .countdown-blocks {
                display: grid;
                gap: 24px;
            }

            .time-block {
                min-width: 120px;
                padding: 20px 24px;
            }

            .time-value {
                font-size: 2.5rem;
            }
        }

        /* Add animation for seconds changing */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endpush
@php
    $banners = [
        [
            'image' => asset('backend/home_page/home_page_banner.jpg'),
        ],
        [
            'image' => asset('backend/home_page/home_page_banner.jpg'),
        ],
        [
            'image' => asset('backend/home_page/home_page_banner.jpg'),
        ],
    ];
@endphp

@section('content')
    {{-- ===================== banner Section Start ===================== --}}
    <section class="!max-h-[700px] relative overflow-hidden">
        <div class="absolute bg-transparent inset-0 z-10">
            <div class="container flex items-center justify-center h-full">
                <div class="text-center">
                    <h1 class="text-6xl font-bold pb-3 text-text-white">Affordable Machines, <br> Shipped Worldwide</h1>
                    <p class="my-4 text-xl text-text-white">Discover amazing content and features.</p>
                    <div class="relative w-[700px] mx-auto">
                        <input type="search" id="machine-search"
                            class="block w-full p-4 pl-10 pr-16 text-sm border-none rounded-lg bg-bg-light-secondary focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Find your machine..." required>

                        <button type="submit"
                            class="text-text-white absolute right-0 top-0 bottom-0 bg-bg-orange hover:bg-bg-orange/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-l-none rounded-r-lg text-sm px-4">

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
        <div class="swiper banner">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <img class="w-full object-cover bg-center h-full" src="{{ $banner['image'] }}" alt="image">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ===================== banner Section End ===================== --}}
    {{-- ===================== Category Section Start ===================== --}}
    @php
        $cards = [
            [
                'image' => asset('backend/home_page/tractar.png'),
            ],
            [
                'image' => asset('backend/home_page/tractar.png'),
            ],
            [
                'image' => asset('backend/home_page/tractar.png'),
            ],
            [
                'image' => asset('backend/home_page/tractar.png'),
            ],
        ];
    @endphp

    <section class="py-18">
        <div class="container">
            <div class="header text-center mb-10">
                <h2 class="text-3xl font-bold uppercase">Categories</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 ">
                @foreach ($cards as $card)
                    <div class="bg-bg-light-secondary p-2  shadow-lg text-center">
                        <img class="w-auto h-48 object-cover mx-auto" src="{{ $card['image'] }}" alt="image">
                        <p class="py-2">Machine description goes here.</p>
                        <p><span class="text-text-black font-semibold">$130.00</span></p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ===================== Category Section End ===================== --}}

    {{-- ===================== countdown Group Container Section Start ===================== --}}
    <section class="flex justify-center items-center py-20 m-0 bg-gray-100 font-sans">
        <div class="bg-bg-secondary/60 rounded-lg p-6 text-white text-center w-11/12 max-w-3xl shadow-md">
            <div class="text-2xl font-bold mb-2">Join Group Container – Save on Shipping</div>
            <div class="text-xl mb-5">Next Departure to Dakar, Senegal:</div>
            {{-- <div class="flex justify-center gap-3 mb-6">
                <div class="bg-gray-800 rounded-md w-[70px] h-[80px] flex flex-col justify-center items-center">
                    <p class="text-3xl font-bold m-0">8</p>
                    <p class="text-sm m-0">Days</p>
                </div>
                <div class="bg-gray-800 rounded-md w-[70px] h-[80px] flex flex-col justify-center items-center">
                    <p class="text-3xl font-bold m-0">10</p>
                    <p class="text-sm m-0">Hours</p>
                </div>
                <div class="bg-gray-800 rounded-md w-[70px] h-[80px] flex flex-col justify-center items-center">
                    <p class="text-3xl font-bold m-0">27</p>
                    <p class="text-sm m-0">Minutes</p>
                </div>
                <div class="bg-gray-800 rounded-md w-[70px] h-[80px] flex flex-col justify-center items-center">
                    <p class="text-3xl font-bold m-0">27</p>
                    <p class="text-sm m-0">Seconds</p>
                </div>
            </div> --}}
            <div class="countdown-blocks py-2"></div>
            <button
                class="bg-bg-orange hover:bg-bg-orange/60 text-white font-bold text-lg py-3 px-10 rounded-full transition duration-300">
                JOIN NOW
            </button>
        </div>
    </section>
    {{-- ===================== countdown Group Container Section End ===================== --}}
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
    </script>
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
@endpush
