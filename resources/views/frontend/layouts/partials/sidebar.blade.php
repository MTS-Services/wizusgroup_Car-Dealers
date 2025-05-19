<!-- Sidebar -->
<div
    class="sidebar fixed top-0 right-0 min-h-screen h-full w-full translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-secondary bg-opacity-30 dark:bg-opacity-30 z-[99999999999]">

    <div class="h-full overflow-y-auto max-h-screen bg-bg-light dark:bg-bg-dark-secondary w-5/6 xs:w-3/4 md:w-1/2 lg:w-1/3 ml-auto shadow-xl rounded-l-md">
        <div class="h-full p-5">
            <div class="flex justify-end items-center pb-2">
                {{-- <a href="{{ url('/') }}" class="">
                <span class="dark-mode-logo hidden">
                    <img src="{{ asset('frontend/images/logo-light.png') }}" alt="Logo">
                </span>
                <span class="light-mode-logo">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                </span>
            </a> --}}
                <button class="closeSidebar" title="Close Sidebar">
                    <span class="btn-primary w-10 h-10 p-0 text-text-white">
                        <i data-lucide="x"></i>
                    </span>
                </button>
            </div>

            {{-- <div class="flex justify-between items-center py-5">
            <span
                class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Search Product') }}</span>
            <x-frontend.search />
        </div> --}}

            <div class="mt-5 flex flex-col items-start justify-start">
                <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                    href="{{ url('/') }}">{{ __('Home') }}</a>
                <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                    href="">{{ __('About Us') }}</a>
                <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                    href="">{{ __('Products') }}</a>
                <a class="px-3 py-1 rounded-md text-text-primary dark:text-text-light hover:text-text-secondary dark:hover:text-text-secondary font-medium capitalize transition-all duration-300 ease-linear"
                    href="">{{ __('Auctions') }}</a>
            </div>

            <div class="divider my-2"></div>

            <div class="pb-5">

                {{-- General Settings --}}

                <span
                    class="block text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50 pb-3">{{ __('Settings') }}</span>
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

                <div class="divider my-2"></div>

                {{-- Account Settings  --}}
                <span
                    class="block text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50 pb-3">{{ __('Account') }}</span>
                <div class="pl-5">
                    @auth('web')
                        <a href="" class="flex items-center justify-between gap-2">
                            <span
                                class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Profile') }}</span>
                            <i data-lucide="user"
                                class="hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                        </a>
                        <a href="" class="flex items-center justify-between gap-2">
                            <span
                                class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Password') }}</span>
                            <i data-lucide="key-round"
                                class="hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-between gap-2">
                            <span
                                class="text-text-primary dark:text-text-white text-opacity-50 dark:text-opacity-50">{{ __('Profile') }}</span>
                            <i data-lucide="user"
                                class="hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>
