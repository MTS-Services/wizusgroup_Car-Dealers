@extends('frontend.layouts.app', ['page_slug' => 'contact'])
@section('title', 'Contact')
@section('content')
    {{--  Hero Section --}}
    <section class="relative h-[200px] xl:h-[300px] flex items-center">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('frontend/images/5124556.jpg') }}" alt="Industrial machinery"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-bg-black bg-opacity-40"></div>
        </div>
        <div class="container mx-auto px-6 z-10 relative">
            <h1 class="text-text-white text-4xl md:text-5xl xl:text-6xl text-center font-bold leading-tight w-full">
                {{ __('Contact Us') }}
            </h1>
        </div>
    </section>
    <section class="pb-15 pt-10 dark:bg-bg-dark-tertiary">
        <div class="container">
            <div class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-1/2">
                    <h2 class="text-xl md:text-2xl xl:text-3xl font-semibold capitalize pb-3">
                        {{ __('Send Us and Inquiry') }}</h2>
                    <div class="shadow-card bg-bg-light dark:bg-opacity-20 rounded-md p-6">
                        <form action="{{ route('frontend.contact-store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1  gap-4">
                                <div class="w-full mb-3">
                                    <label class="input">
                                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5"
                                                fill="none" stroke="currentColor">
                                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </g>
                                        </svg>
                                        <input type="text" placeholder="name" name="name" />
                                    </label>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'name']" />
                                </div>
                                <div class="w-full mb-3">
                                    <label class="input">
                                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5"
                                                fill="none" stroke="currentColor">
                                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                            </g>
                                        </svg>
                                        <input type="email" placeholder="Email" name="email" />
                                    </label>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                                </div>
                            </div>
                            <div class="w-full mb-3">
                                <label for="message"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Message') }}</label>
                                <textarea name="message" id="message" placeholder="Message" class="input h-20 rounded-md w-full pt-2"></textarea>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="btn-primary py-2 mt-6 rounded-md w-full hover:bg-bg-tertiary">{{ __('Send Message') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 overflow-hidden rounded-lg">
                    <h2 class="text-xl md:text-2xl xl:text-3xl font-semibold capitalize pb-3">{{ __('Our Offices') }}</h2>
                    <div class="h-full shadow-card rounded-md bg-bg-light dark:bg-opacity-20 p-6">
                        <div class="flex items-center gap-4 mb-10 text-sm lg:text-base text-center lg:text-left mt-2">
                            <div class="w-1/2">
                                <a class="btn-primary rounded-md w-full py-2 px-0 hover:bg-bg-tertiary"
                                    href="https://wa.me/+8{{ settings('whatsapp') ?? '+8801888888888' }}?text="
                                    target="_blank">+8{{ __('WhatsApp Us') }}</a>
                            </div>
                            <div class="w-1/2">
                                <a class="btn-primary rounded-md w-full py-2 px-0 hover:bg-bg-tertiary"
                                    href="tel:+8{{ settings('phone') ?? '+8801888888888' }}">+8{{ settings('phone') ?? '+8801888888888' }}</a>
                            </div>
                        </div>
                        <p class="pb-2 text-base lg:me-40 text-text-primary dark:text-text-white font-semibold capitalize">
                            {{ 'Head Office' }}</p>
                        <div class="text-base pb-4">
                            <p class="mb-2"><strong><i data-lucide="map-pin" class="inline"></i> </strong>
                                <a class="text-text-primary dark:text-text-white"
                                    href="javaScript:void(0)">{{ settings('address') ?? 'Dhaka, Bangladesh' }}</a>
                            </p>
                            <p class="mb-2"><strong><i data-lucide="mail" class="inline"></i></strong>
                                <a class="text-text-primary dark:text-text-white hover:text-text-secondary hover:underline duration-300 ease-linear"
                                    href="mailto:{{ settings('email') ?? 'support.wizglobal@gmail.com' }}">{{ settings('email') ?? 'support.wizglobal@gmail.com' }}</a>
                            </p>
                        </div>
                        @if (settings('office_infos') && is_array(json_decode(settings('office_infos'), true)))
                            @foreach (json_decode(settings('office_infos'), true) as $office_info)
                                <p
                                    class="pb-2 text-base lg:me-40 text-text-primary dark:text-text-white font-semibold capitalize">
                                    {{ $office_info['country'] }}</p>
                                <div class="text-base pb-4">
                                    @if ($office_info['location'])
                                        <p class="mb-2">
                                            <strong><i class="inline" data-lucide="map-pin"></i></strong>
                                            <a class="text-text-primary dark:text-text-white"
                                                href="#">{{ $office_info['location'] }}</a>
                                        </p>
                                    @endif
                                    @if ($office_info['email'])
                                        <p class="mb-2">
                                            <strong><i class="inline" data-lucide="mail"></i></strong>
                                            <a class="text-text-primary dark:text-text-white hover:text-text-secondary hover:underline duration-300 ease-linear"
                                                href="mailto:{{ $office_info['email'] }}">{{ $office_info['email'] }}</a>
                                        </p>
                                    @endif
                                    @if ($office_info['phone'])
                                        <p class="mb-2">
                                            <strong><i class="inline" data-lucide="phone"></i></strong>
                                            <a class="text-text-primary dark:text-text-white"
                                                href="#">{{ $office_info['phone'] }}</a>
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <section class="pt-15">
                <div class="rounded-md overflow-hidden">
                    <iframe
                        src="{{ settings('map_url' ?? 'https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d51856.3358057422!2d139.60882750083385!3d35.67648520602899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2sTokyo!3m2!1d35.6764225!2d139.650027!4m5!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2sTokyo%2C%20Japan!3m2!1d35.6764225!2d139.650027!5e0!3m2!1sen!2sbd!4v1747217456466!5m2!1sen!2sbd') }}"
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
        </div>
    </section>
@endsection
