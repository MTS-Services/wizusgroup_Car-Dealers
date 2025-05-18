@extends('frontend.layouts.app')
@section('content')
    <section class="py-20">
        <div class="container">
            <div
                class="flex flex-col md:flex-row shadow-shadowPrimary shadow-shadow-dark/10 dark:shadow-shadow-light/10 rounded-2xl w-full overflow-hidden bg-bg-white dark:bg-bg-dark-tertiary">
                <!-- Left Side: Form -->
                <div class="w-full xl:w-1/2 p-10 md:p-12 flex flex-col justify-center">
                    <h2 class="text-3xl font-semibold text-center mb-6">{{ __('Login to Your Account') }}</h2>
                    <form class="space-y-5" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div>
                            <label class="input">
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                        stroke="currentColor">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </g>
                                </svg>
                                <input type="text" placeholder="Username or email" name="login" />
                            </label>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'login']" />
                        </div>
                        <div>
                            <label class="input relative">
                                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                        stroke="currentColor">
                                        <path
                                            d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                                        </path>
                                        <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                    </g>
                                </svg>
                                <input type="password" placeholder="Password" name="password" />
                                <button type="button"
                                    class="showpassword absolute top-1/2 right-1 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full text-text-primary dark:text-text-light hover:text-text-secondary transition-all duration-300 ease-linear">
                                    <i class="fa-regular fa-eye-slash w-4 h-4"></i>
                                </button>
                            </label>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
                        </div>

                        <div class="mt-5 flex justify-center sm:justify-between items-center gap-5 flex-wrap">
                            <button type="submit" class="btn-primary">{{ __('Login') }}</button>
                            <div class="flex items-end flex-col gap-2">
                                <label class="flex items-center justify-end gap-2 text-xs cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-xs">
                                    <span>{{ __('Remember me') }}</span>
                                </label>
                                <p class="text-center text-sm">
                                    {{ __('Forgot password?') }} <a href="{{ route('password.request') }}"
                                        class="text-text-tertiary font-medium">
                                        {{ __('Reset password') }} </a>
                                </p>
                            </div>
                        </div>
                    </form>
                    <div>
                        <div class="divider">{{ __('Or sign up with') }}</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="#" class="btn-primary rounded-md w-full gap-3">
                                <i class='bx bxl-google text-2xl'></i> {{ __('Google') }}
                            </a>
                            <a href="#" class="btn-secondary rounded-md w-full gap-3">
                                <i class='bx bxl-facebook text-2xl'></i> {{ __('Facebook') }}
                            </a>
                        </div>
                        <p class="text-center text-sm mt-4">
                            {{ __('Don\'t have an account?') }} <a href="{{ route('register') }}"
                                class="text-text-tertiary font-medium">
                                {{ __('Sign up') }} </a>
                        </p>
                    </div>
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
@push('js')
    <script src="{{ asset('frontend/js/password.js') }}"></script>
@endpush
