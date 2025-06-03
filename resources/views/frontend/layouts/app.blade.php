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

    {{-- fontAwesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

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
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    {{-- BoxIcons --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" /> --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/frontend.css', 'resources/js/frontend/frontend.js'])
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

    <style>
        #toast-container {
            z-index: 99999999999 !important;
        }
    </style>


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

    {{-- <script src="{{ asset('frontend/js/custom.js') }}"></script> --}}
    {{-- Toggle theme --}}
    <script src="{{ asset('frontend/js/themeToggle.js') }}"></script>

    {{-- Custom Functions --}}
    <script src="{{ asset('backend/admin/js/functions.js') }}"></script>

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
    {{-- Cart Sidebar --}}
    <script src="{{ asset('frontend/js/cartSidebar.js') }}"></script>
    {{-- Cart Page js --}}
    <script>
        // Cart data
        const cartItems = [{
                id: 1,
                name: '	Mahindra 575 DI Tractor',
                variant: 'Mahindra / 575 DI',
                price: 100.00,
                quantity: 1,
                image: '{{ asset('frontend/images/products/TAFE-IMT-tractor.png') }}'
            },
            {
                id: 2,
                name: 'New Holland 3630 TX Plus Super Tractor',
                variant: 'New Holland / 3630 TX Plus',
                price: 120.00,
                quantity: 1,
                image: '{{ asset('frontend/images/products/tractor-2.avif') }}'
            }
        ];

        // Render cart items
        function renderCartItems() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';

            cartItems.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'border-b border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50';
                row.innerHTML = `
                <td class="py-4">
                    <div class="flex items-center">
                        <img src="${item.image}" alt="${item.name}" class="w-20 h-24 object-cover mr-4">
                        <div>
                            <h3 class="font-medium">${item.name}</h3>
                            <p class="text-sm text-text-gray">${item.variant}</p>
                            <button class="text-sm text-text-gray mt-1 remove-item hover:text-text-danger hover:underline transition-all duration-300" data-id="${item.id}">Remove</button>
                        </div>
                    </div>
                </td>
                <td class="py-4">$${item.price.toFixed(2)}</td>
                <td class="py-4">
                    <div class="flex items-center shadow-sm rounded-full w-24 p-1 bg-bg-primary bg-opacity-60 dark:bg-opacity-50 text-text-white">
                        <button class=" px-2 py-1 decrease-quantity" data-id="${item.id}">-</button>
                        <input type="text" value="${item.quantity}" class="p-0 w-8 h-4 text-center border-x bg-transparent" readonly>
                        <button class="px-2 py-1 increase-quantity" data-id="${item.id}">+</button>
                    </div>
                </td>
                <td class="py-4">$${(item.price * item.quantity).toFixed(2)}</td>
            `;
                cartItemsContainer.appendChild(row);
            });
            
            updateCartTotal();
        }
        // Render cart items
        function renderCheckoutCartItems() {
            const checkoutCartItemsContainer = document.getElementById('checkout-cart-items');
            checkoutCartItemsContainer.innerHTML = '';

            cartItems.forEach(item => {
                const div = document.createElement('div');
                div.className =
                    'flex gap-3 p-2 mt-3 bg-bg-gray dark:bg-bg-darkSecondary rounded-md shadow-card mx-5';
                div.innerHTML = `
                <div class="w-[25%] h-full shrink-0 rounded-sm overflow-hidden">
                    <img src="${item.image}" class="w-24 h-full object-cover mr-5" alt="${item.name}">
                </div>
                <div class="w-[75%] flex flex-col">
                    <div class="flex justify-between items-center">
                        <h4 class="text-md font-medium">${item.name}</h4>
                        <p class="remove-item hover:text-text-danger" data-id="${item.id}"><i data-lucide="x" class="text-sm"></i></p>
                    </div>
                    <p class="text-sm mt-2">${item.variant}</p>
                    
                </div>
            </div>
            `;
                checkoutCartItemsContainer.appendChild(div);
            });

            // Add event listeners
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    removeItem(itemId);
                });
            });

            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    updateQuantity(itemId, -1);
                });
            });

            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = parseInt(this.getAttribute('data-id'));
                    updateQuantity(itemId, 1);
                });
            });

            updateCartTotal();
        }

        // Remove item from cart
        function removeItem(itemId) {
            const index = cartItems.findIndex(item => item.id === itemId);
            if (index !== -1) {
                cartItems.splice(index, 1);
                renderCartItems();
                renderCheckoutCartItems();
            }
        }

        // Update item quantity
        function updateQuantity(itemId, change) {
            const item = cartItems.find(item => item.id === itemId);
            if (item) {
                const newQuantity = item.quantity + change;
                if (newQuantity > 0) {
                    item.quantity = newQuantity;
                    renderCartItems();
                    renderCheckoutCartItems();
                }
            }
        }

        // Update cart total
        function updateCartTotal() {
            const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.querySelectorAll('.cart-total').forEach(totalValue => {
                totalValue.textContent = `$${total.toFixed(2)} USD`;
            });
        }


        // Initialize cart
        document.addEventListener('DOMContentLoaded', function() {
            renderCartItems();
            renderCheckoutCartItems();
        });
    </script>

    {{-- Toggle search form --}}
    <script src="{{ asset('frontend/js/toggleSearchForm.js') }}"></script>


    {{-- Hide or Show Swiper Navigation Buttons Controller --}}
    <script>
        function hideControlsIfNotEnoughSlides(swiperEl, swiperInstance, getSlidesPerView = 1) {
            const originalSlides = swiperEl.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)');
            const realSlideCount = originalSlides.length;

            // Determine current slidesPerView
            let currentSlidesPerView = typeof getSlidesPerView === 'function' ? getSlidesPerView() : getSlidesPerView;

            const swiperWrapper = swiperEl.querySelector('.swiper-wrapper');
            const navNext = swiperEl.querySelector('.swiper-button-next');
            const navPrev = swiperEl.querySelector('.swiper-button-prev');
            const pagination = swiperEl.querySelector('.swiper-pagination');

            if (realSlideCount <= currentSlidesPerView) {
                if (navNext) navNext.style.display = 'none';
                if (navPrev) navPrev.style.display = 'none';
                if (pagination) pagination.style.display = 'none';
                if (swiperWrapper) swiperWrapper.classList.add('justify-center');
            } else {
                if (swiperWrapper) swiperWrapper.classList.remove('justify-center');
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
