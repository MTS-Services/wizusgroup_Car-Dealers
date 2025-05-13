<!-- Sidebar -->
<div
    class="sidebar fixed top-0 right-0 min-h-screen h-full w-2/3 translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

    <div class="h-full p-5">
        <div class="flex justify-end items-center border-b border-b-border-light pb-5">
            {{-- <a href="{{ url('/') }}" class="">
                <span class="dark-mode-logo hidden">
                    <img src="{{ asset('frontend/images/logo-light.png') }}" alt="Logo">
                </span>
                <span class="light-mode-logo">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                </span>
            </a> --}}
            <button class="closeSidebar" title="Close Sidebar">
                <span class="w-10 h-10 flex items-center justify-center bg-bg-secondary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>

        <div class="flex justify-between items-center border-b border-b-border-light py-5">
            <span
                class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Search Product') }}</span>
            <x-frontend.search />
        </div>

        <div class="mt-5 flex flex-col items-start justify-start">
            <a href="{{ url('/') }}"
                class="capitalize text-text-primary dark:text-text-white relative border-b border-b-border-light py-1.5 px-5
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'home') after:w-full @else after:w-0 @endif">
                {{ __('Home') }}
            </a>
            <a href=""
                class="capitalize text-text-primary dark:text-text-white relative border-b border-b-border-light py-1.5 px-5
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'shop') after:w-full @else after:w-0 @endif">
                {{ __('Shop') }}
            </a>
            <a href=""
                class="capitalize text-text-primary dark:text-text-white relative border-b border-b-border-light py-1.5 px-5
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'store_location') after:w-full @else after:w-0 @endif">
                {{ __('Store location') }}
            </a>
            <a href="#"
                class="capitalize text-text-primary dark:text-text-white relative border-b border-b-border-light py-1.5 px-5
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'contact') after:w-full @else after:w-0 @endif">
                {{ __('Contact') }}
            </a>
            <a href=""
                class="capitalize text-text-primary dark:text-text-white relative border-b border-b-border-light py-1.5 px-5
                after:content-[''] after:absolute after:left-0 after:top-full after:h-0.5 after:bg-bg-accent
                hover:after:w-full after:transition-all after:duration-300 @if (isset($page_slug) && $page_slug == 'faq') after:w-full @else after:w-0 @endif">
                {{ __('Faq') }}
            </a>
        </div>

        <div class="border-t border-t-border-light py-5 mt-5">

            {{-- General Settings --}}

            <span
                class="block text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50 mb-2">{{ __('Settings') }}</span>
            <div class="pl-5">
                <div class="flex items-center justify-between gap-2">
                    <span
                        class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Theme') }}</span>
                    <x-frontend.theme />
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span
                        class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Language') }}</span>
                    <x-frontend.language />
                </div>
            </div>

            {{-- Account Settings  --}}
            <span
                class="block text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50 my-3">{{ __('Account') }}</span>
            <div class="pl-5">
                @auth('web')
                    <a href="" class="flex items-center justify-between gap-2">
                        <span
                            class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Profile') }}</span>
                        <i data-lucide="user"></i>
                    </a>
                    <a href="" class="flex items-center justify-between gap-2">
                        <span
                            class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Password') }}</span>
                        <i data-lucide="key-round"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center justify-between gap-2">
                        <span
                            class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Profile') }}</span>
                        <i data-lucide="user"></i>
                    </a>
                @endauth
            </div>
        </div>

    </div>
    <ul class="menu p-0 pt-6">
        <li><a href=""
                class="text-lg px-10 text-c-light font-semibold rounded-none border-b border-b-c-primary transition-colors duration-300 hover:bg-c-light/5 hover:text-c-primary @if (isset($page_slug) && $page_slug == 'home')  @endif">Home</a>
        </li>
        <li><a href=""
                class="text-lg px-10 text-c-light font-semibold rounded-none border-b border-b-c-primary transition-colors duration-300 hover:bg-c-light/5 hover:text-c-primary @if (isset($page_slug) && $page_slug == 'shop')  @endif">Shop</a>
        </li>
    </ul>
</div>
