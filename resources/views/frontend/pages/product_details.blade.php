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
    </style>
@endpush
@section('content')
    <section class="product_carousel_section py-24">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 dark:bg-bg-dark dark:text-text-light">
                {{-- Left: Image Slider --}}
                <div class="w-full">
                    {{-- Main Product Slider --}}
                    <div
                        class="swiper product_slider_image w-full h-64 sm:h-80 md:h-96 lg:h-[500px] mx-auto bg-bg-light dark:bg-bg-dark-tertiary rounded-lg overflow-hidden">
                        <div class="swiper-wrapper">
                            @for ($i = 1; $i <= 10; $i++)
                                <div class="swiper-slide flex items-center justify-center">
                                    <img src="https://swiperjs.com/demos/images/nature-{{ $i }}.jpg"
                                        class="block w-full h-full object-cover" />
                                </div>
                            @endfor
                        </div>
                        <div
                            class="swiper-button-next text-white bg-bg-dark/30 hover:bg-bg-dark/50 dark:bg-white/30 dark:hover:bg-white/50 rounded-full w-10 h-10">
                        </div>
                        <div
                            class="swiper-button-prev text-white bg-bg-dark/30 hover:bg-bg-dark/50 dark:bg-white/30 dark:hover:bg-white/50 rounded-full w-10 h-10">
                        </div>
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
                            class="flex flex-col xs:flex-row flex-wrap gap-1 sm:gap-2 border-b border-border-gray dark:border-bg-dark-secondary mb-4 sm:mb-6">
                            <button @click="tab = 'basic'"
                                :class="tab === 'basic' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Basic Info
                            </button>
                            <button @click="tab = 'airbag'"
                                :class="tab === 'airbag' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Air-bag
                            </button>
                            <button @click="tab = 'other'"
                                :class="tab === 'other' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Other Info
                            </button>
                            <button @click="tab = 'development'"
                                :class="tab === 'development' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
                                Development
                            </button>
                            <button @click="tab = 'docs'"
                                :class="tab === 'docs' ?
                                    'bg-bg-white dark:bg-bg-dark-secondary xs:border-b-2 border-primary dark:border-primary font-semibold text-text-primary dark:text-text-light' :
                                    'bg-bg-light-secondary dark:bg-bg-dark-tertiary text-text-secondary dark:text-text-secondary hover:bg-bg-light dark:hover:bg-bg-dark-secondary'"
                                class="px-3 xs:px-4 py-2 text-sm sm:text-base xs:rounded-t-md transition-colors text-left xs:text-center border-l-2 xs:border-l-0 border-primary dark:border-primary xs:border-none">
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
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold w-32 sm:w-52 py-2 sm:py-3 dark:text-text-light">Stock
                                                No.</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">No.1287864</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Maker</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">TOYOTA</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Model</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">SOARER</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Grade</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">Unknown</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Body Type</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">Open</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">First Registration
                                            </td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">03/1987</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Displacement</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">2950 cc</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Engine Type</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">7M</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Fuel</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">Gasoline</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Mileage</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">79540 km</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Color</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">White</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Drive System</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">2WD</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Transmission</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">AT</td>
                                        </tr>
                                        <tr class="border-t border-border-gray dark:border-bg-dark-secondary">
                                            <td class="font-semibold py-2 sm:py-3 dark:text-text-light">Capacity</td>
                                            <td class="py-2 sm:py-3 dark:text-text-secondary">5</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Airbag Info -->
                            <div x-show="tab === 'airbag'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">No airbag data available.
                                </p>
                            </div>

                            <!-- Other Info -->
                            <div x-show="tab === 'other'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">No additional information
                                    provided.</p>
                            </div>

                            <!-- Development -->
                            <div x-show="tab === 'development'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">Development info not
                                    available.</p>
                            </div>

                            <!-- Attached Document -->
                            <div x-show="tab === 'docs'" x-cloak>
                                <p class="text-text-secondary dark:text-text-secondary text-lg">No documents attached.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- Alpine.js for tab switching -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- SwiperJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleryThumbs = new Swiper('.product_slider_thumbs', {
                spaceBetween: 8,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                breakpoints: {
                    480: {
                        slidesPerView: 6
                    },
                    768: {
                        slidesPerView: 8
                    }
                }
            });

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
