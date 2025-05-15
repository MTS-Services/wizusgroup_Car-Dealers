<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html" class="{{ session('theme', 'light') }}"
    data-theme="{{ session('theme', 'light') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Swiper’s Zoom  --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" /> --}}
    <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @section('title')
            {{ isset($title) ? $title : '' }}
        @show
        @if (!empty(trim($__env->yieldContent('title'))))
            {{ __(' - ') }}
        @endif
        {{ config('app.name', 'Ecommerce') }}
    </title>

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper.min.css') }}">

    {{-- BoxIcons --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" /> --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/frontend/frontend.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                showAlert('warning', '{{ session('warning') }}');
            @endif
        });
    </script>

    {{-- Custom CSS --}}
    @stack('css')

</head>

<body>

    {{-- ============================== Layouts ============================== --}}

    <!-- Custom Cursor -->
    <div class="cursor-wrapper">
        <div class="custom-cursor"></div>
    </div>

    {{-- User Login --}}

    {{-- Temporary Includes --}}
    @include('frontend.includes.login')


    {{-- Header --}}
    @include('frontend.layouts.partials.header')

    {{-- SideBar --}}
    @include('frontend.layouts.partials.sidebar')

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.partials.footer')

    {{-- ============================== End of Layouts ============================== --}}

    {{-- Jquery --}}
    <script src="{{ asset('frontend/js/jQuery.js') }}"></script>
    {{-- Swiper JS --}}
    <script src="{{ asset('frontend/js/swiper.min.js') }}" type="module"></script>
    {{-- Lucide Icons --}}
    <script src="{{ asset('frontend/js/lucideIcon.js') }}"></script>
    <script>
        lucide.createIcons();
    </script>

    {{-- Toggle theme --}}
    <script src="{{ asset('frontend/js/themeToggle.js') }}"></script>

    {{-- Custom Cursor --}}
    {{-- <script src="{{ asset('frontend/js/customCursor.js') }}" type="module"></script> --}}
    <script>
        $(document).ready(function() {
            const $cursorWrapper = $('.cursor-wrapper');
            const $cursor = $('.custom-cursor');

            $cursorWrapper.css('transform', 'translate(-100%, -100%)');

            // Move the wrapper with the mouse
            $(document).on('mousemove', function(e) {
                const x = e.clientX;
                const y = e.clientY;
                $cursorWrapper.css('transform', `translate(${x}px, ${y}px) translate(-50%, -50%)`);

                // Randomly create stars (less frequent)
                // if (Math.random() < 0.3) {
                //     createStarTopLeft(x, y);
                // }
            });

            // Add animation on click
            $(document).on('mousedown', function() {
                $cursor.addClass('click');
            });

            $(document).on('mouseup', function() {
                $cursor.removeClass('click');
            });

            // Add pulsing effect when hovering over buttons and links
            $('a, button').hover(
                function() {
                    $cursor.addClass('animate-scalePulse');
                },
                function() {
                    $cursor.removeClass('animate-scalePulse');
                }
            );

            // Create colorful stars rising from the top-left corner of the circle
            // function createStarTopLeft(x, y) {
            //     const $star = $('<div class="star"></div>');

            //     // Add random colors
            //     const colors = ['#FF5733', '#33FF57', '#5733FF', '#FFFF33', '#33FFFF'];
            //     const color = colors[Math.floor(Math.random() * colors.length)];
            //     $star.css('background', `radial-gradient(circle, ${color}, transparent)`);

            //     // Position the star
            //     const offsetX = -10;
            //     const offsetY = -10;
            //     $star.css({
            //         position: 'absolute',
            //         left: `${x + offsetX}px`,
            //         top: `${y + offsetY}px`,
            //     });

            //     // Append to body and remove after animation
            //     $('body').append($star);
            //     $star.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function() {
            //         $(this).remove();
            //     });
            // }
        });
    </script>

    {{-- Side Bar --}}
    <script src="{{ asset('frontend/js/sidebar.js') }}"></script>

    {{-- Toggle search form --}}
    <script src="{{ asset('frontend/js/toggleSearchForm.js') }}"></script>


    {{-- Hide or Show Swiper Navigation Buttons Controller --}}
    <script>
        function hideControlsIfNotEnoughSlides(swiperEl, swiperInstance, getSlidesPerView = 1) {
            const originalSlides = swiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)');
            const realSlideCount = originalSlides.length;

            // Determine current slidesPerView
            let currentSlidesPerView = typeof getSlidesPerView === 'function' ? getSlidesPerView() : getSlidesPerView;

            if (realSlideCount <= currentSlidesPerView) {
                const navNext = swiperEl.querySelector('.swiper-button-next');
                const navPrev = swiperEl.querySelector('.swiper-button-prev');
                const pagination = swiperEl.querySelector('.swiper-pagination');

                if (navNext) navNext.style.display = 'none';
                if (navPrev) navPrev.style.display = 'none';
                if (pagination) pagination.style.display = 'none';
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            const $openSidebar = $('.openCartSidebar');
            const $closeSidebar = $('.closeCartSidebar');
            const $sidebar = $('.cartSidebar'); // Select the sidebar element globally

            // Sidebar open functionality
            $openSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
                // $(this).addClass('hidden'); // Hide the open button
            });

            $closeSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(100%)'); // Hide the sidebar
                setTimeout(() => {
                    // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
                }, 300); // Delay for the sidebar transition
            });
        });
    </script>


    {{-- Custom JS --}}
    @stack('js')
</body>

</html>
