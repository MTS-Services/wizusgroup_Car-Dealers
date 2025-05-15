@extends('frontend.layouts.app', ['page_slug' => 'contact'])
@section('title', 'Contact')
@section('content')
    <section class="pt-10">
        <div class="container">
            <div class="flex flex-col lg:flex-row gap-10">
                <div class="w-full lg:w-1/2">
                    <h2 class="text-2xl lg:text-3xl font-semibold capitalize pb-3">{{ __('Contact us') }}</h2>
                    <div class="shadow-card bg-bg-light dark:bg-opacity-20 rounded-md p-6">
                        <h2 class="text-lg lg:text-xl font-bold pb-3">{{ __('Send Us and Iquery') }}</h2>
                        <form action="javaScript:void(0)" method="POST">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div class="w-full mb-3">
                                    <label for="name"
                                        class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Name') }}</label>
                                    <input class="input rounded-md w-full" type="text" name="name" id="name"
                                        class="input h-12">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="email"
                                        class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Email') }}</label>
                                    <input class="input rounded-md w-full" type="email" name="email" id="email"
                                        class="input h-12">
                                </div>
                            </div>
                            <div class="w-full mb-3">
                                <label for="subject"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Subject') }}</label>
                                <input class="input rounded-md w-full" type="subject" name="subject" id="subject"
                                    class="input h-12">
                            </div>
                            <div class="w-full mb-3">
                                <label for="message"
                                    class="block text-sm font-medium text-text-primary dark:text-text-white mb-2">{{ __('Message') }}</label>
                                <textarea name="message" id="message" class="input h-20 rounded-md w-full pt-2"></textarea>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="py-2 border-none shadow-md bg-bg-primary hover:bg-bg-tertiary text-text-white mt-6 rounded-md w-full">{{ __('Send Message') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 overflow-hidden rounded-md">
                    <h2 class="text-2xl lg:text-3xl font-semibold capitalize pb-3">{{ __('Our Offices') }}</h2>
                    <div class="h-full shadow-card bg-bg-light dark:bg-opacity-20 p-6">
                        <div class="flex items-center gap-4 mb-10 text-sm lg:text-base text-center lg:text-left">
                            <div class="w-1/2">
                                <button
                                    class="px-0 xs:px-3 py-3 bg-bg-primary hover:bg-bg-tertiary w-full  text-sm md:text-base text-text-light rounded-md">WhatsApp
                                    Us</button>
                            </div>
                            <div class="w-1/2">
                                <button
                                    class="px-0  py-3   bg-bg-primary hover:bg-bg-tertiary w-full  text-sm md:text-base text-text-light rounded-md">+1
                                    (123) 456-789</button>
                            </div>
                        </div>
                        <p class="pb-2 text-base lg:me-40 text-text-primary dark:text-text-white font-semibold">
                            {{ __('Japan') }}</p>
                        <div class="text-base pb-4">
                            <p class="mb-2">
                                <a class="text-text-primary dark:text-text-white"
                                    href="#">{{ __('128 Example Street Tokyo,Japan') }}</a>
                            </p>
                            <p class="mb-2">
                                <a class="text-text-primary dark:text-text-white"
                                    href="#">{{ __('example@gmail.com') }}</a>
                            </p>
                            <p class="mb-2">
                                <a class="text-text-primary dark:text-text-white" href="#">{{ __('+1 234 567') }}</a>
                            </p>
                            <p class="text-text-primary dark:text-text-white">{{ __('Monday-Friday, 9am-6pm') }}</p>
                        </div>
                        <p class="pb-2 text-base lg:me-40 text-text-primary dark:text-text-white font-semibold">
                            {{ __('Africa') }}</p>
                        <p>456 Sample Avenue Accra, Ghana</p>
                    </div>
                </div>
            </div>

            <section>
                <div class="rounded-sm overflow-hidden my-10">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d51856.3358057422!2d139.60882750083385!3d35.67648520602899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e6!4m5!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2sTokyo!3m2!1d35.6764225!2d139.650027!4m5!1s0x605d1b87f02e57e7%3A0x2e01618b22571b89!2sTokyo%2C%20Japan!3m2!1d35.6764225!2d139.650027!5e0!3m2!1sen!2sbd!4v1747217456466!5m2!1sen!2sbd"
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </section>
        </div>
    </section>
@endsection
