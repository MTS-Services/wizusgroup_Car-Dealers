<header class="bg-bg-white dark:bg-bg-dark">
    <div class="container">
        <div class="navbar">
            <div class="navbar-start">
                <a href="" class=""><img src="{{ asset('frontend/images/logo.png') }}" alt="Logo"
                        class="w-28"></a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <div class="flex items-center justify-center gap-2">
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ url('/') }}">{{ __('Home') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                        href="">{{ __('About Us') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.product') }}">{{ __('Products') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.auction') }}">{{ __('Auctions') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.contact') }}">{{ __('Contact') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.dropshipping') }}">{{ __('Dropshipping') }}</a>
                    <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                        href="{{ route('frontend.regions') }}">{{ __('Regions') }}</a>
                </div>
            </div>
            <div class="navbar-end flex items-center justify-end gap-3">
                <span class="hidden lg:flex">
                    <x-frontend.language />
                </span>
                <a href="#" class="hover:text-text-secondary transition-all duration-300 ease-linear"><i
                        data-lucide="shopping-basket"></i></a>
                <a href="javaScript:void(0)" onclick="my_modal_1.showModal()"
                    class="hover:text-text-secondary transition-all duration-300 ease-linear"><i
                        data-lucide="user"></i></a>
                <span class="hidden lg:flex"><x-frontend.theme /></span>
                <button
                    class="openSidebar text-2xl lg:hidden hover:text-text-secondary transition-all duration-300 ease-linear"
                    title="Open Sidebar">
                    <i data-lucide="menu"></i>
                </button>
            </div>
        </div>
    </div>
</header>
