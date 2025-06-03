<!-- Sidebar -->
<div
    class="cartSidebar fixed top-0 right-0 min-h-screen h-full w-5/6 md:w-1/2 lg:w-1/2 xl:w-2/5 2xl:w-1/4 translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto py-5">
        <div class="h-100 overflow-auto">
            <div class="flex justify-between items-center border-b border-b-border-dark border-opacity-20 dark:border-white dark:border-opacity-50 p-4">
                <h4 class="text-xl font-medium">{{ __('Cart Summary') }}</h4>
                <button class="closeCartSidebar" title="Close Sidebar">
                    <span
                        class="w-10 h-10 flex items-center justify-center bg-bg-white rounded-full text-text-gray">
                        <i data-lucide="x" class="text-lg"></i>
                    </span>
                </button>
            </div>
            <div id="checkout-cart-items">
                {{-- Cart Items --}}
            </div>
        </div>

        {{-- Cechout Card --}}
        <div class="h-[210px]">
            <div
                class="p-6 border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50 mt-5 bg-bg-light dark:bg-bg-darkSecondary shadow-card w-full fixed bottom-0">
                <div class="flex justify-between mb-1">
                    <span class="font-medium">Total:</span>
                    <span class="font-medium cart-total">$220.00 USD</span>
                </div>
                <p class="text-sm text-text-gray mb-4">Taxes and shipping calculated at checkout</p>

                <label class="flex items-center mb-4  border-t border-border-light dark:border-opacity-50 pt-5">
                    <input type="checkbox" class="p-0 form-checkbox h-4 w-4 text-text-gray">
                    <span class="ml-2 text-sm">I agree with <a href="#" class="underline">term and
                            conditions</a></span>
                </label>

                <div class="flex justify-around items-center mt-8">
                    <a href="{{ route('frontend.cart') }}" class="btn-primary ">View Cart</a>
                    <a href="{{ route('frontend.checkout') }}" class="btn-primary">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
