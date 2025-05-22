@extends('frontend.layouts.app', ['page_slug' => 'group_shipping'])

@section('title', 'Group Shipping')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    {{-- Group Shipping steps start --}}
    <section class="py-8 md:py-12 lg:py-14 xl:py-16 2xl:py-20 bg-bg-primary/20 dark:bg-bg-dark">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="header text-center mb-8 md:mb-12 lg:mb-16">
                <h1
                    class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-5xl font-semibold text-text-secondary dark:text-text-light">
                    {{ __('Simple, Fast, and Secure Process') }}
                </h1>
            </div>
            <div class="grid grid-cols-1  lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 md:gap-6 lg:gap-8">
                <!-- Step 1 -->
                <div
                    class="bg-bg-white dark:bg-gray-800 p-4 md:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 border-2 border-blue-100 dark:border-blue-800">
                                    <i data-lucide="package-search" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="block text-sm font-medium text-blue-600 dark:text-blue-400">{{ __('Step 1') }}</span>
                                <h3
                                    class="text-lg md:text-xl lg:text-2xl font-semibold text-text-secondary dark:text-white">
                                    {{ __('Select Machine') }}</h3>
                            </div>
                        </div>
                        <p class="text-text-primary/60 dark:text-gray-300 text-sm md:text-base mt-2 leading-relaxed">
                            {{ __('Browse our inventory and choose the perfect machine for your needs from our quality selection.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-bg-white dark:bg-gray-800 p-4 md:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center rounded-full bg-bg-tertiary/10 dark:bg-green-900/30 text-text-tertiary dark:text-text-tertiary border-2 border-border-tertiary/10 dark:border-tertiary/10">
                                    <i data-lucide="wallet" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="block text-sm font-medium text-bg-tertiary/90 dark:text-text-tertiary/30">{{ __('Step 2') }}</span>
                                <h3
                                    class="text-lg md:text-xl xl:text-2xl font-semibold text-text-secondary dark:text-white">
                                    {{ __('Pay Deposit') }}</h3>
                            </div>
                        </div>
                        <p class="text-text-primary/60 dark:text-gray-300 text-sm md:text-base mt-2 leading-relaxed">
                            {{ __('Secure your selected machine with a small deposit to reserve it while we prepare for shipping.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-bg-white dark:bg-gray-800 p-4 md:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center rounded-full bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 border-2 border-purple-100 dark:border-purple-800">
                                    <i data-lucide="clock" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="block text-sm font-medium text-purple-600 dark:text-purple-400">{{ __('Step 3') }}</span>
                                <h3
                                    class="text-lg md:text-xl lg:text-2xl font-semibold text-text-secondary dark:text-white">
                                    {{ __('Wait for Container') }}</h3>
                            </div>
                        </div>
                        <p class="text-text-primary/60 dark:text-gray-300 text-sm md:text-base mt-2 leading-relaxed">
                            {{ __('We efficiently group shipments to fill containers, saving you money on transportation costs.') }}
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div
                    class="bg-bg-white dark:bg-gray-800 p-4 md:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="flex flex-col h-full">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center rounded-full bg-bg-primary/10 dark:bg-bg-primary text-text-secondary/70 dark:text-text-secondary/70 border-2 border-border-primary/20 dark:border-border-primary/20">
                                    <i data-lucide="truck" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="block text-sm font-medium text-text-secondary/70 dark:text-orange-400">{{ __('Step 4') }}</span>
                                <h3
                                    class="text-lg md:text-xl lg:text-2xl font-semibold text-text-secondary dark:text-white">
                                    {{ __('Complete & Deliver') }}</h3>
                            </div>
                        </div>
                        <p class="text-text-primary/60 dark:text-gray-300 text-sm md:text-base mt-2 leading-relaxed">
                            {{ __('Pay the remaining balance and receive your machine with all necessary documentation at your chosen port.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Group Shipping steps end --}}
    {{-- Faq section start --}}
    <section class="faq-section">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h4 class="text-text-secondary dark:text-text-white text-xl mb-4 uppercase tracking-wider">
                    {{ __('Navigate Your Queries') }}</h4>
                <h2
                    class="text-text-secondary dark:text-text-white font-black font-Jakarta 2xl:text-3xl xl:text-2xl lg:text-xl md:text-lg text-lg">
                    {{ __('Explore Answers to Common Questions') }}
                </h2>
            </div>

            <div class="space-y-3  mx-auto" id="faq-container">
                <!-- FAQ Item 1 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('What Shipping Options Do You Offer?') }}
                        </h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('We offer standard, expedited, and next-day shipping through trusted carriers like FedEx, UPS, and USPS. During checkout, you\'ll be able to choose the option that best fits your timeline and budget.') }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('Do You Ship Internationally?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('Yes, we ship to most countries worldwide. International shipping rates and delivery times vary depending on your location and the shipping method selected at checkout.') }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('How Long Will My Order Take to Arrive?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('Domestic orders typically arrive within 3–7 business days, while international deliveries can take 7–21 business days depending on customs and local postal services. We’ll provide a tracking number once your order ships.') }}
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('How Can I Track My Order?') }}
                        </h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('Once your order ships, you\'ll receive an email with a tracking link. You can also log in to your account on our website and view your tracking details in the Order History section.') }}
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('What Happens If My Package Is Lost or Delayed?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('If your package is delayed or appears lost, please contact our support team. We’ll work with the shipping carrier to locate your package or arrange a replacement or refund, depending on the situation.') }}
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-base lg:text-lg xl:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('Do You Offer Free Shipping?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-white transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base  text-opacity-80">
                        {{ __('Yes, we offer free standard shipping on all domestic orders over $100. Promotions and free shipping thresholds may vary during special sales events.') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- end faq --}}
    {{-- eligibility criteria start --}}
    <section class="2xl:py-15 xl:py-12 lg:py-10 md:py-7 py-5 bg-bg-light-secondary">
        <div class="container mx-auto">
            <div class=" p-6  ">
                <h2 class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-semibold text-text-secondary dark:text-text-white mb-4">
                    {{ __('Eligibility Criteria and documents required for loan approval') }}
                </h2>
                <p class="text-text-primary dark:text-text-white text-sm md:text-base mt-4">
                    {{ __('To be eligible for free shipping, your order must meet the following criteria  your order must meet the following criteria  your order must meet the following criteria  your order must meet the following criteria:') }}
                </p>
            </div>
            <div class="grid xl:grid-cols-2  gap-6">
                {{-- Eligibility Criteria --}}
                <div class="bg-bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-text-secondary/10">
                                <i class="fa-solid fa-clipboard-check text-4xl text-text-secondary"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-text-primary bg-bg-primary/50 px-4 py-2 rounded-md w-full">
                            {{ __('Eligibility Criteria') }}
                        </h3>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-primary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                01
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-primary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    <strong>{{ __('Nationality') }}</strong>: {{ __('USA') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-primary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                02
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-primary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    <strong>{{ __('Nationality') }}</strong>: {{ __('USA') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-primary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                03
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-primary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    <strong>{{ __('Nationality') }}</strong>: {{ __('USA') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-primary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                04
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-primary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    <strong>{{ __('Nationality') }}</strong>: {{ __('USA') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-primary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                05
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-primary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    <strong:>{{ __('Nationality') }}</strong: {{ __('USA') }} </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>
                {{-- Documents required --}}
                <div class="bg-bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 flex items-center justify-center rounded-full bg-text-tertiary/30">
                                <i class="fa-solid fa-file-contract text-4xl text-text-secondary"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold text-text-primary bg-bg-tertiary/50 px-4 py-2 rounded-md w-full">
                            {{ __('Documents Required') }}
                        </h3>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-tertiary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                01
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-tertiary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    {{ __('Proof of business ownership') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-tertiary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                02
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-tertiary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    {{ __('Proof of business ownership') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-tertiary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                03
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-tertiary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    {{ __('Proof of business ownership') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-tertiary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                04
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-tertiary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    {{ __('Proof of business ownership') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="flex items-center py-4">
                        <!-- Numbered circle - responsive sizing -->
                        <div class="flex items-center">
                            <span
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 z-10 rounded-full bg-bg-tertiary/80 text-text-light font-semibold text-sm sm:text-base md:text-lg">
                                05
                            </span>
                            <span class="w-6 sm:w-7 md:w-8 h-2 sm:h-3 bg-bg-tertiary/60 -ml-1"></span>
                        </div>

                        <!-- List with custom bullet styling - responsive padding and text -->
                        <ul
                            class="space-y-1 pl-2 border-2 w-full p-3 sm:p-4 md:p-5 border-black/40 rounded-xl text-xs sm:text-sm md:text-base">
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span>
                                    {{ __('Proof of business ownership') }}
                                </span>
                            </li>
                            <li class="flex items-center">
                                <i class="fa-regular fa-square text-[6px] sm:text-[7px] mx-1 sm:mx-2"></i>
                                <span class="text-text-primary/40 italic">
                                    {{ __(' Add text here') }}
                                </span>
                            </li>
                        </ul>
                    </div>


                </div>

            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        function toggleFaq(element) {
            const parent = element.closest('.faq-item');
            const answer = parent.querySelector('.faq-answer');
            const icon = element.querySelector('i');

            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            // Close all answers
            document.querySelectorAll('.faq-answer').forEach(a => {
                a.style.maxHeight = '0px';
            });

            // Reset all icons to plus
            document.querySelectorAll('.faq-question i').forEach(i => {
                i.classList.remove('fa-minus');
                i.classList.add('fa-plus');
            });

            // If not already open, open this one and switch icon
            if (!isOpen) {
                answer.style.maxHeight = answer.scrollHeight + "px";
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            const $faqItems = $('.faq-item');

            $faqItems.each(function(index) {
                const $item = $(this);
                const $button = $item.find('.faq-question');
                const $answer = $item.find('.faq-answer');
                const $faqIcon = $item.find('.faq-icon');

                $button.on('click', function() {
                    $faqItems.each(function(otherIndex) {
                        const $otherItem = $(this);
                        const $otherAnswer = $otherItem.find('.faq-answer');
                        const $otherFaqIcon = $otherItem.find('.faq-icon');

                        if (otherIndex !== index) {
                            $otherAnswer.css('max-height', '');
                            $otherItem.removeClass('pb-5');
                            $otherFaqIcon.removeClass('fa-minus text-t-primary').addClass(
                                'fa-plus');
                        }
                    });

                    if ($answer.css('max-height') !== '0px' && $answer.css('max-height') !==
                        'none') {
                        // Collapse
                        $answer.css('max-height', '');
                        $item.removeClass('pb-5');
                        $faqIcon.removeClass('fa-minus text-t-primary').addClass('fa-plus');
                    } else {
                        // Expand
                        $answer.css('max-height', $answer.prop('scrollHeight') + 20 + 'px');
                        $item.addClass('pb-5');
                        $faqIcon.removeClass('fa-plus').addClass('fa-minus text-t-primary');
                    }
                });
            });

            // Expand the first FAQ item on load
            const $firstItem = $faqItems.first();
            const $firstAnswer = $firstItem.find('.faq-answer');
            const $firstFaqIcon = $firstItem.find('.faq-icon');

            $firstAnswer.css('max-height', $firstAnswer.prop('scrollHeight') + 20 + 'px');
            $firstItem.addClass('pb-5');
            $firstFaqIcon.removeClass('fa-plus').addClass('fa-minus text-t-primary');
        });
    </script> --}}
@endpush
