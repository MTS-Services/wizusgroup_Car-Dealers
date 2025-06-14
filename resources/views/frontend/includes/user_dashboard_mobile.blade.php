<!-- Sidebar -->
<div
    class="userDashboardSidebar fixed top-0 left-0 min-h-screen h-full w-4/5 lg:w-1/2 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-tertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto p-2 xl:p-3">
        <div class="flex justify-between items-center border-b border-b-border-light pb-5">
            <h4>{{ __('Client Dashboard') }}</h4>
            <button class="closeUsreDashboardSidebar" title="Close Sidebar">
                <span
                    class="w-10 h-10 flex items-center justify-center bg-bg-primary hover:bg-bg-tertiary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>
        <div class="w-full bg-bg-light dark:bg-opacity-30">
            <div class="bg-bg-tertiary bg-opacity-50">
                <a href="#" class="nav_item active" data-target="client-dashboard">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="{{ __('Logo') }}"
                        class="w-48 p-3 mx-auto ">
                </a>
            </div>
            <div>
                <ul class="">
                    <li class="group nav_item dark:hover:bg-bg-dark-tertiary transition-all duration-300"
                        data-target="my_dashboard">
                        <a href="{{ route('user.profile', ['slug' => 'dashboard']) }}"
                            class="flex items-center gap-2 p-3"><i data-lucide="home"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect {{ !isset($page_slug) || (isset($page_slug) && $page_slug == 'dashboard') ? 'text-text-tertiary' : '' }}"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect {{ !isset($page_slug) || (isset($page_slug) && $page_slug == 'dashboard') ? 'text-text-tertiary' : '' }}">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-dark-tertiary transition-all duration-300"
                        data-target="my_orders">
                        <a href="{{ route('user.profile', ['slug' => 'orders']) }}"
                            class="flex items-center gap-2 p-3"><i data-lucide="shopping-cart"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect {{ isset($page_slug) && $page_slug == 'orders' ? 'text-text-tertiary' : '' }}"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect {{ isset($page_slug) && $page_slug == 'orders' ? 'text-text-tertiary' : '' }}">{{ __('My Orders') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item  dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                        data-target="my_containers">
                        <a href="{{ route('user.profile', ['slug' => 'containers']) }}"
                            class="flex items-center gap-2 p-3"><i data-lucide="container"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect {{ isset($page_slug) && $page_slug == 'containers' ? 'text-text-tertiary' : '' }}"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect {{ isset($page_slug) && $page_slug == 'containers' ? 'text-text-tertiary' : '' }}">{{ __('My Containers') }}</span>
                        </a>
                    </li>
                    @if (isset($not_use))
                        {{-- <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my_bids">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="dollar-sign"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Bids') }}</span>
                                </a>
                            </li> --}}
                        {{-- <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my_inquiries">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="info"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Inquiries') }}</span>
                                </a>
                            </li> --}}
                    @endif
                    <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                        data-target="update_profile">
                        <a href="{{ route('user.profile', ['slug' => 'profile']) }}"
                            class="flex items-center gap-2 p-3"><i data-lucide="user"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect {{ isset($page_slug) && $page_slug == 'profile' ? 'text-text-tertiary' : '' }}"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect {{ isset($page_slug) && $page_slug == 'profile' ? 'text-text-tertiary' : '' }}">{{ __('Update Profile') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300">
                        <a href="javascript:void(0)" onclick="document.getElementById('logout_form').submit()"
                            class="flex items-center gap-2 p-3"><i data-lucide="log-out"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Logout') }}</span>
                        </a>
                        <form action="{{ route('logout') }}" id="logout_form" method="POST">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
