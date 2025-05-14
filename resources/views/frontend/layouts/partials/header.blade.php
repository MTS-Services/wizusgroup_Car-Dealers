<header class="bg-bg-white dark:bg-bg-dark">
    <div class="container">
        <div class="navbar">
            <div class="navbar-start">
                <a href="" class=""><img src="{{ asset('frontend/images/logo.png') }}" alt="Logo"
                        class="w-28"></a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <div class="flex items-center justify-center gap-2">
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ url('/') }}">{{ __('Home') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="">{{ __('About Us') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.product') }}">{{ __('Products') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="#">{{ __('Auctions') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.contact') }}">{{ __('Contact') }}</a>
                </div>
            </div>
            <div class="navbar-end flex items-center justify-end gap-3">
                <span class="hidden lg:flex">
                    <x-frontend.language />
                </span>
                <i data-lucide="user"></i>
                <x-frontend.theme />
                <button class="openSidebar text-2xl lg:hidden" title="Open Sidebar">
                    <i data-lucide="menu"
                        class="text-text-primary dark:text-text-white hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"></i>
                </button>
            </div>
        </div>
    </div>
</header>
