@extends('frontend.layouts.app', ['page_slug' => 'about'])
@section('title', 'About')
@section('content')

    <!-- Hero Section -->
    <section class="relative h-[200px] xl:h-[300px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('frontend/images/about/industrial-container-cargo-freight-ship-habor-logistic-import-export.jpg') }}"
                alt="Industrial machinery" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-bg-black bg-opacity-40"></div>
        </div>
        <div class="container mx-auto px-6 z-10 relative">
            <div class="animate-fade-in-up">
                <h1
                    class="text-text-white text-4xl md:text-5xl xl:text-6xl font-bold leading-tight max-w-2xl tracking-tight">
                    {{ __('About Wiz Global') }}
                </h1>
            </div>
        </div>
    </section>

    <!-- Company Description -->
    <section class="py-10 xl:py-15 bg-bg-white dark:bg-bg-dark-secondary relative overflow-hidden">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 0); background-size: 32px 32px;">
            </div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="space-y-8">
                    <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
                    <p
                        class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary leading-relaxed">
                        {!! __(
                            "WizGlobalMachineries is a Japan-based export company connecting the world with Japan's best machinery and vehicles. <br><br> We specialize in used cars, agricultural and construction machinery, motorcycles, spare parts, and accessories. Every product is inspected before export and shipped with full documentation.",
                        ) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-10 xl:py-15 bg-bg-gray dark:bg-bg-dark-tertiary">
        <div class="container mx-auto px-6">
            <div class="max-w-6xl mx-auto">

                <!-- Mission -->
                <div class="mb-16 xl:mb-20">
                    <div class="group hover:transform hover:scale-[1.02] transition-all duration-300">
                        <div
                            class="bg-bg-white dark:bg-bg-dark-secondary rounded-2xl p-8 xl:p-12 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-800">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-12">
                                <div class="lg:w-1/3 mb-6 lg:mb-0">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                            <div class="w-6 h-6 bg-primary rounded-full"></div>
                                        </div>
                                        <div class="w-20 h-1 bg-primary rounded-full"></div>
                                    </div>
                                    <h2
                                        class="text-2xl md:text-3xl xl:text-4xl font-bold text-text-dark dark:text-text-white">
                                        {{ __('Our Mission') }}
                                    </h2>
                                </div>
                                <div class="lg:w-2/3">
                                    <p
                                        class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary leading-relaxed">
                                        {{ __('To provide accessible and affordable machinery and automotive solutions to individuals, businesses, and communities in developing and emerging regions.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision -->
                <div>
                    <div class="group hover:transform hover:scale-[1.02] transition-all duration-300">
                        <div
                            class="bg-bg-white dark:bg-bg-dark-secondary rounded-2xl p-8 xl:p-12 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-800">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:space-x-12">
                                <div class="lg:w-1/3 mb-6 lg:mb-0">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <div
                                            class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center">
                                            <div class="w-6 h-6 bg-secondary rounded-full"></div>
                                        </div>
                                        <div class="w-20 h-1 bg-secondary rounded-full"></div>
                                    </div>
                                    <h2
                                        class="text-2xl md:text-3xl xl:text-4xl font-bold text-text-dark dark:text-text-white">
                                        {{ __('Our Vision') }}
                                    </h2>
                                </div>
                                <div class="lg:w-2/3">
                                    <p
                                        class="text-sm md:text-base xl:text-lg text-text-gray dark:text-text-light-secondary leading-relaxed">
                                        {{ __('To be the most trusted source for machinery and vehicle exports from Japan to the world, especially Africa.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }
    </style>

@endsection
