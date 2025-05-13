@extends('frontend.layouts.app', ['page_slug' => 'home'])

@section('title', 'Home')

@php
    $banners = \App\Models\Banner::all();
@endphp

@section('content')
    {{-- ===================== banner Section ===================== --}}
    <section class="swiper banner bg-bg-gray dark:bg-bg-darkSecondary dark:bg-opacity-70 ">
        <div class="swiper-wrapper relative">
            @foreach ($banners as $banner)
                <div class="swiper-slide group/banner">
                    <div class="lg:container {{ $loop->iteration % 2 == 0 ? 'pl-0 pr-4 lg:p-4' : 'pr-0 pl-4 lg:p-4' }}">
                        <div
                            class="item flex {{ $loop->iteration % 2 == 0 ? 'flex-row-reverse' : 'flex-row' }} items-center justify-between relative overflow-hidden min-h-80 lg:min-h-96 2xl:min-h-[500px]">
                            <div
                                class="w-full md:basis-1/2 relative z-[2] {{ $loop->iteration % 2 == 0 ? 'flex flex-col items-end text-end' : '' }}">
                                <p class="text-xs md:text-base">{{ $banner['title'] }}</p>
                                <h2 class="sm:text-xl text-lg lg:text-2xl xl:text-6xl md:py-4 py-1 max-w-80">
                                    {{ $banner['subtitle'] }}
                                </h2>
                                <a href="#" class="btn-primary">{{ __('Shop Now') }} <i
                                        data-lucide="chevron-right"></i></i></a>
                            </div>
                            <div
                                class="md:basis-1/2 md:relative absolute z-[1] w-64 top-1/2 md:top-0 -translate-y-1/2 md:translate-y-0 {{ $loop->iteration % 2 == 0 ? '-left-1/3 md:left-0' : '-right-1/3 sm:-right-1/4 md:right-0 flex items-center justify-end' }}">
                                <img src="{{ $banner->modified_image }}" alt="{{ $banner->title }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination z-10 hiddin lg:block"></div>
        <!-- Navigation buttons -->
        <div class="hidden lg:block">
            <div class="swiper-button swiper-button-prev hidden lg:block">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </div>

            <div class="swiper-button swiper-button-next hidden lg:block">
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </div>
        </div>
    </section>

@endsection


@push('js')
    <script>
        import Swiper from '/frontend/js/swiper.min.js';

        // Banner Slider
        const bannerEl = document.querySelector('.banner');
        new Swiper(bannerEl, {
            slidesPerView: 1,
            loop: true,
            // autoplay: {
            //     delay: 5000,
            //     disableOnInteraction: false,
            // },
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            on: {
                init: function() {
                    hideControlsIfNotEnoughSlides(bannerEl, this, 1);
                }
            }
        });
    </script>
@endpush
