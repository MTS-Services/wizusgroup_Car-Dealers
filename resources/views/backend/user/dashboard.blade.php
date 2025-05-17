@extends('frontend.layouts.app', ['page_slug' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    <section class="py-15 ">
        <div class="container">
            <div class="flex shadow-card dark:shadow-darkCard rounded-xl overflow-hidden">
                <div class="w-1/4 bg-bg-light dark:bg-opacity-30 hidden xl:block">
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
                <div class="w-full xl:w-3/4">
                    <div class=" min-h-[200px] border-none ">
                        <div id="client-dashboard" class="nav-pane block">
                            {{-- Client Dashboard --}}
                            <div class="bg-bg-gray dark:bg-opacity-20">
                                <h2 class="text-2xl  lg:text-4xl uppercase font-bold py-12{{-- bg-bg-light dark:bg-bg-dark-tertiary --}} ps-10">
                                    {{ __('Client Dashboard') }}
                                </h2>
                                <div class="flex flex-wrap gap-10 items-center p-10">
                                    <div
                                        class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span><i data-lucide="menu"
                                                    class="w-10 h-10 bg-bg-gray  dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Orders') }}</span>
                                        </div>
                                        <h3
                                            class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                                            {{ __('3') }}
                                        </h3>
                                    </div>
                                    <div
                                        class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span><i data-lucide="container"
                                                    class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Containers') }}</span>
                                        </div>
                                        <h3
                                            class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                                            {{ __('1') }}
                                        </h3>
                                    </div>
                                    <div
                                        class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span><i data-lucide="dollar-sign"
                                                    class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Payments') }}</span>
                                        </div>
                                        <h3
                                            class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                                            {{ __('$8,200') }}
                                        </h3>
                                    </div>
                                    <div
                                        class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span><i data-lucide="mail"
                                                    class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Messages') }}</span>
                                        </div>
                                        <h3
                                            class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                                            {{ __('2') }}
                                        </h3>
                                    </div>
                                    <div
                                        class="w-96 lg:max-w-md shadow-card ps-5  lg:ps-10 py-5 bg-bg-white dark:bg-opacity-30  rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Update Profile') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="my-orders" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10">
                                <h3 class="text-xl font-semibold">My Orders</h3>
                            </div>
                        </div>
                        <div id="my-containers" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10">
                                <h3 class="text-xl font-semibold">My Containers</h3>
                            </div>
                        </div>
                        <div id="payments" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10">
                                <h3 class="text-xl font-semibold">Payments</h3>
                            </div>
                        </div>
                        <div id="messages" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10">
                                <h3 class="text-xl font-semibold">Messages</h3>
                            </div>
                        </div>
                        <div id="update-profile" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10">
                                <div class="w-full">
                                    <div
                                        class="flex justify-around items-center gap-5 py-5 text-center flex-wrap md:flex-nowrap">
                                        <p class="btn-item btn-primary w-full py-2 rounded-md btn_active"
                                            data-target="profile">Profile</p>
                                        <p class="btn-item btn-primary w-full py-2 rounded-md" data-target="shop-details">
                                            Shop Details</p>
                                        <p class="btn-item btn-primary w-full py-2 rounded-md" data-target="address">
                                            Address</p>
                                        <p class="btn-item btn-primary w-full py-2 rounded-md"
                                            data-target="change-password">Change Password</p>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="min-h-[200px] rounded-lg  mt-5 p-5">
                                        <div id="profile" class="tab-pane block">
                                            {{-- Update Profile --}}
                                            {{-- <h3 class="text-xl font-semibold mb-4 uppercase">Update Profile</h3> --}}
                                            <div>
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                        <div>
                                                            <label for="first_name"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('First Name') }}</label>
                                                            <input class="input rounded-md w-full" type="text"
                                                                name="first_name" id="first_name">
                                                        </div>
                                                        <div>
                                                            <label for="last_name"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Last Name') }}</label>
                                                            <input class="input rounded-md w-full" type="text"
                                                                name="last_name" id="last_name">
                                                        </div>
                                                        <div>
                                                            <label for="username"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Username') }}</label>
                                                            <input class="input rounded-md w-full" type="text"
                                                                name="username" id="username">
                                                        </div>
                                                        <div>
                                                            <label for="email"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Email') }}</label>
                                                            <input class="input rounded-md w-full" type="email"
                                                                name="email" id="email">
                                                        </div>
                                                        {{-- image --}}
                                                        <div>
                                                            <label for="image"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Image') }}</label>
                                                            <input class="input rounded-md w-full p-2" type="file"
                                                                name="image" id="image">
                                                        </div>
                                                        <div>
                                                            <label for="phone"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Phone') }}</label>
                                                            <input class="input rounded-md w-full" type="text"
                                                                name="phone" id="phone">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div id="shop-details" class="tab-pane hidden">
                                            <h3 class="text-xl font-semibold">Shop Details</h3>
                                            <p>This is the shop details content section. You can add your shop information
                                                here.</p>
                                        </div>
                                        <div id="address" class="tab-pane hidden">
                                            <h3 class="text-xl font-semibold">Address</h3>
                                        </div>
                                        <div id="change-password" class="tab-pane hidden">
                                            <div class="max-w-lg mx-auto">
                                                <form action="" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 gap-5">
                                                        <div>
                                                            <label for="current_password"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Current
                                                                                                                                                                                            Password') }}</label>
                                                            <input class="input rounded-md w-full" type="password"
                                                                name="current_password" id="current_password">
                                                        </div>
                                                        <div>
                                                            <label for="password"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('New
                                                                                                                                                                                            Password') }}</label>
                                                            <input class="input rounded-md w-full" type="password"
                                                                name="password" id="new_password">
                                                        </div>
                                                        <div>
                                                            <label for="password_confirmation"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Confirm New Password') }}</label>
                                                            <input class="input rounded-md w-full" type="password"
                                                                name="password_confirmation" id="password_confirmation">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-5">Change
                                                        Password</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // ******** Sidebar Navigation Tabs (.nav_item) ********
            $('.nav_item').on('click', function() {
                $('.nav_item')
                    .removeClass('active')
                    .addClass('bg-greenyellow text-black');

                $(this).addClass('active');

                const target = $(this).data('target');

                $('.nav-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });

            // ******** Update Profile Button Tabs (.btn-item) ********
            $('.btn-item').on('click', function() {
                $('.btn-item').removeClass('btn_active');
                $(this).addClass('btn_active');

                const target = $(this).data('target');

                $('.tab-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });
        });
    </script>
    <script>
         $(document).ready(function() {
            const $openSidebar = $('.openUsreDashboardSidebar');
            const $closeSidebar = $('.closeUsreDashboardSidebar');
            const $sidebar = $('.usreDashboardSidebar'); // Select the sidebar element globally

            // Sidebar open functionality
            $openSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(0)'); // Show the sidebar
                // $(this).addClass('hidden'); // Hide the open button
            });

            $closeSidebar.on('click', function() {
                $sidebar.css('transform', 'translateX(-100%)'); // Hide the sidebar
                setTimeout(() => {
                    // $openSidebar.removeClass('hidden'); // Show all openSidebar buttons
                }, 300); // Delay for the sidebar transition
            });
        });
    </script>
@endpush
