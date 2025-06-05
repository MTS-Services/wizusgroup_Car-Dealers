<div
    class="cartSidebar fixed top-0 right-0 max-h-screen h-full w-5/6 md:w-1/2 lg:w-1/2 xl:w-2/5 2xl:w-1/4 translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

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
            <div class="px-6 py-2 shadow-card border-t border-border-gray dark:border-bg-dark-secondary">
                <div class="flex justify-between mb-1">
                    <span class="font-medium">{{ __('Total:') }}</span>
                    <span class="font-medium cart-total text-xl"></span>
                </div>
                <p class="text-sm text-text-gray mb-2">{{ __('Taxes and shipping calculated at checkout') }}</p>

                <label class="flex items-center gap-2">
                    <input type="checkbox" value="1" name="terms" class="checkbox checkbox-xs checkbox-accent">
                    <span class="label text-sm">
                        <span>{{ __('I agree with') }}</span>
                        <a href="#" class="underline text-text-gray hover:text-bg-primary transition-colors">
                            {{ __('terms and conditions') }}
                        </a>
                    </span>
                </label>
                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'terms']" />

                <div class="flex items-center justify-between gap-3 mt-2">

                    @csrf
                    <button type="submit" class="btn-primary w-full text-center py-1">{{ __('Checkout') }}</button>

                    <a href="{{ route('frontend.cart') }}"
                        class="btn-secondary w-full text-center py-1 border border-border-dark dark:border-white dark:border-opacity-50 text-text-gray hover:text-text-dark dark:hover:text-white transition-colors">
                        {{ __('View Cart') }}
                    </a>
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
            debug: true // Enable for development
        });
    })
</script>
