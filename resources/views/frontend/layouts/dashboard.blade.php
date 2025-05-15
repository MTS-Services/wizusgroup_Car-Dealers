@extends('frontend.layouts.app', ['page_slug' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    <section class="py-15 ">
        <div class="container">
            <div class="flex shadow-card rounded-xl overflow-hidden">
                <div class=" w-1/4 bg-bg-light dark:bg-opacity-30">
                    <div class="bg-bg-tertiary bg-opacity-50">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="{{ __('Logo') }}" class="w-48 p-3 mx-auto ">
                    </div>
                    <div>
                        <ul>
                            <li>
                                <a href="#" class="flex items-center gap-2 p-3"><span><i
                                            data-lucide="menu" class="bg-bg-tertiary text-text-white rounded p-1"></i></span><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize">{{ __('My Orders') }}</span></a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center gap-2 p-3"><span><i
                                            data-lucide="container" class="bg-bg-tertiary text-text-white rounded p-1"></i></span><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize">{{ __('My Containers') }}</span></a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center gap-2 p-3"><span><i
                                            data-lucide="dollar-sign" class="bg-bg-tertiary text-text-white rounded p-1"></i></span><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize">{{ __('Payments') }}</span></a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center gap-2 p-3"><span><i
                                            data-lucide="mail" class="bg-bg-tertiary text-text-white rounded p-1"></i></span><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize">{{ __('Messages') }}</span></a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center gap-2 p-3"><span><i
                                            data-lucide="user" class="bg-bg-tertiary text-text-white rounded p-1"></i></span><span
                                        class="text-lg text-text-primary dark:text-text-white font-semibold capitalize">{{ __('Update Profile') }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full lg:w-3/4">
                    {{-- Client Dashboard --}}
                    <div class="bg-bg-gray dark:bg-opacity-20">
                        <h2 class="text-2xl  lg:text-4xl uppercase font-bold py-12{{-- bg-bg-light dark:bg-bg-dark-tertiary --}} ps-10">{{ __('Client Dashboard') }}</h2>
                        <div class="flex flex-wrap gap-10 items-center p-10">
                            <div class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span><i data-lucide="menu" class="w-10 h-10 bg-bg-gray  dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                    <span class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Orders') }}</span>
                                </div>
                                <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">{{ __('3') }}</h3>
                            </div>
                            <div class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span><i data-lucide="container" class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                    <span class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Containers') }}</span>
                                </div>
                                <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">{{ __('1') }}</h3>
                            </div>
                            <div class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span><i data-lucide="dollar-sign" class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                    <span class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Payments') }}</span>
                                </div>
                                <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">{{ __('$8,200') }}</h3>
                            </div>
                            <div class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span><i data-lucide="mail" class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                                    <span class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Messages') }}</span>
                                </div>
                                <h3 class="text-4xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">{{ __('2') }}</h3>
                            </div>
                            <div class="w-96 lg:max-w-md shadow-card ps-5  lg:ps-10 py-5 bg-bg-white dark:bg-opacity-30  rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Update Profile') }}</span>
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
            $('.btn_item').on('click', function() {
                $('.btn_item').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('.tab-pane').removeClass('active');
                $('#' + target).addClass('active');
            });
        });
    </script>
@endpush
