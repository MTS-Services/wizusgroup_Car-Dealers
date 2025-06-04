@extends('frontend.layouts.app', ['page_slug' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    <section class="py-15 ">
        <div class="container">
            <div class="flex shadow-card dark:shadow-darkCard rounded-xl overflow-hidden">
                <div class="w-0 bg-bg-light dark:bg-opacity-30 xl:w-1/4 transition-all duration-300 ease-in-out">
                    <div class="bg-bg-tertiary bg-opacity-50">
                        <a href="#" class="nav_item  @if (isset($page_slug) && $page_slug == '') active @endif active"
                            data-target="client-dashboard">
                            <img src="{{ asset('frontend/images/logo.png') }}" alt="{{ __('Logo') }}"
                                class="w-48 p-3 mx-auto ">
                        </a>
                    </div>
                    <div>
                        <ul class="">
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary transition-all duration-300"
                                data-target="my_orders">
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="shopping-cart"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Orders') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item  dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="my_containers">
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
                                <a href="#" class="flex items-center gap-2 p-3"><i data-lucide="info"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('My Inquiries') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300"
                                data-target="update_profile">
                                <a href="javascript:void(0)" class="flex items-center gap-2 p-3"><i data-lucide="user"
                                        class="bg-bg-tertiary text-text-white rounded p-1 icon-hover-effect"></i><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize text-hover-effect">{{ __('Update Profile') }}</span>
                                </a>
                            </li>
                            <li class="group nav_item dark:hover:bg-bg-dark-tertiary  transition-all duration-300">
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
                    <div class="h-full border-none bg-bg-gray dark:bg-opacity-20">
                        {{-- Mobile Sidebar --}}
                        @include('frontend.includes.user_dashboard_mobile')
                        <div>
                            <div class="">
                                <div class="flex items-center gap-4 ps-10 py-12">
                                    <span class="openUsreDashboardSidebar xl:hidden"><i data-lucide="menu"
                                            class="w-6 h-6 md:w-8 md:h-8 bg-bg-primary text-text-white hover:bg-bg-tertiary transition-all duration-300 rounded-md p-1 "></i></span>
                                    <h2 class="text-2xl  lg:text-4xl uppercase font-bold{{-- bg-bg-light dark:bg-bg-dark-tertiary --}}">
                                        {{ __('Client Dashboard') }}</h2>
                                </div>
                            </div>
                        </div>
                        <div id="client-dashboard" class="nav-pane block">
                            {{-- Client Dashboard --}}
                            @include('backend.user.includes.client_dashboard')
                        </div>
                        <div id="my_orders" class="nav-pane hidden">
                            @include('backend.user.includes.my_orders')
                        </div>
                        <div id="my_containers" class="nav-pane hidden">
                            {{-- My Containers --}}
                            @include('backend.user.includes.my_containers')
                        </div>
                        <div id="my_bids" class="nav-pane hidden">
                            <div class=" p-10 pt-0">
                                <div class="max-w-6xl mx-auto">
                                    {{-- My Bids --}}
                                    @include('backend.user.includes.my_bids')
                                </div>
                            </div>
                        </div>
                        <div id="my_inquiries" class="nav-pane hidden">
                            @include('backend.user.includes.my_inquiries')
                        </div>
                        <div id="update_profile" class="nav-pane hidden @if (isset($page_slug) && $page_slug == 'dashboard') active @endif">
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
                    .removeClass('active');
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
        $(document).ready(function() {
            $('.btn-item').on('click', function(e) {
                e.preventDefault();
                var dataTab = $(this).data('tab');

                // Toggle button styles
                $('.btn-item')
                    .removeClass('bg-bg-tertiary')
                    .addClass('bg-bg-primary');
                $(this)
                    .removeClass('bg-bg-primary')
                    .addClass('bg-bg-tertiary');

                // Filter containers
                var visibleCount = 0;
                $('.container-card').each(function() {
                    var cardStatus = $(this).data('status');
                    if (dataTab === 'all' || dataTab === cardStatus) {
                        $(this).removeClass('hidden').addClass('block');
                        visibleCount++;
                    } else {
                        $(this).removeClass('block').addClass('hidden');
                    }
                });

                // Toggle "No Containers Found" message
                if (visibleCount === 0) {
                    $('#no-containers-message').removeClass('hidden').addClass('block');
                } else {
                    $('#no-containers-message').removeClass('block').addClass('hidden');
                }
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
