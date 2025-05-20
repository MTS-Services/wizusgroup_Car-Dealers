@extends('frontend.layouts.app', ['page_slug' => 'dropshipping'])

@section('title', 'Dropshipping')
@push('css')
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
            <div class="grid grid-cols-1  md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                <!-- Product 1 -->
                <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-xl shadow-md p-0 overflow-hidden relative">
                    <!-- Image container with absolute positioned text -->
                    <div class="w-full h-72 md:h-[300px] relative">
                        <!-- Full width image -->
                        <img src="{{ asset('frontend/images/special (1).jpg') }}" alt="Electric Sprayer"
                            class="h-full w-full object-cover">

                        <!-- Absolute positioned text -->
                        <div class="absolute top-3 left-3">
                            <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit">
                                {{ __('Ships in 14–21 days') }}
                            </div>
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">
                            {{ __('Electric Sprayer 16L') }}
                        </h3>
                        <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$75') }}</p>
                        <button
                            class="bg-bg-tertiary/70 hover:bg-bg-tertiary text-white px-3 py-1 rounded mt-2 text-sm transition-colors">
                            {{ __('WhatsApp Inquiry') }}
                        </button>
                        <p class="text-sm text-text-primary dark:text-text-white mt-2">
                            {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                        </p>
                    </div>
                </div>
                <!-- Product 2 -->
                 <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-xl shadow-md p-0 overflow-hidden relative">
                    <!-- Image container with absolute positioned text -->
                    <div class="w-full h-72 md:h-[300px] relative">
                        <!-- Full width image -->
                        <img src="{{ asset('frontend/images/special (2).jpg') }}" alt="Electric Sprayer"
                            class="h-full w-full object-cover">

                        <!-- Absolute positioned text -->
                        <div class="absolute top-3 left-3">
                            <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit">
                                {{ __('Ships in 14–21 days') }}
                            </div>
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">
                            {{ __('Electric Sprayer 16L') }}
                        </h3>
                        <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$75') }}</p>
                        <button
                            class="bg-bg-tertiary/70 hover:bg-bg-tertiary text-white px-3 py-1 rounded mt-2 text-sm transition-colors">
                            {{ __('WhatsApp Inquiry') }}
                        </button>
                        <p class="text-sm text-text-primary dark:text-text-white mt-2">
                            {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                        </p>
                    </div>
                </div>

                <!-- Product 3 -->
                 <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-xl shadow-md p-0 overflow-hidden relative">
                    <!-- Image container with absolute positioned text -->
                    <div class="w-full h-72 md:h-[300px] relative">
                        <!-- Full width image -->
                        <img src="{{ asset('frontend/images/special (3).jpg') }}" alt="Electric Sprayer"
                            class="h-full w-full object-cover">

                        <!-- Absolute positioned text -->
                        <div class="absolute top-3 left-3">
                            <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit">
                                {{ __('Ships in 14–21 days') }}
                            </div>
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">
                            {{ __('Electric Sprayer 16L') }}
                        </h3>
                        <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$75') }}</p>
                        <button
                            class="bg-bg-tertiary/70 hover:bg-bg-tertiary text-white px-3 py-1 rounded mt-2 text-sm transition-colors">
                            {{ __('WhatsApp Inquiry') }}
                        </button>
                        <p class="text-sm text-text-primary dark:text-text-white mt-2">
                            {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                        </p>
                    </div>
                </div>

                <!-- Product 4 -->
                   <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-xl shadow-md p-0 overflow-hidden relative">
                    <!-- Image container with absolute positioned text -->
                    <div class="w-full h-72 md:h-[300px] relative">
                        <!-- Full width image -->
                        <img src="{{ asset('frontend/images/special (4).jpg') }}" alt="Electric Sprayer"
                            class="h-full w-full object-cover">

                        <!-- Absolute positioned text -->
                        <div class="absolute top-3 left-3">
                            <div class="text-sm text-white bg-bg-primary rounded px-2 py-1 w-fit">
                                {{ __('Ships in 14–21 days') }}
                            </div>
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-white">
                            {{ __('Electric Sprayer 16L') }}
                        </h3>
                        <p class="text-xl font-bold text-text-primary dark:text-text-white my-1">{{ __('$75') }}</p>
                        <button
                            class="bg-bg-tertiary/70 hover:bg-bg-tertiary text-white px-3 py-1 rounded mt-2 text-sm transition-colors">
                            {{ __('WhatsApp Inquiry') }}
                        </button>
                        <p class="text-sm text-text-primary dark:text-text-white mt-2">
                            {{ __('Eligible for group shipping • Shipped without branding to protect our sourcing') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- special offers section end --}}
    <section class="bg-bg-light-secondary dark:bg-bg-dark  pt-6 pb-10 px-6 lg:px-20 xl:pt-12 md:pb-8 xl:pb-24 lg:pb-16 font-poppins countdown_section">
        <div class="container">
            <div
                class="bg-bg-tertiary/40 dark:bg-bg-dark-tertiary text-text-white mx-auto rounded-lg p-6  text-center w-11/12 max-w-3xl shadow-md">
                <h3 class="text-2xl font-bold mb-2">{{ __('Join Group Container – Save on Shipping') }}</h3>
                <p class="text-xl mb-5">{{ __('Next Departure to Dakar, Senegal:') }}</p>
                <div class="countdown-blocks py-2"></div>
                <button class="btn-primary mx-auto py-3 mt-2 px-10 ">
                    {{ __('JOIN NOW') }}
                </button>
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
