@extends('frontend.layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="min-h-[50vh] flex flex-col items-center justify-center">
                <h4 class="text-lg text-text-secondary dark:text-text-white">
                    {{ __('A fresh verification link has been sent to your email address.') }}</h4>
                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                <div class="flex items-center justify-center gap-5 mt-8">
                    <p>{{ __('If you did not receive the email') }}</p>
                    <form action="{{ route('admin.verification.resend') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-primary">
                            {{ __('Resend Verification Link') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
