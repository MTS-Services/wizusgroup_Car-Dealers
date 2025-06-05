<div
    class="cartSidebar fixed top-0 right-0 max-h-[calc(100vh-100px)] md:max-h-screen w-5/6 md:w-1/2 lg:w-1/2 xl:w-2/5 2xl:w-1/4 translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-tertiary shadow-lg z-[99999999999]">

    <div class="h-screen flex flex-col">
        <div class="p-4 border-b border-b-border-dark border-opacity-20 dark:border-white dark:border-opacity-50">
            <div class="flex justify-between items-center">
                <h4 class="text-xl font-medium">{{ __('Cart Summary') }}</h4>
                <button class="closeCartSidebar" title="Close Sidebar">
                    <span
                        class="w-10 h-10 flex items-center justify-center bg-bg-white rounded-full text-text-gray hover:bg-gray-100 transition-colors">
                        <i data-lucide="x" class="text-lg"></i>
                    </span>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-auto p-4 space-y-4" id="cart-items-container">
            <p class="text-center text-text-gray dark:text-text-white" id="cart-empty-message">
                {{ __('Your cart is empty.') }}</p>
        </div>

        {{-- Checkout Card --}}
        <form action="{{ route('frontend.checkout.submit') }}" method="POST">
            @csrf
            <div
                class="px-6 py-2 border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50 bg-bg-light dark:bg-bg-darkSecondary shadow-card">
                <div class="flex justify-between mb-1">
                    <span class="font-medium">{{ __('Total:') }}</span>
                    <span class="font-medium cart-total text-xl"></span>
                </div>
                <p class="text-sm text-text-gray mb-2">{{ __('Taxes and shipping calculated at checkout') }}</p>

                <label class="flex items-center mb-4 border-t border-border-light dark:border-opacity-50">
                    <input type="checkbox" class="p-0 form-checkbox h-4 w-4 text-text-gray focus:ring-bg-primary">
                    <span class="ml-2 text-sm">I agree with <a href="#"
                            class="underline text-text-gray hover:text-bg-primary transition-colors">terms and
                            conditions</a></span>
                </label>

                <div class="flex items-center justify-between gap-3 pb-6">
                     <x-frontend.primary-button bg="false" type="submit" class="w-full">{{ __('Checkout') }} </x-frontend.primary-button>
                    <x-frontend.primary-button  href="{{ route('frontend.cart') }}" class="w-full">{{ __('View Cart') }} </x-frontend.primary-button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.cartManager = new CartManager({
            uiType: 'sidebar',
            routes: {
                add: '{{ route('frontend.cart.add') }}',
                remove: '{{ route('frontend.cart.remove') }}',
                update: '{{ route('frontend.cart.update-quantity') }}',
                items: '{{ route('frontend.cart.items') }}'
            },
            selectors: {
                sidebar: '.cartSidebar',
                closeSidebar: '.closeCartSidebar',
                itemsContainer: '#cart-items-container',
                emptyMessage: '#cart-empty-message',
                totalDisplay: '.cart-total'
            },
            // debug: true // Enable for development
        });
    })
</script>
