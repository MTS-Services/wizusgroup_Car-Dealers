@extends('frontend.layouts.app', ['page_slug' => 'checkout'])
@section('title', 'Checkout')

@section('content')
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4 text-sm">
        <ul class="flex items-center gap-2 ">
            <li>
                <a href="#" class="text-text-gray hover:text-text-accent">Home</a>
            </li>
            <li class="relative bracamb-dot">
                <span class="font-midium">Checkout</span>
            </li>
        </ul>
    </div>

    <!-- Header -->
    <div class="container mx-auto px-4 py-8 text-center">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-4xl font-semibold">Checkout</h1>
        </div>
    </div>
    {{-- Main Content Start Here --}}
    <div class="container">
        <div class="flex flex-col lg:flex-row gap-8 my-10">
            <!-- Left Column - Checkout Form -->
            <div class="lg:w-2/3 bg-bg-white p-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary">
                <h2 class="text-xl font-medium mb-6">{{ __('Delivery Information') }}</h2>
                <form id="checkout-form">
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <div>
                            <input type="text" placeholder="Name" class="input h-10">
                        </div>
                        <div>
                            <input type="email" placeholder="Email" class="input h-10">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <div>
                            <input type="text" placeholder="Phone" class="input h-10">
                        </div>

                        <div class="">
                            <select name="country" id="country" class="input h-10">
                                <option value="" selected hidden>{{ __('Select Country') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'country']" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <select name="state" id="state" disabled class="input h-10">
                                <option value="" selected hidden>{{ __('Select State') }}</option>
                            </select>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'state']" />
                        </div>
                        <div>
                            <select name="city" id="city" disabled class="input h-10">
                                <option value="" selected hidden>{{ __('Select City') }}</option>
                            </select>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'city']" />
                        </div>
                        <div>
                            <input type="text" placeholder="Zipcode/Postal" class="input h-10">
                        </div>
                    </div>

                    <div class="mb-4">
                        <textarea name="address" class="input h-20 p-3 no-ckeditor5" id="address"></textarea>
                    </div>

                    <!-- Shipping Method -->
                    <h2 class="text-xl font-medium mb-4">Shipping Method</h2>
                    <div class="space-y-4 mb-8">
                        <div
                            class="payment-option flex justify-center items-center gap-2 border border-border-dark border-opacity-20 dark:border-white  dark:bg-bg-darkTertiary dark:border-opacity-30 focus:outline-primary focus:opacity-50 rounded p-2 text-sm w-full h-15">
                            <input type="radio" id="free-shipping" name="shipping" class="w-4">
                            <label for="free-shipping" class="w-full">
                                <div class="flex justify-between">
                                    <span>{{ __('Group Shipping') }}</span>
                                    <span class="font-medium">$0.00</span>
                                </div>
                            </label>
                        </div>
                        <div
                            class="payment-option flex justify-center items-center gap-2 border border-border-dark border-opacity-20 dark:border-white  dark:bg-bg-darkTertiary dark:border-opacity-30 focus:outline-primary focus:opacity-50 rounded p-2 text-sm w-full h-15">
                            <input type="radio" id="express-shipping" name="shipping" class="w-4">
                            <label for="express-shipping" class="w-full">
                                <div class="flex justify-between">
                                    <span>{{ __('Full Container') }}</span>
                                    <span class="font-medium">$10.00</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Privacy Policy -->
                    <p class="text-sm text-text-primary mb-8">
                        Your personal data will be used to process your order, support your experience throughout this
                        website, and for other purposes described in our
                        <a href="#" class="text-text-accent hover:underline">privacy policy</a>.
                    </p>
                </form>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:w-1/3">
                <div class="sticky top-20 bg-bg-white p-6 shadow-card dark:bg-bg-dark-tertiary rounded-lg">
                    <h2 class="text-lg font-semibold mb-6">In your cart</h2>

                    <!-- Cart Items -->
                    <div class="space-y-6 mb-6">
                        @foreach ($order->items as $item)
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg shadow-md dark:bg-bg-dark-secondary transition-all duration-200 hover:shadow-lg"
                                data-item-id="{{ $item->id }}">
                                <div class="relative flex-shrink-0">
                                    <img src="{{ storage_url($item->product?->primaryImage->first()?->image) }}"
                                        alt="{{ $item->product?->primaryImage->first()?->alt ?? $item->product?->name }}"
                                        class="w-24 h-24 object-contain rounded-md">
                                </div>
                                <div class="flex-1 flex flex-col justify-between w-full">
                                    <div>
                                        <h3
                                            class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 truncate sm:whitespace-normal">
                                            {{ $item->product?->name }}
                                        </h3>
                                        <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">
                                            {{ $item->product?->brand?->name }}
                                            / {{ $item->product?->model?->name }}</p>
                                        <p class="font-bold text-lg text-bg-primary whitespace-nowrap item-subtotal">
                                            ${{ number_format($item->product?->price * $item->quantity, 2) }}</p>
                                    </div>
                                    <div
                                        class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-5 mt-3 w-full">
                                        <div class="flex items-center gap-2 flex-shrink-0">
                                            <button
                                                class="quantity-decrease btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                                title="Decrease Quantity" data-item-id="{{ $item->id }}"
                                                data-current-quantity="{{ $item->quantity }}">
                                                <i data-lucide="minus"
                                                    class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                                            </button>
                                            <span
                                                class="quantity-display px-3 py-1 bg-bg-light dark:bg-bg-darkTertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">{{ $item->quantity }}</span>
                                            <button
                                                class="quantity-increase btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                                title="Increase Quantity" data-item-id="{{ $item->id }}"
                                                data-current-quantity="{{ $item->quantity }}">
                                                <i data-lucide="plus"
                                                    class="w-4 h-4 group-hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                                            </button>
                                        </div>
                                        <button
                                            class="btn btn-ghost btn-circle remove-item text-text-gray hover:text-red-600 transition-colors"
                                            title="Remove Item" data-item-id="{{ $item->id }}">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div
                        class="border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-30 pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal:</span>
                            <span class="font-medium">$590.00 USD</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Discount:</span>
                            <span class="font-medium">-$10 USD</span>
                        </div>
                    </div>

                    <div
                        class="border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-30 mt-4 pt-4">
                        <div class="flex justify-between text-lg font-medium">
                            <span>Subtotal:</span>
                            <span>$600.00 USD</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <a href="#" type="submit" form="checkout-form" class="btn-primary mt-6 w-full">
                        {{ __('Place Order') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>
    {{-- Main Content End Here --}}
@endsection
@push('js')
    <script>
        // Get Country States By Axios
        $(document).ready(function() {
            $('#country').on('change', function() {
                let route1 = "{{ route('axios.get-states-or-cities') }}";
                getStatesOrCity($(this).val(), route1);
            });
            $('#state').on('change', function() {
                let route2 = "{{ route('axios.get-cities') }}";
                getCities($(this).val(), route2);
            });
        });
    </script>
@endpush
