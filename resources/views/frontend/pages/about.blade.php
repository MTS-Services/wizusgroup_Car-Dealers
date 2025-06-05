@extends('frontend.layouts.app', ['page_slug' => 'about'])
@section('title', 'About')
@section('content')

    {{--  Hero Section --}}
    <section class="relative h-[300px] xl:h-[500px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('frontend/images/about/industrial-container-cargo-freight-ship-habor-logistic-import-export.jpg') }}"
                alt="Industrial machinery" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-bg-black bg-opacity-40"></div>
        </div>
        <div class="container mx-auto px-6 z-10 relative">
            <h1 class="text-text-white text-4xl md:text-5xl xl:text-6xl font-bold leading-tight max-w-2xl">
                {{ __("Connecting Africa to Japan & China's Best Machines") }}
            </h1>
        </div>
    </section>

    {{--  Our Story Section --}}
    <section class="py-10 xl:py-15 bg-bg-white dark:bg-bg-dark-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-8 text-text-dark dark:text-text-white">
                {{ __('Our Story') }}</h2>
            <p class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary max-w-4xl">
                {{ __("Founded to bridge the gap between Africa's growing industrial needs and Asia's leading machinery markets, Wiz afrik has established itself as a trusted partner for African entrepreneurs. Our mission is to make it easier for businesses in Africa to access high-quality, affordable used equipment from Japan and China.") }}
            </p>
        </div>
    </section>

    {{--  What We Offer Section --}}
    <section class="py-10 xl:py-15 bg-bg-gray dark:bg-bg-dark-tertiary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">
                {{ __('What We Offer') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{--  Service 1 --}}
                <div class="flex flex-col items-center text-center border-2 dark:border-border-dark p-7 rounded-xl ">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <img src="{{ asset('frontend/images/about/tractor (1).png') }}" alt="">
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">
                        {{ __('Access to Japanese and Chinese Used Machines') }}</h3>
                    <p class="text-muted-text">
                        {{ __('We provide you with direct access to a wide selection of high-quality, pre-owned machines from trusted suppliers in Japan and China.') }}
                    </p>
                </div>

                {{--  Service 2 --}}
                <div class="flex flex-col items-center text-center border-2 dark:border-border-dark p-7 rounded-xl">
                    <div class="relative w-24 h-24 mb-6 text-text-orange dark:shadow-lg">
                        <!-- Overlay -->
                        {{-- <div class="absolute inset-0 bg-white/30 dark:bg-white/30 rounded"></div> --}}
                        <!-- Image -->
                        <img src="{{ asset('frontend/images/about/storage.png') }}" alt=""
                            class="w-full h-full object-cover rounded">
                    </div>

                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __('Storage Services') }}</h3>
                    <p class="text-muted-text">
                        {{ __('Need time before shipping or consolidating purchases? We offer secure, short- and long-term storage options in Japan and China.') }}
                    </p>
                </div>

                {{--  Service 3 --}}
                <div class="flex flex-col items-center text-center border-2 dark:border-border-dark p-7 rounded-xl">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <img src="{{ asset('frontend/images/about/groupshipping.png') }}" alt="">
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __('Group Shipping Containers') }}</h3>
                    <p class="text-muted-text">
                        {{ __('Cut costs and save space with our container consolidation service. We combine multiple machines into one shipment for better value.') }}
                    </p>
                </div>

                {{--  Service 4 --}}
                <div class="flex flex-col items-center text-center border-2 dark:border-border-dark p-7 rounded-xl">
                    <div class="w-24 h-24 mb-6 text-text-orange">
                        <img src="{{ asset('frontend/images/about/search.png') }}" alt="">
                    </div>
                    <h3 class="text-lg xl:text-xl font-semibold mb-2">{{ __('Inspection of Machines Before Shipping') }}
                    </h3>
                    <p class="text-muted-text">
                        {{ __("We conduct detailed inspections of every machine before it's shipped, giving you peace of mind and reducing post-delivery surprises.") }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{--  Our Advantages Section --}}
    <section class="py-10 xl:py-15 bg-white dark:bg-bg-dark-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">
                {{ __('Our Advantages') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span
                            class="text-sm md:text-base xl:text-lg">{{ __('Real videos of machines before shipment') }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __('Safe payment methods') }}</span>
                    </li>
                </ul>

                <ul class="space-y-4">
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span class="text-sm md:text-base xl:text-lg">{{ __('Safe payment methods') }}</span>
                    </li>
                    <li class="flex items-center">
                        <span class="bg-bg-orange mr-2 h-2 w-2 rounded-full"></span>
                        <span
                            class="text-sm md:text-base xl:text-lg">{{ __('Trust and transparency in all transactions') }}</span>
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
                    <h2
                        class="text-2xl md:text-3xl xl:text-4xl font-bold mb-6 xl:mb-12 text-text-dark dark:text-text-white">
                        {{ __('Our Locations') }}</h2>
                    <p class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary mb-6">
                        {{ __('With offices and warehouses strategically located in Japan and China, Wiz afrik ensures efficient sourcing and logistics operations for all our clients across Africa.') }}
                    </p>
                </div>

                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('frontend/images/about/location.jpg') }}" alt="Our warehouse location"
                        class="w-full h-auto">
                </div>
            </div>
        </div>
    </section>
@endsection
