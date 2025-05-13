@extends('frontend.layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-white px-4 py-10">
  <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-2xl w-full max-w-7xl min-h-[600px] overflow-hidden">

    <!-- Left Side: Form -->
    <div class="w-full md:w-1/2 p-10 md:p-12 flex flex-col justify-center">
      <h2 class="text-3xl font-semibold text-center mb-6">{{__('Forgot your password?')}}</h2>

      @if (session('status'))
        <div class="mb-4 text-accent font-medium text-center">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full p-3 border border-light rounded-md focus:ring-2 focus:ring-accent @error('email') border-danger @enderror"
               placeholder="Enter your email">

        @error('email')
          <p class="text-danger text-sm mt-1">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full bg-accent hover:bg-secondary text-white p-3 rounded-md transition">
          Send Password Reset Link
        </button>

        <div class="text-center text-sm mt-4">
          Back to <a href="{{ route('login') }}" class="text-accent hover:underline">Sign in</a>
        </div>
      </form>
    </div>

    <!-- Right Side: Image -->
    <div class="w-full md:w-1/2">
      <img src="{{ asset('/frontend/images/5464026.jpg') }}" alt="Forgot Password" class="w-full h-full object-cover" />
    </div>

  </div>
</div>
@endsection
