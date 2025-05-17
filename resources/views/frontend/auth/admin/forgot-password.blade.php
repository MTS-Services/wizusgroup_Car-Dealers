@extends('frontend.layouts.app')
@section('content')
    <section class="py-20">
        <div class="container">
            <div
                class="flex flex-col md:flex-row shadow-shadowPrimary shadow-shadow-dark/10 dark:shadow-shadow-light/10 rounded-2xl w-full overflow-hidden bg-bg-white dark:bg-bg-dark-tertiary">
                <div class="w-full xl:w-1/2 p-10 md:p-12 flex flex-col justify-center">
                    <h2 class="text-3xl font-semibold text-center mb-6">{{ __('Reset Administrator Credentials') }}</h2>
                    <form class="space-y-5" action="{{ route('admin.password.forgot.request') }}" method="POST">
                        @csrf
                        <div>
                            @if (session('status'))
                                <div class="text-text-accent text-sm">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <label class="input">
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                        stroke="currentColor">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                    </g>
                                </svg>
                                <input type="text" placeholder="Enter Your Email" name="email" />
                            </label>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                        </div>

                        <div class="mt-5 flex justify-center sm:justify-between items-center gap-5 flex-wrap">
                            <button type="submit" class="btn-primary">{{ __('Send Reset Link') }}</button>
                            <p class="text-center text-sm mt-4">
                                {{ __('Remember password?') }} <a href="{{ route('login') }}"
                                    class="text-text-tertiary font-medium">
                                    {{ __('Sign in') }} </a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Image -->
                <div class="w-1/2 hidden xl:block">
                    <img src="{{ asset('/frontend/images/5464026.jpg') }}" alt="Register Image"
                        class="w-full h-full object-cover" />
                </div>
            </div>
        </div>
    </section>
@endsection
