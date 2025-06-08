@extends('frontend.layouts.app', ['page_slug' => 'cart'])
@section('title', 'Cart')
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
                            <thead
                                class="border-y border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50">
                                <tr>
                                    <th class="py-4 text-left font-medium">Image</th>
                                    <th class="py-4 text-left font-medium">Name</th>
                                    <th class="py-4 text-left font-medium">Price</th>
                                    <th class="py-4 text-left font-medium">Quantity</th>
                                    <th class="py-4 text-left font-medium">Total</th>
                                    <th class="py-4 text-left font-medium w-[5%]">Action</th>
                                </tr>
                            </thead>
                            <tbody
                                class="border-b border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50"
                                id="cart-table-body">
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-text-gray dark:text-text-white">
                                        <p id="cart-empty-message">
                                            {{-- Loader --}}
                                            <span class=""></span>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"
                                        class="border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50">
                                        <div class="total_price">
                                            <p class="text-right text-text-gray dark:text-text-white mr-36 font-bold">
                                                {{ __('Subtotal: ') }} <span
                                                    class="font-bold text-lg text-bg-primary whitespace-nowrap cart-total ml-5"></span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="flex justify-end mt-10">

                        <form action="{{ route('frontend.checkout.submit') }}" method="POST">
                            @csrf
                            <div class="flex gap-2 items-center">
                                <div class="terms">
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" value="1" name="terms"
                                            class="checkbox checkbox-xs checkbox-accent">
                                        <span class="label text-sm">
                                            <span>{{ __('I agree with') }}</span>
                                            <a href="#"
                                                class="underline text-text-gray hover:text-bg-primary transition-colors">
                                                {{ __('terms and conditions') }}
                                            </a>
                                        </span>
                                    </label>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'terms']" />
                                </div>
                                <x-frontend.primary-button type="submit" button="true" class="w-40">{{ __('Checkout') }}
                                </x-frontend.primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.cartManager = new CartManager({
                uiType: 'table',
                routes: {
                    add: '{{ route('frontend.cart.add') }}',
                    remove: '{{ route('frontend.cart.remove') }}',
                    update: '{{ route('frontend.cart.update-quantity') }}',
                    items: '{{ route('frontend.cart.items') }}'
                },
                selectors: {
                    tableBody: '#cart-table-body',
                    emptyMessage: '#cart-empty-message',
                    totalDisplay: '.cart-total'
                }
            });
        })
    </script>
@endpush
