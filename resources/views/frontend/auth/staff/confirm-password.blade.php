@extends('frontend.layouts.app')
@section('content')
    <section class="py-20">
        <div class="container">
            <div
                class="flex flex-col md:flex-row shadow-shadowPrimary shadow-shadow-dark/10 dark:shadow-shadow-light/10 rounded-2xl w-full overflow-hidden bg-bg-white dark:bg-bg-darkTertiary">
                <!-- Left Side: Form -->
                <div class="w-full xl:w-1/2 p-10 md:p-12 flex flex-col justify-center">
                    <h2 class="text-3xl font-semibold text-center mb-6">{{ __('Confirm Password') }}</h2>
                    <form class="space-y-5" action="{{ route('password.confirm') }}" method="POST">
                        @csrf

                        <p class="text-sm text-text-primary dark:text-text-light">
                            {{ __('Please confirm your password before continuing.') }}
                        </p>
                        {{-- Password Field --}}
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
                                <input type="password" placeholder="Password" name="password"
                                    autocomplete="current-password" required />
                                <button type="button"
                                    class="showpassword absolute top-1/2 right-1 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full text-text-white bg-bg-accent bg-opacity-70 hover:bg-opacity-100 hover:text-text-white transition-all duration-300 ease-linear">
                                    <i data-lucide="eye-off" class="w-4 h-4"></i>
                                </button>
                            </label>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
                        </div>

                        <div class="mt-5 flex justify-center sm:justify-between items-center gap-5 flex-wrap">
                            <button type="submit" class="btn-primary">{{ __('Confirm Password') }}</button>
                            @if (Route::has('password.request'))
                                <p class="text-center text-sm mt-4">
                                    {{ __('Forgot password?') }} <a href="{{ route('password.request') }}"
                                        class="text-text-tertiary font-medium">
                                        {{ __('Reset password') }} </a>
                                </p>
                            @endif
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
@push('js')
    <script src="{{ asset('frontend/js/password.js') }}"></script>
@endpush
