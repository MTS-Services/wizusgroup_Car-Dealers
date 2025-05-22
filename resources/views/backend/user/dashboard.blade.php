@extends('frontend.layouts.app', ['page_slug' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    <section class="py-15 ">
        <div class="container">
            <div class="flex shadow-card dark:shadow-darkCard rounded-xl overflow-hidden">
                <div class="w-0 bg-bg-light dark:bg-opacity-30 xl:w-1/4 transition-all duration-300 ease-in-out">
                    <div class="bg-bg-tertiary bg-opacity-50">
                        <a href="#" class="nav_item  @if (isset($page_slug) && $page_slug == '') active @endif"
                            data-target="client-dashboard">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="{{ __('Logo') }}"
                                class="w-48 p-3 mx-auto ">
                        </a>
                    </div>
                    <div>
                        <ul class="">
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary transition-all duration-300"
                                data-target="my-orders">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="menu"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Orders') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my-containers">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="container"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Containers') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="payments">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="dollar-sign"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Payments') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="messages">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="mail"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Messages') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300 active"
                                data-target="update-profile">
                                <a href="{{ route('user.profile') }}" class="flex items-center gap-2 p-3"><i
                                        data-lucide="user"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Update Profile') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="update-profile">
                                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()"
                                    class="flex items-center gap-2 p-3"><i data-lucide="log-out"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Logout') }}</span>
                                </a>
                                <form action="{{ route('logout') }}" id="logout-form" method="POST">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full xl:w-3/4">
                    <div class=" min-h-[200px] border-none ">
                        {{-- Mobile Sidebar --}}
                        @include('frontend.includes.user_dashboard_mobile')
                        <div>
                            <div class="bg-bg-gray dark:bg-opacity-20">
                                <div class="flex items-center gap-4 ps-10 py-12">
                                    <span class="openUsreDashboardSidebar xl:hidden"><i data-lucide="menu"
                                            class="w-6 h-6 md:w-8 md:h-8 bg-bg-primary text-text-white hover:bg-bg-tertiary transition-all duration-300 rounded-md p-1 "></i></span>
                                    <h2 class="text-2xl  lg:text-4xl uppercase font-bold{{-- bg-bg-light dark:bg-bg-dark-tertiary --}}">
                                        {{ __('Client Dashboard') }}</h2>
                                </div>
                            </div>
                        </div>
                        <div id="client-dashboard" class="nav-pane hidden">
                            {{-- Client Dashboard --}}
                            <div class="bg-bg-gray dark:bg-opacity-20">
                                {{-- <div class="flex items-center gap-4 ps-10 py-10">
                                    <h2 class="text-2xl  lg:text-4xl uppercase font-bold">
                                        {{ __('Client Dashboard') }}</h2>
                                </div> --}}
                                <div class="flex flex-wrap gap-10 items-center p-10 pt-0">
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
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <div class="max-w-6xl mx-auto">
                                    <!-- Orders Panel Header -->
                                    <div class="pb-4">
                                        <h2 class="text-xl lg:text-2xl font-medium text-text-primary dark:text-text-white">
                                            {{ __('My Orders') }}</h2>
                                    </div>

                                    <!-- Orders Panel -->
                                    <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-lg shadow-md overflow-hidden">
                                        <!-- Filters and Search -->
                                        <div
                                            class="p-4 border-b dark:border-b-border-gray dark:border-opacity-50 flex flex-wrap justify-between items-center">
                                            <div class="flex space-x-2 mb-2 sm:mb-0">
                                                <a href="#"
                                                    class="btn-item bg-bg-tertiary btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    All Orders
                                                </a>
                                                <a href="#"
                                                    class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    Pending
                                                </a>
                                                <a href="#"
                                                    class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    Completed
                                                </a>
                                            </div>
                                            <div class="relative">
                                                <input type="text" placeholder="Search orders..."
                                                    class="pl-10 pr-4 py-2 border border-border-gray dark:border-opacity-50 rounded-md focus:outline-none focus:ring-1 focus:ring-bg-tertiary">
                                                <div
                                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-gray">
                                                    <i class="w-5 h-5" data-lucide="search"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Orders Table -->
                                        <div class="overflow-x-auto">
                                            <table class="w-full">
                                                <thead class="bg-bg-gray bg-opacity-50 dark:bg-opacity-20 text-left">
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Order ID</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Product</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Date</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Amount</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Status</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-border-gray dark:divide-opacity-50">
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10234</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Industrial Machinery</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            15, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $12,500.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-800 text-text-white">
                                                                Delivered
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10233</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Conveyor System</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            10, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $8,750.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-800 text-text-white">
                                                                In Transit
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10232</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Packaging Equipment</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            5, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $5,200.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-bg-tertiary text-text-white">
                                                                Processing
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div
                                            class="px-6 py-4 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                                            <div class="text-sm text-text-gray dark:text-text-light">
                                                Showing <span class="font-medium">1</span> to <span
                                                    class="font-medium">3</span> of <span class="font-medium">12</span>
                                                orders
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm disabled:opacity-50"
                                                    disabled>
                                                    Previous
                                                </a>
                                                <a href="#"
                                                    class="btn-primary py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary">
                                                    1
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    2
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    3
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    4
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    Next
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="my-containers" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <div class="max-w-6xl mx-auto">
                                    <!-- My Containers Panel Header -->
                                    <div class="mb-6">
                                        <h2 class="text-2xl font-bold text-gray-800">My Containers</h2>
                                        <p class="text-text-gray">Track and manage your container shipments</p>
                                    </div>
                                    <!-- Filters -->
                                    <div class="mb-6 flex flex-wrap gap-2">
                                        <a href="#"
                                            class="btn-item bg-bg-tertiary btn-primary hover:bg-bg-tertiary py-2 rounded-md">
                                            All Containers
                                        </a>
                                        <a href="#"
                                            class="btn-item btn-primary hover:bg-bg-tertiary py-2 rounded-md">
                                            Active
                                        </a>
                                        <a href="#"
                                            class="btn-item btn-primary hover:bg-bg-tertiary py-2 rounded-md">
                                            Completed
                                        </a>
                                        <div class="ml-auto">
                                            <a href="#"
                                                class="btn-primary py-2 bg-bg-wiz_green rounded-md hover:bg-bg-tertiary">
                                                <i class="fas fa-plus mr-2"></i> Join a Shipment
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Containers Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <!-- Container Card 1 -->
                                        <div class="bg-bg-white rounded-lg shadow-md overflow-hidden">
                                            <div class="p-4 border-b">
                                                <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-semibold">Container #18</h3>
                                                    <span
                                                        class="px-2 py-1 bg-bg-wiz_green text-text-white rounded-full text-xs font-medium">
                                                        Active
                                                    </span>
                                                </div>
                                                <p class="text-text-gray">Destination: Ghana</p>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex items-center mb-2">
                                                    <i class="far fa-calendar-alt text-text-gray mr-2"></i>
                                                    <span class="text-sm text-text-gray">Departure: May 8, 2025</span>
                                                </div>
                                                <div class="flex items-center mb-4">
                                                    <i class="fas fa-ship text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Carrier: Maersk Line</span>
                                                </div>

                                                <div class="mb-2 flex justify-between items-center">
                                                    <span class="text-sm font-medium text-text-gray">Capacity</span>
                                                    <span class="text-sm font-medium text-text-gray">75% filled</span>
                                                </div>
                                                <div class="w-full bg-bg-gray rounded-full h-2.5">
                                                    <div class="bg-bg-wiz_orange h-2.5 rounded-full" style="width: 75%">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex justify-between items-center">
                                                    <span class="text-sm text-text-gray">Your Items: 3</span>
                                                    <a href="#"
                                                        class="text-text-wiz_green hover:underline text-sm font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Container Card 2 -->
                                        <div class="bg-bg-white rounded-lg shadow-md overflow-hidden">
                                            <div class="p-4 border-b">
                                                <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-semibold">Container #19</h3>
                                                    <span
                                                        class="px-2 py-1 bg-yellow-500 text-text-white rounded-full text-xs font-medium">
                                                        Filling
                                                    </span>
                                                </div>
                                                <p class="text-text-gray">Destination: Kenya</p>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex items-center mb-2">
                                                    <i class="far fa-calendar-alt text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Departure: May 12, 2025</span>
                                                </div>
                                                <div class="flex items-center mb-4">
                                                    <i class="fas fa-ship text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Carrier: MSC</span>
                                                </div>

                                                <div class="mb-2 flex justify-between items-center">
                                                    <span class="text-sm font-medium text-text-gray">Capacity</span>
                                                    <span class="text-sm font-medium text-text-gray">55% filled</span>
                                                </div>
                                                <div class="w-full bg-bg-gray rounded-full h-2.5">
                                                    <div class="bg-bg-wiz_orange h-2.5 rounded-full" style="width: 55%">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex justify-between items-center">
                                                    <span class="text-sm text-text-gray">Your Items: 2</span>
                                                    <a href="#"
                                                        class="text-text-wiz_green hover:underline text-sm font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Container Card 3 -->
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                            <div class="p-4 border-b">
                                                <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-semibold">Container #20</h3>
                                                    <span
                                                        class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                        Loading
                                                    </span>
                                                </div>
                                                <p class="text-text-gray">Destination: Nigeria</p>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex items-center mb-2">
                                                    <i class="far fa-calendar-alt text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Departure: May 20, 2025</span>
                                                </div>
                                                <div class="flex items-center mb-4">
                                                    <i class="fas fa-ship text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Carrier: CMA CGM</span>
                                                </div>

                                                <div class="mb-2 flex justify-between items-center">
                                                    <span class="text-sm font-medium text-text-gray">Capacity</span>
                                                    <span class="text-sm font-medium text-text-gray">80% filled</span>
                                                </div>
                                                <div class="w-full bg-bg-gray rounded-full h-2.5">
                                                    <div class="bg-bg-wiz_orange h-2.5 rounded-full" style="width: 80%">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex justify-between items-center">
                                                    <span class="text-sm text-text-gray">Your Items: 5</span>
                                                    <a href="#"
                                                        class="text-text-wiz_green hover:underline text-sm font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Container Card 4 (Past Shipment) -->
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden opacity-75">
                                            <div class="p-4 border-b">
                                                <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-semibold">Container #17</h3>
                                                    <span
                                                        class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                                                        Delivered
                                                    </span>
                                                </div>
                                                <p class="text-text-gray">Destination: South Africa</p>
                                            </div>
                                            <div class="p-4">
                                                <div class="flex items-center mb-2">
                                                    <i class="far fa-calendar-alt text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Delivered: April 25,
                                                        2025</span>
                                                </div>
                                                <div class="flex items-center mb-4">
                                                    <i class="fas fa-ship text-text-gray text-opacity-80 mr-2"></i>
                                                    <span class="text-sm text-text-gray">Carrier: Hapag-Lloyd</span>
                                                </div>

                                                <div class="mb-2 flex justify-between items-center">
                                                    <span class="text-sm font-medium text-text-gray">Capacity</span>
                                                    <span class="text-sm font-medium text-text-gray">100% filled</span>
                                                </div>
                                                <div class="w-full bg-bg-gray rounded-full h-2.5">
                                                    <div class="bg-bg-gray bg-opacity-50 h-2.5 rounded-full"
                                                        style="width: 100%">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex justify-between items-center">
                                                    <span class="text-sm text-text-gray">Your Items: 4</span>
                                                    <a href="#"
                                                        class="text-text-wiz_green hover:underline text-sm font-medium">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pagination -->
                                    <div
                                        class="px-6 py-4 mt-5 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                                        <div class="text-sm text-text-gray dark:text-text-light">
                                            Showing <span class="font-medium">1</span> to <span
                                                class="font-medium">6</span> of <span class="font-medium">12</span>
                                            Containers
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="#"
                                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm disabled:opacity-50"
                                                disabled>
                                                Previous
                                            </a>
                                            <a href="#"
                                                class="btn-primary py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary">
                                                1
                                            </a>
                                            <a href="#"
                                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                2
                                            </a>
                                            <a href="#"
                                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                3
                                            </a>
                                            <a href="#"
                                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                4
                                            </a>
                                            <a href="#"
                                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                Next
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="payments" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <div class="max-w-6xl mx-auto">
                                    <!-- Containers Panel Header -->
                                    <div class="pb-4">
                                        <h2 class="text-xl lg:text-2xl font-medium text-text-primary dark:text-text-white">
                                            {{ __('Payments') }}</h2>
                                    </div>

                                    <!-- Payments Panel -->
                                    <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-lg shadow-md overflow-hidden">
                                        <!-- Filters and Search -->
                                        <div
                                            class="p-4 border-b dark:border-b-border-gray dark:border-opacity-50 flex flex-wrap justify-between items-center">
                                            <div class="flex space-x-2 mb-2 sm:mb-0">
                                                <a href="#"
                                                    class="btn-item bg-bg-tertiary btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    All Payments
                                                </a>
                                                <a href="#"
                                                    class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    Pending
                                                </a>
                                                <a href="#"
                                                    class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                                                    Completed
                                                </a>
                                            </div>
                                            <div class="relative">
                                                <input type="text" placeholder="Search Payments..."
                                                    class="pl-10 pr-4 py-2 border border-border-gray dark:border-opacity-50 rounded-md focus:outline-none focus:ring-1 focus:ring-bg-tertiary">
                                                <div
                                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-gray">
                                                    <i class="w-5 h-5" data-lucide="search"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payments Table -->
                                        <div class="overflow-x-auto">
                                            <table class="w-full">
                                                <thead class="bg-bg-gray bg-opacity-50 dark:bg-opacity-20 text-left">
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Transection ID</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Order ID</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Product</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Date</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Amount</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Status</th>
                                                        <th
                                                            class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                                            Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-border-gray dark:divide-opacity-50">
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10234</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10234</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Industrial Machinery</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            15, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $12,500.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-800 text-text-white">Active</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10233</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10233</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Conveyor System</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            10, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $8,750.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-800 text-text-white">Overdue</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10232</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                                            #WG-10232</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            Packaging Equipment</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            May
                                                            5, 2025</td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                                            $5,200.00</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <span
                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-bg-tertiary text-text-white">Paid</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <a href="#"
                                                                class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                                                <i data-lucide="eye" class="w-5 h-5"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination -->
                                        <div
                                            class="px-6 py-4 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                                            <div class="text-sm text-text-gray dark:text-text-light">
                                                Showing <span class="font-medium">1</span> to <span
                                                    class="font-medium">3</span> of <span class="font-medium">12</span>
                                                Payments
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm disabled:opacity-50"
                                                    disabled>
                                                    Previous
                                                </a>
                                                <a href="#"
                                                    class="btn-primary py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary">
                                                    1
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    2
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    3
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    4
                                                </a>
                                                <a href="#"
                                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                                    Next
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="messages" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <h3 class="text-xl font-semibold">Messages</h3>
                            </div>
                        </div>
                        <div id="update-profile" class="nav-pane block @if (isset($page_slug) && $page_slug == 'dashboard') active @endif">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <div class="w-full">
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 items-center gap-5 py-5 text-center">
                                        <p class="btn-item btn-primary w-full py-2 rounded-md" data-target="profile">
                                            Profile</p>
                                        <p class="btn-item btn-primary w-full py-2 rounded-md btn_active"
                                            data-target="address">
                                            Address</p>
                                        <p class="btn-item btn-primary w-full py-2 rounded-md "
                                            data-target="change-password">Change Password</p>
                                    </div>
                                </div>

                                <div class="w-full">
                                    <div class="min-h-[200px] rounded-lg  mt-5 p-5">
                                        <div id="profile" class="tab-pane block">
                                            {{-- Update Profile --}}
                                            {{-- <h3 class="text-xl font-semibold mb-4 uppercase">Update Profile</h3> --}}
                                            <div>
                                                <form action="{{ route('user.profile.update'), encrypt($user->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <input type="file" name="image"
                                                                class=" w-full  filepond" id="image"
                                                                accept="image/jpeg, image/png, image/jpg, image/webp, image/svg">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'image']" />
                                                        </div>
                                                        <div class="flex flex-col gap-4">
                                                            <div>
                                                                <label class="block pb-2">{{ __('First Name') }} <span
                                                                        class="text-text-danger">*</span></label>
                                                                <input type="text" name="first_name"
                                                                    value="{{ $user?->first_name }}" class="input "
                                                                    placeholder="Enter your first name">
                                                                <x-frontend.input-error :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'first_name',
                                                                ]" />
                                                            </div>

                                                            <div>
                                                                <label class="block pb-2">{{ __('Last Name') }} <span
                                                                        class="text-text-danger">*</span></label>
                                                                <input type="text" name="last_name"
                                                                    value="{{ $user?->last_name }}" class="input "
                                                                    placeholder="Enter your last name">
                                                                <x-frontend.input-error :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'last_name',
                                                                ]" />
                                                            </div>

                                                            <div>
                                                                <label class="block pb-2">{{ __('Username') }} <span
                                                                        class="text-text-danger">*</span></label>
                                                                <input type="text" name="username"
                                                                    value="{{ $user?->username }}" class="input"
                                                                    placeholder="Enter your username">
                                                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'username']" />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block pb-2">{{ __('Email') }} <span
                                                                    class="text-text-danger">*</span></label>
                                                            <input type="email" name="email"
                                                                value="{{ $user?->email }}" class="input"
                                                                placeholder="Enter your email">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                                                        </div>
                                                        <div>
                                                            <label class="block pb-2">{{ __('Phone') }}</label>
                                                            <input type="text" name="phone"
                                                                value="{{ $user?->phone }}" class="input"
                                                                placeholder="Enter your phone">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'phone']" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Date of Birth') }}</label>
                                                            <input type="date" name="dob"
                                                                value="{{ $user?->personalInformation?->dob }}"
                                                                class="input">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'dob']" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Gender') }}</label>
                                                            <select name="gender" class="input">
                                                                @foreach (App\Models\PersonalInformation::getGenderLabels() as $key => $gender)
                                                                    <option value="{{ $key }}"
                                                                        {{ $user?->personalInformation?->gender == $key ? 'selected' : '' }}>
                                                                        {{ $gender }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'gender']" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Fathers Name') }}</label>
                                                            <input type="text" name="father_name"
                                                                value="{{ $user?->personalInformation?->father_name }}"
                                                                class="input" placeholder="Enter your father's name">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'father_name']" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Mothers Name') }}</label>
                                                            <input type="text" name="mother_name"
                                                                value="{{ $user?->personalInformation?->mother_name }}"
                                                                class="input" placeholder="Enter your mother's name">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'mother_name']" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Emergency Phone') }}</label>
                                                            <input type="text" name="emergency_phone"
                                                                value="{{ $user?->personalInformation?->emergency_phone }}"
                                                                class="input" placeholder="Enter your emergency phone">
                                                            <x-frontend.input-error :datas="[
                                                                'errors' => $errors,
                                                                'field' => 'emergency_phone',
                                                            ]" />
                                                        </div>

                                                        <div>
                                                            <label class="block pb-2">{{ __('Nationality') }}</label>
                                                            <input type="text" name="nationality"
                                                                value="{{ $user?->personalInformation?->nationality }}"
                                                                class="input" placeholder="Enter nationality">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'nationality']" />
                                                        </div>

                                                        <div class="col-span-1 md:col-span-2">
                                                            <label class="block pb-2">{{ __('Bio') }}</label>
                                                            <textarea name="bio" class="input h-20 p-3" rows="5" placeholder="Enter your bio">{{ $user?->personalInformation?->bio }}</textarea>
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'bio']" />
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div id="address" class="tab-pane hidden">
                                            <div class="rounded-md shadow-card">
                                                <div class="px-4 py-3 border border-b border-border-gray">
                                                    <h4 class="text-text-primary text-lg font-semibold">
                                                        {{ __('Profile Address') }}</h4>
                                                </div>
                                                <div class="p-6">
                                                    <form action="{{ route('user.address.update') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="grid grid-cols-1 gap-4">
                                                            <div class="grid md:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label class="block pb-2">{{ __('Country') }}
                                                                        <span class="text-text-danger">*</span></label>
                                                                    <select name="country_id" id="country"
                                                                        class="input">
                                                                        <option value="{{ $address?->country_id }}"
                                                                            selected hidden>{{ __('Select Country') }}
                                                                        </option>
                                                                        @foreach ($countries as $country)
                                                                            <option value="{{ $country->id }}"
                                                                                {{ $address?->country_id == $country->id ? 'selected' : '' }}>
                                                                                {{ $country->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <x-frontend.input-error :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'country_id',
                                                                    ]" />
                                                                </div>

                                                                <div>
                                                                    <label class="block pb-2">{{ __('State') }}</label>
                                                                    <select name="state" id="state" class="input"
                                                                        disabled>
                                                                        <option value="" selected hidden>
                                                                            {{ __('Select State') }}</option>
                                                                    </select>
                                                                    <x-frontend.input-error :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'state',
                                                                    ]" />
                                                                </div>
                                                            </div>

                                                            <div class="grid md:grid-cols-2 gap-4">
                                                                <div>
                                                                    <label class="block pb-2">{{ __('City') }}
                                                                        <span class="text-text-danger">*</span></label>
                                                                    <select name="city" id="city" class="input"
                                                                        disabled>
                                                                        <option value="" selected hidden>
                                                                            {{ __('Select City') }}</option>
                                                                    </select>
                                                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'city']" />
                                                                </div>
                                                                <div>
                                                                    <label class="block pb-2">{{ __('Postal Code') }}
                                                                        <span class="text-text-danger">*</span></label>
                                                                    <input type="text" name="postal_code"
                                                                        value="{{ $address->postal_code ?? old('postal_code') }}"
                                                                        class="input" placeholder="Enter postal code">
                                                                    <x-frontend.input-error :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'postal_code',
                                                                    ]" />
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="block pb-2">{{ __('Address Line 1') }}
                                                                    <span class="text-text-danger">*</span></label>
                                                                <textarea name="address_line_1" id="address_line_1" rows="4" class="input h-20 p-3 no-ckeditor5"
                                                                    placeholder="Enter address">{{ $address->address_line_1 ?? old('address_line_1') }}</textarea>
                                                                <x-frontend.input-error :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'address_line_1',
                                                                ]" />
                                                            </div>

                                                            <div>
                                                                <label
                                                                    class="block pb-2">{{ __('Address Line 2') }}</label>
                                                                <textarea name="address_line_2" id="address_line_2" rows="4" class="input h-20 p-3 no-ckeditor5"
                                                                    placeholder="Enter additional address">{{ $address->address_line_2 ?? old('address_line_2') }}</textarea>
                                                                <x-frontend.input-error :datas="[
                                                                    'errors' => $errors,
                                                                    'field' => 'address_line_2',
                                                                ]" />
                                                            </div>
                                                        </div>

                                                        <div class="mt-6 text-left">
                                                            <button
                                                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">
                                                                {{ __('Update') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="change-password" class="tab-pane hidden">
                                            <div class="max-w-lg mx-auto">
                                                <form action="{{ route('user.password.update') }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 gap-5">
                                                        <div>
                                                            <label for="current_password"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Current Password') }}</label>
                                                            <input class="input rounded-md w-full" type="password"
                                                                name="old_password" id="old_password">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'old_password']" />
                                                        </div>
                                                        <div>
                                                            <label for="password"
                                                                class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('New Password') }}</label>
                                                            <input class="input rounded-md w-full" type="password"
                                                                name="password" id="new_password">
                                                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
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
    {{-- FilePond --}}
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    {{-- jQuery Functionality --}}
    <script>
        $(document).ready(function() {
            // Sidebar Navigation Tabs
            $('.nav_item').on('click', function() {
                $('.nav_item')
                    .removeClass('active')
                    .addClass('bg-greenyellow text-black');
                $(this).addClass('active');

                const target = $(this).data('target');
                $('.nav-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });

            // Update Profile Button Tabs
            $('.btn-item').on('click', function() {
                $('.btn-item').removeClass('btn_active');
                $(this).addClass('btn_active');

                const target = $(this).data('target');
                $('.tab-pane').removeClass('block').addClass('hidden');
                $('#' + target).removeClass('hidden').addClass('block');
            });

            // Sidebar Toggle
            const $sidebar = $('.userDashboardSidebar');

            $('.openUsreDashboardSidebar').on('click', function() {
                $sidebar.css('transform', 'translateX(0)');
            });

            $('.closeUsreDashboardSidebar').on('click', function() {
                $sidebar.css('transform', 'translateX(-100%)');
            });

            // Get Country States By Axios
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            let data_id = `{{ $address->state_id ? $address->state_id : $address->city_id }}`;
            if (data_id) {
                getStatesOrCity($('#country').val(), route1, data_id);
            }
            if (`{{ $address->state_id }}`) {
                getCities(`{{ $address->state_id }}`, route2, `{{ $address->city_id }}`);
            }

            // FilePond Upload
            const existingFiles = {
                "#image": "{{ $user->modified_image }}"
            };
            file_upload(["#image"], ["image/jpeg", "image/png", "image/jpg", "image/webp", "image/svg"], existingFiles);
        });
    </script>
    {{-- My Orders - Button Filter Styling --}}
    <script>
        document.querySelectorAll('.btn-item').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.btn-item').forEach(btn => {
                    btn.classList.remove('bg-bg-tertiary');
                    btn.classList.add('bg-bg-primary');
                });
                button.classList.remove('bg-bg-primary');
                button.classList.add('bg-bg-tertiary');
            });
        });
    </script>
@endpush
