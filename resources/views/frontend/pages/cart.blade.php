@extends('frontend.layouts.app', ['page_slug' => 'cart'])
@section('title', 'Cart')
@push('css')
    <style>
        .bracamb-dot::before {
            content: "";
            height: 6px;
            width: 6px;
            border-radius: 50%;
            background-color: #8752FA;
            display: inline-block;
            margin-right: 3px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 16px !important;
        }
    </style>
@endpush
@section('content')
    <div class="bg-bg-lightSecondary dark:bg-bg-darkQuaternary pb-10">
        <div class="container">
            {{-- Breadcrumb --}}
            <div class="container mx-auto px-4 py-4 text-sm">
                <ul class="flex items-center gap-2 ">
                    <li>
                        <a href="#" class="text-text-gray hover:text-text-primary">Home</a>
                    </li>
                    <li class="relative bracamb-dot capitalize">
                        <span class="text-text-black dark:text-text-white font-midium">Cart</span>
                    </li>
                </ul>
            </div>

            {{-- Page Title --}}
            <h1 class="text-3xl font-bold text-center mb-10">Shopping Cart</h1>

            {{-- Free Shipping Progress --}}
            <div class="mb-12 flex flex-col items-center justify-center">
                <p class="mb-4">Shipping charges apply to all orders.</p>
                <div class="shipping w-[400px]">
                    <div class="w-full h-2 bg-bg-primary bg-opacity-30 rounded-full relative mt-5">
                        <span
                            class="absolute left-0 top-[50%] translate-y-[-50%] text-text-white bg-bg-primary w-10 h-10 rounded-full flex items-center justify-center"><i
                                data-lucide="truck" class=""></i></span>
                    </div>
                </div>
            </div>

            <div class=" mt-5">
                {{-- Cart Items Section --}}
                <div class="w-full bg-bg-light dark:bg-bg-dark-tertiary p-10 pt-15 rounded-md">
                    {{-- Cart Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-y border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50">
                                <tr>
                                    <th class="py-4 text-left font-medium">Product</th>
                                    <th class="py-4 text-left font-medium">Price</th>
                                    <th class="py-4 text-left font-medium">Quantity</th>
                                    <th class="py-4 text-left font-medium w-[12%]">Total</th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                {{-- Cartitems will be inserted here by JavaScript --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-center mt-10">
                        {{-- <a href="#" class="btn-primary mt-6 mr-2 rounded-md">{{ __('Continue Shopping') }}</a> --}}
                        <a href="{{ route('frontend.checkout') }}" class="btn-primary rounded-md">{{ __('Proceed to Checkout') }}</a>
                    </div>

                    <!-- Discount Code -->
                    {{-- <div class="mt-6 flex">
                        <input type="text" placeholder="Discount code"
                            class="input w-96">
                        <button class="btn-primary ml-2 rounded-md">Apply</button>
                    </div>

                    <!-- Special Instructions -->
                    <div class="mt-6">
                        <p class="font-medium mb-2">Special Instructions for seller</p>
                        <textarea
                            class="input h-28 border border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50"></textarea>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection