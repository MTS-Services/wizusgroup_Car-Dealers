@extends('frontend.layouts.app', ['page_slug' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    <section class="py-15 ">
        <div class="container">
            <div class="flex shadow-card rounded-xl overflow-hidden">
                <div class=" w-1/4 bg-bg-light dark:bg-opacity-30">
                    <div class="bg-bg-tertiary bg-opacity-50">
                        <a href="#" class="nav_item active" data-target="client-dashboard">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="{{ __('Logo') }}"
                                class="w-48 p-3 mx-auto ">
                        </a>
                    </div>
                    <div>
                        <ul class="mt-2">
                            <li class="group nav_item" data-target="my-orders">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="menu"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize group-hover:text-text-tertiary text-hover-effect">{{ __('My Orders') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item" data-target="my-containers">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="container"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Containers') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item" data-target="payments">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="dollar-sign"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Payments') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item" data-target="messages">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="mail"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Messages') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item" data-target="update-profile">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="user"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Update Profile') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full lg:w-3/4">
                    <div class=" min-h-[200px] border-none ">
                        <div id="client-dashboard" class="nav-pane block">
                            {{-- Client Dashboard --}}
                            <div class="bg-bg-gray dark:bg-opacity-20">
                                <h2
                                    class="text-2xl  lg:text-4xl uppercase font-bold py-12{{-- bg-bg-light dark:bg-bg-dark-tertiary --}} ps-10">
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
                                        <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
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
                                        <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
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
                                        <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
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
                                        <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
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
                            </div>
                            <h3 class="text-xl font-semibold">My Orders</h3>
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
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 p-10">
                                <div class="w-full">
                                    <div
                                        class="flex justify-around items-center gap-5 py-5 text-center flex-wrap md:flex-nowrap">
                                        <p class="btn-item w-full py-2 bg-bg-primary rounded-md text-white hover:bg-bg-tertiary transition-all duration-300 btn_active"
                                            data-target="profile">Profile</p>
                                        <p class="btn-item w-full py-2 bg-bg-primary rounded-md text-white hover:bg-bg-tertiary transition-all duration-300"
                                            data-target="shop-details">Shop Details</p>
                                        <p class="btn-item w-full py-2 bg-bg-primary rounded-md text-white hover:bg-bg-tertiary transition-all duration-300"
                                            data-target="address">Address</p>
                                        <p class="btn-item w-full py-2 bg-bg-primary rounded-md text-white hover:bg-bg-tertiary transition-all duration-300"
                                            data-target="change-password">Change Password</p>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="min-h-[200px] rounded-lg  mt-5 p-5">
                                        <div id="profile" class="tab-pane block">
                                            <h3 class="text-xl font-semibold">Profile</h3>
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
                                            <h3 class="text-xl font-semibold">Change Password</h3>
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
        $(document).ready(function () {
            // ******** Sidebar Navigation Tabs (.nav_item) ********
            $('.nav_item').on('click', function () {
                $('.nav_item')
                    .removeClass('active')
                    .addClass('bg-greenyellow text-black');

                $(this).addClass('active');

                const target = $(this).data('target');

                $('.nav-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });

            // ******** Update Profile Button Tabs (.btn-item) ********
            $('.btn-item').on('click', function () {
                $('.btn-item').removeClass('btn_active');
                $(this).addClass('btn_active');

                const target = $(this).data('target');

                $('.tab-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });
        });
    </script>

@endpush