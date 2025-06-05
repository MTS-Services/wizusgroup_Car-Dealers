@extends('frontend.layouts.app', ['page_slug' => 'checkout'])
@section('title', 'Checkout')

@section('content')
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4 text-sm">
        <ul class="flex items-center gap-2 ">
            <li>
                <a href="#" class="text-text-gray hover:text-text-accent">{{ __('Home') }}</a>
            </li>
            <li class="relative bracamb-dot">
                <span class="font-midium">{{ __('Checkout') }}</span>
            </li>
        </ul>
    </div>

    <!-- Header -->
    <div class="container mx-auto px-4 py-8 text-center">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-4xl font-semibold">{{ __('Checkout') }}</h1>
        </div>
    </div>
    {{-- Main Content Start Here --}}
    <div class="container">
        <div class="flex flex-col lg:flex-row gap-8 my-10">
            <!-- Left Column - Checkout Form -->
            <div class="lg:w-2/3 bg-bg-white p-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary">
                <form action="{{ route('frontend.checkout-order.submit') }}" method="POST">
                    @csrf
                    @auth('web')
                    @else
                        <div class="mb-8">
                            <h2 class="text-lg lg:text-xl capitalize font-medium mb-6">
                                {{ __('Resigtration form') }}
                            </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <input type="text" name="first_name" placeholder="First Name" class="input h-10">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'first_name']" />
                                </div>
                                <div>
                                    <input type="text" name="last_name" placeholder="Last Name" class="input h-10">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'last_name']" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <input type="email" name="email" placeholder="Email" class="input h-10">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                                </div>
                                <div>
                                    <input type="text" name="whatsapp" placeholder="whatsapp" class="input h-10">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'whatsapp']" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                                <div class="flex flex-wrap lg:flex-row gap-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="language" id="language1" value="english" checked>
                                        <label for="language1" class="ml-2 text-text-gray">English</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="language" id="language2" value="french">
                                        <label for="language2" class="ml-2 text-text-gray">{{ __('French') }}</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="language" id="language3" value="argentina">
                                        <label for="language2" class="ml-2 text-text-gray">{{ 'Argentina' }}</label>
                                    </div>
                                </div>
                                <div>
                                    <select name="gender" id="gender" class="input">
                                        <option value="" selected hidden>{{ __('Select Gender') }}</option>
                                        @foreach (App\Models\AuthBaseModel::getGenderLabels() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'gender']" />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <input type="password" name="password" placeholder="Password" class="input h-10">
                                    <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'password']" />
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                        class="input h-10">
                                </div>
                            </div>
                        </div>
                    @endauth

                    <h2 class="text-lg lg:text-xl capitalize font-medium mb-6">{{ __('Delivery Information') }}</h2>
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <div>
                            <input type="text" placeholder="Name" name="name"
                                value="{{ user() ? user()->name : old('name') }}" class="input h-10">
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div>
                            <input type="email" placeholder="Email" name="d_email"
                                value="{{ user() ? user()->email : old('email') }}" class="input h-10">
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <div>
                            <input type="text" placeholder="Phone" name="phone"
                                value="{{ user() ? user()->phone : old('phone') }}" class="input h-10">
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'phone']" />
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
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">
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
                            <input type="text" name="zipcode" placeholder="Zipcode/Postal" class="input h-10">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                        <div>
                            <select name="shipping_port" class="input" id="shipping_port">
                                <option value="" selected disabled>{{ __('Select Shipping Port') }}</option>
                                @foreach ($shipping_locations as $shipping_port)
                                    <option value="{{ $shipping_port->id }}"
                                        {{ old('shipping_port') == $shipping_port->id ? 'selected' : '' }}>
                                        {{ $shipping_port->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'shipping_port']" />
                        </div>
                        <div>
                            {{-- Detination --}}
                            <select name="destination" id="destination" class="input">
                                <option value="" selected disabled>{{ __('Select Destination Port') }}</option>
                                @foreach ($shipping_locations as $shipping_port)
                                    <option value="{{ $shipping_port->id }}"
                                        {{ old('shipping_port') == $shipping_port->id ? 'selected' : '' }}>
                                        {{ $shipping_port->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <textarea name="address" class="textarea no-ckeditor5" id="address" placeholder="Address">{{ old('address') }}</textarea>
                    </div>

                    <!-- Shipping Method -->
                    <h2 class="text-xl font-medium mb-4">{{ __('Shipping Method') }}</h2>
                    <div class="space-y-4 mb-8">
                        <div
                            class="payment-option flex justify-center items-center gap-2 border border-border-dark border-opacity-20 dark:border-white  dark:bg-bg-primary dark:bg-opacity-10 dark:border-opacity-30 focus:outline-primary focus:opacity-50 rounded p-2 text-sm w-full h-15">
                            <input type="radio" id="shipping_method" name="shipping_method" class="w-4">
                            <label for="shipping_method" class="w-full">
                                <div class="flex justify-between">
                                    <span>{{ __('Group Shipping') }}</span>
                                </div>
                            </label>
                        </div>
                        <div
                            class="payment-option flex justify-center items-center gap-2 border border-border-dark border-opacity-20 dark:border-white  dark:bg-bg-primary dark:bg-opacity-10 dark:border-opacity-30 focus:outline-primary focus:opacity-50 rounded p-2 text-sm w-full h-15">
                            <input type="radio" id="express-shipping" name="shipping_method" class="w-4">
                            <label for="express-shipping" class="w-full">
                                <div class="flex justify-between">
                                    <span>{{ __('Full Container') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Privacy Policy -->
                    <p class="text-sm text-text-primary mb-8">
                        {{ __('Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our') }}
                        <a href="#" class="text-text-accent hover:underline">{{ __('Privacy Policy') }}</a>.
                    </p>
                </form>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:w-1/3">
                <div class="sticky top-20 bg-bg-white p-6 shadow-card dark:bg-bg-dark-tertiary rounded-lg">
                    <h2 class="text-lg font-semibold mb-6">{{ __('In your cart') }}</h2>

                    <!-- Cart Items -->
                    <div class="space-y-6 mb-6" id="cart-items-container">
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
                                                class="decrease-quantity quantity-btn btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                                title="Decrease Quantity" data-id="{{ $item->id }}"
                                                data-current-item-quantity="{{ $item->quantity }}">
                                                <i data-lucide="minus"
                                                    class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                                            </button>
                                            <span
                                                class="quantity-show px-3 py-1 bg-bg-light dark:bg-bg-darkTertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">{{ $item->quantity }}</span>
                                            <button
                                                class="increase-quantity quantity-btn btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                                title="Increase Quantity" data-id="{{ $item->id }}"
                                                data-current-item-quantity="{{ $item->quantity }}">
                                                <i data-lucide="plus"
                                                    class="w-4 h-4 group-hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                                            </button>
                                        </div>
                                        <button
                                            class="remove btn btn-ghost btn-circle text-text-gray hover:text-red-600 transition-colors"
                                            title="Remove Item" data-id="{{ $item->id }}">
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
                            <span>{{ __('Subtotal:') }}</span>
                            <span class="font-medium order-subtotal"
                                id="subtotal">{{ number_format($order->sub_total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>{{ __('Discount:') }}</span>
                            <span class="font-medium">{{ __('-$0 USD') }}</span>
                        </div>
                    </div>

                    <div
                        class="border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-30 mt-4 pt-4">
                        <div class="flex justify-between text-lg font-medium">
                            <span>{{ __('Total:') }}</span>
                            <span class="order-total">{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    <x-frontend.primary-button bg="false" form="checkout-form"
                        class="w-full mt-6">{{ __('Place Order') }} </x-frontend.primary-button>
                </div>
            </div>

        </div>
    </div>
    </div>
    {{-- Main Content End Here --}}
@endsection
@push('js')
    <script src="{{ asset('frontend/js/checkout.js') }}"></script>
    <script>
        // Get Country States By Axios
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });

            if (`{{ old('country_id') }}`) {
                getStatesOrCity('{{ old('country_id') }}', route1, '{{ old('state_id') }}');
            }

            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            if (`{{ old('state_id') }}`) {
                getCities('{{ old('state_id') }}', route2, '{{ old('city_id') }}');
            }


            // let updateQuantityRoute = "{{ route('frontend.checkout.quantity-update') }}";
            // let subTotal = 0;

            // $(document).on('click', '.increase-quantity', function() {
            //     let itemId = $(this).data('id');
            //     let currentQuantity = $(this).data('current-item-quantity');
            //     let quantity = currentQuantity + 1;
            //     updateQuantity(itemId, quantity, updateQuantityRoute, $(this));
            // });

            // $(document).on('click', '.decrease-quantity', function() {
            //     let itemId = $(this).data('id');
            //     let currentQuantity = $(this).data('current-item-quantity');
            //     let quantity = currentQuantity - 1;
            //     updateQuantity(itemId, quantity, updateQuantityRoute);
            // });

            // $(document).on('click', '.remove', function() {
            //     let removeItemRoute = "{{ route('frontend.checkout.remove-item') }}";
            //     let itemId = $(this).data('id');
            //     axios.post(removeItemRoute, {
            //             item_id: itemId
            //         })
            //         .then(function(response) {
            //             console.log(response.data);
            //             // location.reload();
            //         })
            //         .catch(function(error) {
            //             // Handle error response
            //             console.error(error);

            //         });
            // });

            // function updateQuantity(itemId, quantity, updateQuantityRoute) {
            //     axios.post(updateQuantityRoute, {
            //             item_id: itemId,
            //             quantity: quantity
            //         })
            //         .then(function(response) {
            //             $('.order-subtotal').text('$' + numberFormat(response.data.order_subtotal, 2));
            //             $('.order-total').text('$' + numberFormat(response.data.order_total, 2));
            //             $('.quantity-show').text(response.data.quantity);
            //             $('.item-subtotal').text('$' + numberFormat(response.data.item_subtotal, 2));
            //             $(`.quantity-btn[data-id="${itemId}"]`).attr('data-current-item-quantity', response.data
            //                 .quantity);
            //         })
            //         .catch(function(error) {
            //             // Handle error response
            //             console.error(error);
            //         });
            // }


            // Usage Example:
            // Initialize the cart manager
            const cartManager = new SimpleCartManager({
                routes: {
                    updateQuantity: `{{ route('frontend.checkout.quantity-update') }}`,
                    removeItem: 'frontend.checkout.remove-item'
                },
                debug: true,
                notifications: {
                    enabled: true,
                    type: 'console' // or 'toastr', 'alert', 'custom'
                }
            });

        });
    </script>
@endpush
