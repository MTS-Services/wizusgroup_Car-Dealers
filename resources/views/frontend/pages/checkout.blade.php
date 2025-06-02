@extends('frontend.layouts.app', ['page_slug' => 'chackout'])
@section('title', 'Chackout')


@section('content')
    <div class="min-h-screen bg-secondary font-inter">
        <!-- Header -->
        <div class="bg-white border-b border-gray">
            <div class="container mx-auto">
                <div
                    class="flex flex-col xs:flex-row items-start xs:items-center justify-between h-auto xs:h-16 py-4 xs:py-0 space-y-3 xs:space-y-0">
                    <div class="flex items-center">
                        <h1 class="text-xl xs:text-2xl font-semibold text-primary">Checkout</h1>
                    </div>

                </div>
            </div>
        </div>

        <div class="container mx-auto py-4 xs:py-6 md:py-8">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 xs:gap-6 md:gap-8">
                <!-- Left Column - Checkout Form -->
                <div class="space-y-4 xs:space-y-6 md:space-y-8 order-2 xl:order-1">
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <div
                            class="flex flex-col xs:flex-row xs:items-center xs:justify-between mb-4 xs:mb-6 space-y-2 xs:space-y-0">
                            <h2 class="text-base xs:text-lg font-medium text-primary">Contact information</h2>
                            {{-- <span class="text-xs xs:text-sm text-gray">Already have an account? <a href="#"
                                    class="text-secondary hover:text-tertiary transition-colors">Log in</a></span> --}}
                        </div>
                    </div>

                    <!-- Container Selection -->
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <h2 class="text-base xs:text-lg font-medium text-primary mb-4 xs:mb-6">Container Selection</h2>
                        <div>
                            <label for="container_name" class="block text-sm font-medium text-primary mb-2">Container
                                Name</label>
                            <select id="container_name" name="container_name"
                                class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors bg-white text-sm xs:text-base">
                                <option value="">Select a container</option>
                                <option value="container-small-20ft">Small Container (20ft)</option>
                                <option value="container-medium-40ft" selected>Medium Container (40ft)</option>
                                <option value="container-large-40ft-hc">Large Container (40ft High Cube)</option>
                                <option value="container-refrigerated-20ft">Refrigerated Container (20ft)</option>
                                <option value="container-refrigerated-40ft">Refrigerated Container (40ft)</option>
                                <option value="container-open-top-20ft">Open Top Container (20ft)</option>
                                <option value="container-open-top-40ft">Open Top Container (40ft)</option>
                                <option value="container-flat-rack-20ft">Flat Rack Container (20ft)</option>
                                <option value="container-flat-rack-40ft">Flat Rack Container (40ft)</option>
                                <option value="container-tank-20ft">Tank Container (20ft)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Delivery -->
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <h2 class="text-base xs:text-lg font-medium text-primary mb-4 xs:mb-6">Delivery</h2>
                        <div class="grid grid-cols-1 gap-4 xs:gap-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 xs:gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-primary mb-2">First
                                        name</label>
                                    <input type="text" id="first_name" name="first_name" value="John"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-primary mb-2">Last
                                        name</label>
                                    <input type="text" id="last_name" name="last_name" value="Doe"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 xs:gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-primary mb-2">Email
                                        address</label>
                                    <input type="email" id="email" name="email" value="john.doe@example.com"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div>
                                <div>
                                    <label for="company" class="block text-sm font-medium text-primary mb-2">Company
                                        (optional)</label>
                                    <input type="text" id="company" name="company" value="ABC Logistics Inc."
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div>

                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-primary mb-2">Address</label>
                                <input type="text" id="address" name="address" value="123 Main Street"
                                    class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                            </div>
                            <div>
                                <label for="apartment" class="block text-sm font-medium text-primary mb-2">Apartment,
                                    suite,
                                    etc. (optional)</label>
                                <input type="text" id="apartment" name="apartment"
                                    class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 xs:gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-primary mb-2">City</label>
                                    <input type="text" id="city" name="city" value="New York"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div>
                                <div>
                                    <label for="state" class="block text-sm font-medium text-primary mb-2">State</label>
                                    <select id="state" name="state"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors bg-white text-sm xs:text-base">
                                        <option value="NY" selected>New York</option>
                                        <option value="CA">California</option>
                                        <option value="TX">Texas</option>
                                        <option value="FL">Florida</option>
                                        <option value="IL">Illinois</option>
                                    </select>
                                </div>
                                {{-- <div class="sm:col-span-2 lg:col-span-1">
                                    <label for="zip" class="block text-sm font-medium text-primary mb-2">ZIP
                                        code</label>
                                    <input type="text" id="zip" name="zip" value="10001"
                                        class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                                </div> --}}
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-primary mb-2">Phone
                                    number</label>
                                <input type="tel" id="phone" name="phone" value="+1 (555) 123-4567"
                                    class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors text-sm xs:text-base">
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <h2 class="text-base xs:text-lg font-medium text-primary mb-4 xs:mb-6">Shipping method</h2>
                        <div class="space-y-3 xs:space-y-4">
                            <label
                                class="flex flex-col xs:flex-row xs:items-center xs:justify-between p-3 xs:p-4 border border-gray rounded-lg xs:rounded-xl cursor-pointer hover:bg-light-secondary transition-colors group">
                                <div class="flex items-center mb-2 xs:mb-0">
                                    <input type="radio" name="shipping" value="standard" checked
                                        class="h-4 w-4 xs:h-4.5 xs:w-4.5 text-primary focus:ring-primary border-gray flex-shrink-0">
                                    <div class="ml-3 xs:ml-4">
                                        <div class="text-sm font-medium text-primary">Standard Shipping</div>
                                        <div class="text-xs xs:text-sm text-gray">7-14 business days</div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-primary ml-7 xs:ml-0">$150.00</span>
                            </label>
                            <label
                                class="flex flex-col xs:flex-row xs:items-center xs:justify-between p-3 xs:p-4 border border-gray rounded-lg xs:rounded-xl cursor-pointer hover:bg-light-secondary transition-colors group">
                                <div class="flex items-center mb-2 xs:mb-0">
                                    <input type="radio" name="shipping" value="express"
                                        class="h-4 w-4 xs:h-4.5 xs:w-4.5 text-primary focus:ring-primary border-gray flex-shrink-0">
                                    <div class="ml-3 xs:ml-4">
                                        <div class="text-sm font-medium text-primary">Express Shipping</div>
                                        <div class="text-xs xs:text-sm text-gray">3-7 business days</div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-primary ml-7 xs:ml-0">$250.00</span>
                            </label>
                            <label
                                class="flex flex-col xs:flex-row xs:items-center xs:justify-between p-3 xs:p-4 border border-gray rounded-lg xs:rounded-xl cursor-pointer hover:bg-light-secondary transition-colors group">
                                <div class="flex items-center mb-2 xs:mb-0">
                                    <input type="radio" name="shipping" value="priority"
                                        class="h-4 w-4 xs:h-4.5 xs:w-4.5 text-primary focus:ring-primary border-gray flex-shrink-0">
                                    <div class="ml-3 xs:ml-4">
                                        <div class="text-sm font-medium text-primary">Priority Shipping</div>
                                        <div class="text-xs xs:text-sm text-gray">1-3 business days</div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-primary ml-7 xs:ml-0">$400.00</span>
                            </label>
                        </div>
                    </div>

                    <!-- Special Instructions -->
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <h2 class="text-base xs:text-lg font-medium text-primary mb-4 xs:mb-6">Special Instructions
                        </h2>
                        <div>
                            <label for="instructions" class="block text-sm font-medium text-primary mb-2">Delivery
                                instructions (optional)</label>
                            <textarea id="instructions" name="instructions" rows="3" xs:rows="4"
                                placeholder="Any special delivery instructions..."
                                class="w-full px-3 xs:px-4 py-2.5 xs:py-3 border border-gray rounded-md xs:rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none text-sm xs:text-base"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary -->
                <div class="order-1 xl:order-2 xl:sticky xl:top-8 xl:h-fit">
                    <div class="bg-white rounded-lg xs:rounded-xl border border-gray p-4 xs:p-6 shadow-card">
                        <h2 class="text-base xs:text-lg font-medium text-primary mb-4 xs:mb-6">Order summary</h2>

                        @php
                            // Container and shipping pricing
                            $containerPrice = 2500.0; // Base container price
                            $shippingPrice = 150.0; // Default standard shipping
                            $handlingFee = 75.0;
                            $insuranceFee = 125.0;
                            $subtotal = $containerPrice + $handlingFee + $insuranceFee;
                            $tax = $subtotal * 0.08;
                            $total = $subtotal + $shippingPrice + $tax;
                        @endphp

                        <!-- Order Totals -->
                        <div class="space-y-3 xs:space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray">Container (40ft)</span>
                                <span class="text-primary font-medium">${{ number_format($containerPrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray">Handling Fee</span>
                                <span class="text-primary font-medium">${{ number_format($handlingFee, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray">Insurance</span>
                                <span class="text-primary font-medium">${{ number_format($insuranceFee, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray">Shipping</span>
                                <span class="text-primary font-medium"
                                    id="shipping-cost">${{ number_format($shippingPrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray">Taxes</span>
                                <span class="text-primary font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="border-t border-gray pt-3 xs:pt-4">
                                <div class="flex justify-between text-base xs:text-lg font-semibold">
                                    <span class="text-primary">Total</span>
                                    <span class="text-primary" id="total-cost">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Complete Order Button -->
                        <div class="mt-6 xs:mt-8">
                            <button type="submit" class="w-full btn-primary">
                                Complete order
                            </button>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-4 xs:mt-6 text-xs text-gray text-center">
                            <p>By completing your order, you agree to our <a href="#"
                                    class="text-secondary hover:text-tertiary">Terms of Service</a> and <a href="#"
                                    class="text-secondary hover:text-tertiary">Privacy Policy</a>.</p>
                        </div>

                        <!-- Security Badge -->
                        <div class="mt-4 xs:mt-6 flex items-center justify-center text-xs xs:text-sm text-gray">
                            {{-- <svg class="w-3 h-3 xs:w-4 xs:h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg> --}}
                            <span class="flex items-center">
                                <span
                                    class="w-1.5 h-1.5 xs:w-2 xs:h-2 bg-wiz_green rounded-full mr-2 flex-shrink-0"></span>
                                Secure Checkout
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Container pricing
            const containerPrices = {
                'container-small-20ft': 1800.00,
                'container-medium-40ft': 2500.00,
                'container-large-40ft-hc': 2800.00,
                'container-refrigerated-20ft': 3200.00,
                'container-refrigerated-40ft': 4500.00,
                'container-open-top-20ft': 2000.00,
                'container-open-top-40ft': 2700.00,
                'container-flat-rack-20ft': 2200.00,
                'container-flat-rack-40ft': 3000.00,
                'container-tank-20ft': 3500.00
            };

            // Shipping pricing
            const shippingPrices = {
                'standard': 150.00,
                'express': 250.00,
                'priority': 400.00
            };

            // Handle container selection
            const containerSelect = document.getElementById('container_name');
            containerSelect.addEventListener('change', function() {
                updatePricing();
            });

            // Handle shipping method selection
            const shippingRadios = document.querySelectorAll('input[name="shipping"]');
            shippingRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updatePricing();
                });
            });

            function updatePricing() {
                const selectedContainer = containerSelect.value;
                const selectedShipping = document.querySelector('input[name="shipping"]:checked').value;

                const containerPrice = containerPrices[selectedContainer] || 2500.00;
                const shippingPrice = shippingPrices[selectedShipping] || 150.00;
                const handlingFee = 75.00;
                const insuranceFee = 125.00;

                const subtotal = containerPrice + handlingFee + insuranceFee;
                const tax = subtotal * 0.08;
                const total = subtotal + shippingPrice + tax;

                // Update the display with animation
                const containerPriceElement = document.querySelector(
                    '.flex.justify-between:first-child .text-primary.font-medium');
                const shippingCostElement = document.getElementById('shipping-cost');
                const totalCostElement = document.getElementById('total-cost');

                // Add fade animation
                [containerPriceElement, shippingCostElement, totalCostElement].forEach(el => {
                    if (el) {
                        el.style.opacity = '0.5';
                        setTimeout(() => {
                            el.style.opacity = '1';
                        }, 150);
                    }
                });

                setTimeout(() => {
                    if (containerPriceElement) containerPriceElement.textContent =
                        `$${containerPrice.toFixed(2)}`;
                    if (shippingCostElement) shippingCostElement.textContent =
                        `$${shippingPrice.toFixed(2)}`;
                    if (totalCostElement) totalCostElement.textContent = `$${total.toFixed(2)}`;
                }, 150);
            }

            // Format phone number input
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    if (value.length <= 3) {
                        value = `+1 (${value}`;
                    } else if (value.length <= 6) {
                        value = `+1 (${value.slice(0, 3)}) ${value.slice(3)}`;
                    } else {
                        value = `+1 (${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6, 10)}`;
                    }
                }
                e.target.value = value;
            });

            // Add smooth focus animations
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('animate-fade-in');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('animate-fade-in');
                });
            });

            // Mobile-specific enhancements
            if (window.innerWidth < 768) {
                // Auto-scroll to order summary after form interactions on mobile
                const formInputs = document.querySelectorAll('input, select, textarea');
                formInputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        // Small delay to ensure keyboard is hidden
                        setTimeout(() => {
                            const orderSummary = document.querySelector('.order-1');
                            if (orderSummary && window.scrollY > orderSummary.offsetTop) {
                                orderSummary.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest'
                                });
                            }
                        }, 300);
                    });
                });
            }
        });
    </script>
@endpush
