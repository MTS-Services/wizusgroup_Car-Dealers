@extends('frontend.layouts.app', ['page_slug' => 'product_details'])

@section('title', 'Products Details')
@push('css')
    <style>
        .product_carousel_section .product_slider_thumbs .swiper-slide {
            opacity: 0.6;
        }

        .product_carousel_section .product_slider_thumbs .swiper-slide-thumb-active {
            opacity: 1;
        }

        .hover-wrapper:hover #zoomResult {
            display: block;
        }

        #lens {
            position: absolute;
            border: 2px solid rgba(52, 158, 226, 0.8);
            z-index: 100;
            pointer-events: none;
            display: none;
            /* No fixed width/height here — JS will handle it */
        }

        #zoomResult {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 20px;
            width: 300px;
            height: 300px;
            background-repeat: no-repeat;
            background-size: 200%;
            /* To ensure zooming effect */
            z-index: 99;
            background-color: #fff;
            border: 1px solid #ddd;
            /* Optional: border to see the zoom area */
        }
    </style>
@endpush
@section('content')
    {{-- ===================== Product Carousel Section Start ===================== --}}
    <section class="product_carousel_section py-24">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 dark:bg-bg-dark dark:text-text-light">
                {{-- Left: Image Slider --}}
                <div class="w-full">
                    {{-- Main Product Slider --}}
                    <div class="relative hover-wrapper">
                        <div
                            class="swiper static product_slider_image w-full h-64 sm:h-80 md:h-96 lg:h-[500px] mx-auto bg-bg-light dark:bg-bg-dark-tertiary rounded-lg overflow-hidden">
                            <div class="swiper-wrapper">
                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="swiper-slide flex items-center justify-center">
                                        <img src="https://swiperjs.com/demos/images/nature-{{ $i }}.jpg"
                                            class="zoomable block w-full h-full object-cover" />
                                    </div>
                                @endfor
                            </div>
                            <div class="swiper-button swiper-button-prev ">
                                <i data-lucide="chevron-left" class="w-5 h-5 text-blue-800"></i>
                            </div>
                            <div class="swiper-button swiper-button-next  ">
                                <i data-lucide="chevron-right" class="w-5 h-5 text-blue-800"></i>
                            </div>

                        </div>
                        <div id="zoomResult"></div>
                        <div id="lens"></div>
                    </div>

                    {{-- Thumbnail Slider --}}
                    <div
                        class="swiper product_slider_thumbs h-16 sm:h-20 mt-2 box-border py-1 px-2 bg-bg-light dark:bg-bg-dark-tertiary rounded-lg">
                        <div class="swiper-wrapper">
                            @for ($i = 1; $i <= 10; $i++)
                                <div
                                    class="swiper-slide w-1/5 sm:w-1/6 md:w-1/8 h-full opacity-40 transition-opacity duration-300 cursor-pointer hover:opacity-70 swiper-slide-thumb-active:opacity-100 dark:swiper-slide-thumb-active:opacity-100">
                                    <img src="https://swiperjs.com/demos/images/nature-{{ $i }}.jpg"
                                        class="block w-full h-full object-cover rounded" />
                                </div>
                            @endfor
                        </div>

                    </div>
                </div>

                {{-- Right: Product Info --}}
                <div class="w-full">
                    <div class="mx-auto" x-data="{ tab: 'basic' }">
                        <!-- Tabs - Responsive layout -->
                        <div
                            class="flex flex-col xs:flex-row flex-wrap gap-1 2xl:justify-between sm:gap-2 border-b border-border-gray dark:border-bg-dark-secondary mb-4 sm:mb-6">
                            <button @click="tab = 'basic'"
                                :class="tab === 'basic' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Basic Info
                            </button>
                            <button @click="tab = 'airbag'"
                                :class="tab === 'airbag' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Air-bag
                            </button>
                            <button @click="tab = 'other'"
                                :class="tab === 'other' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Other Info
                            </button>
                            <button @click="tab = 'development'"
                                :class="tab === 'development' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Development
                            </button>
                            <button @click="tab = 'docs'"
                                :class="tab === 'docs' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 xl:px-6 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Documents
                            </button>
                        </div>

                        <!-- Tab Content -->
                        <div
                            class="bg-bg-white dark:bg-bg-tertiary/25 shadow-card dark:shadow-none p-4 sm:p-6 rounded-b-lg border border-border-gray dark:border-bg-dark-secondary">

                            <!-- Basic Info -->
                            <div x-show="tab === 'basic'" x-cloak>
                                <table class="w-full table-auto text-sm sm:text-base">
                                    <tbody>
                                        <tr class=" border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Stock No.') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('No.1287864') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Maker') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('TOYOTA') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Model') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('SOARER') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Grade') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('Unknown') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Body Type') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('Open') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('First Registration') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('03/1987') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Displacement') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('2950 cc') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Engine Type') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('7M') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Fuel') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('Gasoline') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Mileage') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('79540 km') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">{{ __('Color') }}
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('White') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Drive System') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('2WD') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Transmission') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('AT') }}</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">
                                                {{ __('Capacity') }}</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">{{ __('5') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Airbag Info -->
                            <div x-show="tab === 'airbag'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">
                                    {{ __('No airbag data available.') }}</p>
                            </div>

                            <!-- Other Info -->
                            <div x-show="tab === 'other'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">
                                    {{ __('No additional information provided.') }}</p>
                            </div>

                            <!-- Development -->
                            <div x-show="tab === 'development'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">
                                    {{ __('Development info not available.') }}</p>
                            </div>

                            <!-- Attached Document -->
                            <div x-show="tab === 'docs'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">
                                    {{ __('No documents attached.') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ===================== End Product Details Section ===================== --}}
    {{-- ===================== Releted Product Section ===================== --}}

    <section class="py-24">
        <div class="container">
            <div class="header bg-bg-primary mb-2 py-4 pl-4">
                <h2 class="text-2xl font-bold text-text-white ">{{ __('Related Products') }}</h2>
            </div>
            <div class="relative">
                {{-- Product 1 --}}
                <div class="swiper related_product static">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
                                data-product="1">
                                <div class="max-h-80 w-full overflow-hidden">
                                    <img src="{{ asset('frontend/images/products/tractor-2.avif') }}"
                                        alt="{{ __('Kubota ZL1-215') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
                                </div>
                                <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
                                    <h3
                                        class="text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                                        {{ __('Kubota ZL1-215') }}
                                    </h3>
                                    <p class="text-xl font-bold text-text-danger">{{ __('$3,500') }}</p>
                                    <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                                        <span>{{ __('2001') }}</span>
                                        <span class="mx-2">|</span>
                                        <span>{{ __('Osaka') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Repeat swiper-slide for other products -->
                    </div>

                    <!-- Optional controls -->
                    <div class="swiper-pagination !-bottom-10"></div>
                    <!-- Navigation buttons -->
                    <div class="swiper-button swiper-button-prev 3xl:-left-13 2xl:-left-9">
                        <i data-lucide="chevron-left" class="w-5 h-5 text-blue-800"></i>
                    </div>
                    <div class="swiper-button swiper-button-next 3xl:-right-13 2xl:-right-9 ">
                        <i data-lucide="chevron-right" class="w-5 h-5 text-blue-800"></i>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('js')
    <!-- Alpine.js for tab switching -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Initialize Swiper JS -->
    <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize thumbnail Swiper
            const galleryThumbs = new Swiper('.product_slider_thumbs', {
                spaceBetween: 8,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesProgress: true,
                watchSlidesVisibility: true,
                breakpoints: {
                    480: {
                        slidesPerView: 6
                    },
                    768: {
                        slidesPerView: 8
                    }
                }
            });

            // Initialize main image Swiper
            const galleryTop = new Swiper('.product_slider_image', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: galleryThumbs
                }
            });

            // Zoom functionality
            const zoomResult = document.getElementById("zoomResult");
            const lens = document.getElementById("lens");

            // Re-attach zoom logic every time slide changes
            function attachZoom() {
                document.querySelectorAll('.zoomable').forEach(img => {
                    img.addEventListener('mousemove', function(e) {
                        const rect = img.getBoundingClientRect();
                        const wrapperRect = img.closest('.hover-wrapper').getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const zoomFactor = 2; // You can adjust this
                        const resultWidth = zoomResult.offsetWidth;
                        const resultHeight = zoomResult.offsetHeight;

                        zoomResult.style.backgroundImage = `url('${img.src}')`;
                        zoomResult.style.backgroundSize =
                            `${rect.width * zoomFactor}px ${rect.height * zoomFactor}px`;
                        zoomResult.style.backgroundPosition =
                            `-${x * zoomFactor - resultWidth / 2}px -${y * zoomFactor - resultHeight / 2}px`;

                        lens.style.display = 'block';
                        lens.style.width = `100px`;
                        lens.style.height = `100px`;
                        lens.style.left = `${e.clientX - wrapperRect.left - 50}px`;
                        lens.style.top = `${e.clientY - wrapperRect.top - 50}px`;

                        zoomResult.style.display = 'block';
                    });

                    img.addEventListener('mouseenter', function() {
                        zoomResult.style.display = 'block';
                        lens.style.display = 'block';
                    });

                    img.addEventListener('mouseleave', function() {
                        zoomResult.style.display = 'none';
                        lens.style.display = 'none';
                        zoomResult.style.backgroundImage = '';
                    });
                });
            }

            // Initial attach
            attachZoom();

            // Optional: Re-attach on slide change to ensure only current image responds
            galleryTop.on('slideChangeTransitionEnd', () => {
                attachZoom(); // Refresh listeners if needed
            });
        });



        const swiper = new Swiper(".related_product", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 6,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
                1536: {
                    slidesPerView: 6,
                },
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>

    {{-- <script type="module">
        import Swiper from '/frontend/js/swiper.min.js';
        // Initialize Swiper
        const swiperThumbs = new Swiper(".product_slider_thumbs", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 6,
            freeMode: true,
            watchSlidesProgress: true,
        });

        const swiperMain = new Swiper(".product_slider_image", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });
    </script> --}}
@endpush
