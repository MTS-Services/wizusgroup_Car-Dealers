<header class="bg-bg-white dark:bg-bg-dark">
    <div class="container">
        <div class="navbar">
            <div class="navbar-start">
                <a href="" class=""><img src="{{ asset('frontend/images/logo.png') }}" alt="Logo"
                        class="w-28"></a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="#">{{ __('Home') }}</a></li>
                    <li><a href="#">{{ __('About Us') }}</a></li>
                    <li><a href="#">{{ __('Products') }}</a></li>
                    <li><a href="#">{{ __('Auctions') }}</a></li>
                </ul>
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
