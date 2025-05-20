@extends('frontend.layouts.app', ['page_slug' => 'about'])
@section('title', 'About')
@section('content')

    {{--  Hero Section --}}
    <section class="relative h-[300px] xl:h-[500px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('frontend/images/about/about-banner.jpg') }}"
                alt="Industrial machinery" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-bg-black bg-opacity-40"></div>
        </div>
        <div class="container mx-auto px-6 z-10 relative">
            <h1 class="text-text-white text-4xl md:text-5xl xl:text-6xl font-bold leading-tight max-w-2xl">
                {{ ("Connecting Africa to Japan & China's Best Machines") }}
            </h1>
        </div>
    </section>

    {{--  Our Story Section --}}
    <section class="py-10 xl:py-15 bg-bg-white dark:bg-bg-dark-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-8 text-text-dark dark:text-text-white">{{ __("Our Story") }}</h2>
            <p class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary max-w-4xl">
                {{__("Founded to bridge the gap between Africa's growing industrial needs and Asia's leading
                machinery markets, Wiz afrik has established itself as a trusted partner for African
                entrepreneurs. Our mission is to make it easier for businesses in Africa to access high-quality,
                affordable used equipment from Japan and China.")}}
            </p>
        </div>
    </section>

    {{--  What We Offer Section --}}
    <section class="py-10 xl:py-15 bg-bg-gray dark:bg-bg-dark-tertiary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">{{ __("What We Offer") }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{--  Service 1 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-full h-full">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9h10v2H7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __("Access to Japanese and Chinese Used Machines") }}</h3>
                </div>

                {{--  Service 2 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-full h-full">
                            <path
                                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h12v2H6zm0-4h12v2H6zm0 8h8v2H6z" />
                        </svg>
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __("Storage Services") }}</h3>
                </div>

                {{--  Service 3 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-full h-full">
                            <path
                                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM6 10h12v2H6zm0-4h12v2H6zm0 8h8v2H6z" />
                        </svg>
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __("Group Shipping Containers") }}</h3>
                </div>

                {{--  Service 4 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-full h-full">
                            <path
                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __("Inspection of Machines Before Shipping") }}</h3>
                </div>
            </div>
        </div>
    </section>

    {{--  Our Advantages Section --}}
    <section class="py-10 xl:py-15 bg-white dark:bg-bg-dark-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">{{ __("Our Advantages") }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __("Real videos of machines before shipment") }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __("Safe payment methods") }}</span>
                    </li>
                </ul>

                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __("Safe payment methods") }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __("Trust and transparency in all transactions") }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    {{--  Our Locations Section --}}
    <section class="py-10 xl:py-15 bg-bg-gray dark:bg-bg-dark-tertiary">
        <div class="container mx-auto px-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">{{ __("Our Locations") }}</h2>
                    <p class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary mb-6">
                       {{__(" With offices and warehouses strategically located in Japan and China, Wiz afrik
                        ensures efficient sourcing and logistics operations for all our clients across Africa.")}}
                    </p>
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('frontend/images/about/location.jpg') }}" alt="Our warehouse location" class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>
@endsection