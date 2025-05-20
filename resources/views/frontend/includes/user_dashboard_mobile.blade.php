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
                    <li class="group nav_item dark:hover:bg-bg-tertiary transition-all duration-300"
                        data-target="my-orders">
                        <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="menu"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize group-hover:text-text-tertiary text-hover-effect">{{ __('My Orders') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-tertiary transition-all duration-300"
                        data-target="my-containers">
                        <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="container"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Containers') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-tertiary transition-all duration-300"
                        data-target="payments">
                        <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="dollar-sign"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Payments') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-tertiary transition-all duration-300"
                        data-target="messages">
                        <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="mail"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Messages') }}</span>
                        </a>
                    </li>
                    <li class="group nav_item dark:hover:bg-bg-tertiary transition-all duration-300"
                        data-target="update-profile">
                        <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="user"
                                class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Update Profile') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
