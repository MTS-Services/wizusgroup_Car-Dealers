@extends('frontend.layouts.app', ['page_slug' => 'dropshipping'])

@section('title', 'Dropshipping')
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
@section('content')
{{-- special deals section start --}}
    <section class="bg-bg-light dark:bg-bg-dark py-10 px-6 lg:px-20 2xl:py-24 font-poppins">
        <div class="container mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">

                <h2 class="text-3xl font-bold text-text-primary dark:text-text-white">{{ __('SPECIAL ORDER DEALS') }}</h2>
                <p class="text-lg text-text-secondary mt-2">{{ __('Imported from our global warehouse') }}</p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
                <!-- Product 1 -->
                <div class="bg-bg-white dark:bg-bg-primary/70  rounded-xl shadow-md p-4">
                    <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit mb-3">
                        {{ __('Ships in 14–21 days') }}
                    </div>
                    <img src="{{ asset('frontend/images/special (1).jpg') }}" alt="Electric Sprayer"
                        class="h-32 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">{{ __('Electric Sprayer 16L') }}</h3>
                    <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$75') }}</p>
                    <button class="bg-bg-tertiary/70 text-white px-3 py-1 rounded mt-2 text-sm">
                        {{ __('WhatsApp Inquiry') }}
                    </button>
                    <p class="text-sm text-text-primary dark:text-text-white mt-2">
                        {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                    </p>
                </div>

                <!-- Product 2 -->
                <div class="bg-bg-white dark:bg-bg-primary/70  rounded-xl shadow-md p-4">
                    <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit mb-3">
                        {{ __('Ships in 14–21 days') }}
                    </div>
                    <img src="{{ asset('frontend/images/special (2).jpg') }}" alt="Mini Excavator"
                        class="h-32 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">{{ __('Mini Excavator') }}</h3>
                    <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$4,500') }}</p>
                    <button class="bg-bg-tertiary/70 text-white px-3 py-1 rounded mt-2 text-sm">
                        {{ __('WhatsApp Inquiry') }}
                    </button>
                    <p class="text-sm text-text-primary dark:text-text-white mt-2">
                        {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                    </p>
                </div>

                <!-- Product 3 -->
                <div class="bg-bg-white dark:bg-bg-primary/70  rounded-xl shadow-md p-4">
                    <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit mb-3">
                        {{ __('Ships in 14–21 days') }}
                    </div>
                    <img src="{{ asset('frontend/images/special (3).jpg') }}" alt="Tractor Tool"
                        class="h-32 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">{{ __('Tractor Tool') }}</h3>
                    <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$120') }}</p>
                    <button class="bg-bg-tertiary/70 text-white px-3 py-1 rounded mt-2 text-sm">
                        {{ __('WhatsApp Inquiry') }}
                    </button>
                    <p class="text-sm text-text-primary dark:text-text-white mt-2">
                        {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                    </p>
                </div>

                <!-- Product 4 -->
                <div class="bg-bg-white dark:bg-bg-primary/70  rounded-xl shadow-md p-4">
                    <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit mb-3">
                        {{ __('Ships in 14–21 days') }}
                    </div>
                    <img src="{{ asset('frontend/images/special (4).jpg') }}" alt="Tractor Tool"
                        class="h-32 mx-auto mb-4">
                    <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">{{ __('Tractor Tool') }}</h3>
                    <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$120') }}</p>
                    <button class="bg-bg-tertiary/70 text-white px-3 py-1 rounded mt-2 text-sm">
                        {{ __('WhatsApp Inquiry') }}
                    </button>
                    <p class="text-sm text-text-primary dark:text-text-white mt-2">
                        {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
{{-- special offers section end --}}
<section class="bg-bg-light-secondary dark:bg-bg-dark py-10 px-6 lg:px-20 2xl:py-24 font-poppins">
    <div class="container">
            <div
                class="bg-bg-tertiary/40 dark:bg-bg-secondary/20 text-text-white mx-auto rounded-lg p-6  text-center w-11/12 max-w-3xl shadow-md">
                <h3 class="text-2xl font-bold mb-2">{{ __('Join Group Container – Save on Shipping') }}</h3>
                <p class="text-xl mb-5">{{ __('Next Departure to Dakar, Senegal:') }}</p>
                <div class="countdown-blocks py-2"></div>
                <button class="btn-primary mx-auto py-3 mt-2 px-10 ">
                    {{ __('JOIN NOW') }}
                </button>
            </div>
            <div class="pt-10">
                <div class="header">
                    <h2 class="text-3xl font-bold uppercase text-center">{{ __('How it Works') }}</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
                    <div class="bg-bg-light-secondary dark:bg-bg-primary/30 py-9 p-2 shadow-lg text-center">
                        <i data-lucide="shopping-cart" class="w-12 h-12 mx-auto"></i>
                        <p class="py-2">{{ __('Select Your Machine') }}</p>
                    </div>
                    <div class="bg-bg-light-secondary dark:bg-bg-primary/30  py-9 p-2 shadow-lg text-center">
                        <i data-lucide="ship" class="w-12 h-12 mx-auto"></i>
                        <p class="py-2">{{ __('Arrange for Export') }}</p>
                    </div>
                    <div class="bg-bg-light-secondary dark:bg-bg-primary/30  py-9 p-2 shadow-lg text-center">
                        <i data-lucide="shopping-cart" class="w-12 h-12 mx-auto"></i>
                        <p class="py-2">{{ __('Receive at Port') }}</p>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@push('js')
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
