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
                            {{-- <li class="group nav_item dark:hover:bg-bg-dark-tertiary transition-all duration-300"
                                data-target="my_reserves">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="menu"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Reserves') }}</span>
                                </a>
                            </li> --}}
                            <li class="group nav_item active dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my-containers">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="container"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Containers') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my_bids">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="dollar-sign"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Bids') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my_inquiries">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="mail"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Inquiries') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="update-profile">
                                <a href="javascript:void(0)" class="flex items-center gap-2 p-3"><i data-lucide="user"
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
                                <div class="flex flex-wrap gap-10 items-center p-10 pt-0">
                                    <div
                                        class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                        <div class="flex items-center gap-3">
                                            <span><i data-lucide="menu"
                                                    class="w-10 h-10 bg-bg-gray  dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                            <span
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Reserves') }}</span>
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
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Bids') }}</span>
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
                                                class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Inquiries') }}</span>
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
                        {{-- <div id="my_reserves" class="nav-pane hidden">
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
                        </div> --}}
                        <div id="my-containers" class="nav-pane block">
                            {{-- My Containers --}}
                            @include('backend.user.includes.my_containers')
                        </div>
                        <div id="my_bids" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <div class="max-w-6xl mx-auto">
                                    {{-- My Bids --}}
                                    @include('backend.user.includes.my_bids')
                                </div>
                            </div>
                        </div>
                        <div id="my_inquiries" class="nav-pane hidden">
                            <div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
                                <h3 class="text-xl font-semibold">My Inquiries</h3>
                            </div>
                        </div>
                        <div id="update-profile" class="nav-pane hidden @if (isset($page_slug) && $page_slug == 'dashboard') active @endif">
                            {{-- Update Profile --}}
                            @include('backend.user.includes.update_profile')
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
            let data_id = `{{ $address?->state_id ? $address?->state_id : $address?->city_id }}`;
            if (data_id) {
                getStatesOrCity($('#country').val(), route1, data_id);
            }
            if (`{{ $address?->state_id }}`) {
                getCities(`{{ $address?->state_id }}`, route2, `{{ $address?->city_id }}`);
            }

            // FilePond Upload
            const existingFiles = {
                "#image": "{{ $user->modified_image }}"
            };
            file_upload(["#image"], ["image/jpeg", "image/png", "image/jpg", "image/webp", "image/svg"],
                existingFiles);
        });
    </script>
    {{-- My Containers - Button Filter Styling --}}
    <script>
        document.querySelectorAll('.btn-item').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const dataTab = button.getAttribute('data-tab');

                // Toggle button styles
                document.querySelectorAll('.btn-item').forEach(btn => {
                    btn.classList.remove('bg-bg-tertiary');
                    btn.classList.add('bg-bg-primary');
                });
                button.classList.remove('bg-bg-primary');
                button.classList.add('bg-bg-tertiary');

                // Filter containers
                const containerCards = document.querySelectorAll('.container-card');
                containerCards.forEach(card => {
                    const cardStatus = card.getAttribute('data-status');
                    if (dataTab === 'all' || dataTab === cardStatus) {
                        card.classList.remove('block');
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                        card.classList.remove('block');
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timers = document.querySelectorAll('.timer_countdown');

            timers.forEach(timer => {
                const endDate = moment(timer.dataset.enddate); // Use moment.js to parse the deadline

                function updateCountdown() {
                    const now = moment();
                    const duration = moment.duration(endDate.diff(now));

                    if (duration.asSeconds() <= 0) {
                        timer.innerText = 'Closed';
                        clearInterval(timer._interval);
                        return;
                    }

                    const days = Math.floor(duration.asDays());
                    const hours = duration.hours();
                    const minutes = duration.minutes();
                    const seconds = duration.seconds();

                    timer.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                }

                updateCountdown(); // Initial render
                timer._interval = setInterval(updateCountdown, 1000); // Store interval on the element
            });
        });
    </script>
@endpush
