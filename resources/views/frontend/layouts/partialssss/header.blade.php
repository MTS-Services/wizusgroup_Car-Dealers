<header class="bg-bg-white dark:bg-bg-darkTertiary">
    <div class="container">
        <div class="navbar">
            <div class="navbar-start hidden lg:flex">
                <x-frontend.theme />
                <x-frontend.language />

            </div>
            <div class="navbar-start lg:navbar-center">
                <a href="{{ url('/') }}" class="w-fit lg:mx-auto">
                    <span class="dark-mode-logo hidden">
                        <img src="{{ asset('frontend/images/logo-light.png') }}" alt="Logo">
                    </span>
                    <span class="light-mode-logo">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                    </span>
                </a>
            </div>

            <div class="navbar-end">
                <div class="flex items-center justify-center gap-3">

                    <span class="hidden lg:flex">
                        <x-frontend.search />
                    </span>

                    <a href="javaScript:void(0)" class="text-2xl">
                        <i data-lucide="user-round"
                            class="text-text-primary dark:text-text-white hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"
                            onclick="my_modal_1.showModal()"></i>
                    </a>
                    <a href="" class="text-2xl relative">
                        <i data-lucide="heart"
                            class="text-text-primary dark:text-text-white hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"></i>
                        <span
                            class="text-text-white text-xs absolute -top-2 -right-2 z-10 bg-bg-secondary w-4 h-4 rounded-full flex items-center justify-center">{{ __('2') }}</span>
                    </a>
                    <a href="javaScript:void(0)" class="openCartSidebar text-2xl relative">
                        <i data-lucide="shopping-basket"
                            class="text-text-primary dark:text-text-white  hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"></i>
                        <span
                            class="text-text-white text-xs absolute -top-2 -right-2 z-10 bg-bg-secondary w-4 h-4 rounded-full flex items-center justify-center">{{ __('2') }}</span>
                    </a>

                    <button class="openSidebar text-2xl lg:hidden" title="Open Sidebar">
                        <i data-lucide="menu"
                            class="text-text-primary dark:text-text-white hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="w-full h-0.5 bg-gradient-light my-2 hidden lg:block"></div>

        <div class="items-center justify-center gap-5 pb-4 hidden lg:flex">
            <div class="flex items-center justify-center gap-5 pb-4">
                <a href="{{ url('/') }}"
                    class="capitalize text-text-primary dark:text-text-white relative
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'home') after:w-full @else after:w-0 @endif">
                    {{ __('Home') }}
                </a>
                <a href=""
                    class="capitalize text-text-primary dark:text-text-white relative
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'shop') after:w-full @else after:w-0 @endif">
                    {{ __('Shop') }}
                </a>
                <a href=""
                    class="capitalize text-text-primary dark:text-text-white relative
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'store_location') after:w-full @else after:w-0 @endif">
                    {{ __('Store location') }}
                </a>
                <a href="#"
                    class="capitalize text-text-primary dark:text-text-white relative
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'contact') after:w-full @else after:w-0 @endif">
                    {{ __('Contact') }}
                </a>
                <a href=""
                    class="capitalize text-text-primary dark:text-text-white relative
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'faq') after:w-full @else after:w-0 @endif">
                    {{ __('Faq') }}
                </a>
            </div>
        </div>
</header>


<script>
    function toggleSearch() {
        const form = document.getElementById('searchForm');
        form.classList.toggle('opacity-0');
        form.classList.toggle('pointer-events-none');
        form.classList.toggle('scale-95');
        form.classList.toggle('scale-100');
        form.classList.toggle('opacity-100');
    }
</script>
