<div
    class="cartSidebar fixed top-0 right-0 min-h-screen h-full w-5/6 md:w-1/2 lg:w-1/2 xl:w-2/5 2xl:w-1/4 translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

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

        <div class="flex-1 overflow-auto p-4 space-y-4">
            {{-- Item 1 --}}

            @forelse (session('cart') as $item)
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg shadow-md dark:bg-bg-dark-secondary transition-all duration-200 hover:shadow-lg">
                    <div class="relative flex-shrink-0">
                        {{-- Image: Removed border classes --}}
                        <img src="{{ storage_url('') }}" alt="Mahindra Yuvo 415 DI Heavy Duty Tractor"
                            class="w-24 h-24 object-contain rounded-md">
                    </div>
                    <div class="flex-1 flex flex-col justify-between w-full">
                        <div>
                            {{-- Product Title: Responsive truncation (truncates on small, normal on sm+) --}}
                            <h3
                                class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 truncate sm:whitespace-normal">
                                Mahindra Yuvo 415 DI Heavy Duty Tractor
                            </h3>
                            <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">Mahindra / Yuvo
                                415
                                DI</p>
                            <p class="font-bold text-lg text-bg-primary whitespace-nowrap">$80,000,000.00</p>
                        </div>
                        {{-- Controls & Price: Stack on small, horizontal on sm+ --}}
                        <div
                            class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-5 mt-3 w-full">
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button
                                    class="quantity-increase btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                    title="Increase Quantity">
                                    <i data-lucide="minus"
                                        class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                                </button>
                                <span
                                    class="quantity-display px-3 py-1 bg-bg-light dark:bg-bg-darkTertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">100</span>
                                <button
                                    class="quantity-increase btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                    title="Increase Quantity">
                                    <i data-lucide="plus"
                                        class="w-4 h-4 group-hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                                </button>
                            </div>
                            <button
                                class="btn btn-ghost btn-circle remove-item text-text-gray hover:text-red-600 transition-colors"
                                title="Remove Item">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-text-gray dark:text-text-white">Your cart is empty.</p>
            @endforelse
        </div>

        {{-- Checkout Card --}}
        <div
            class="px-6 py-2 border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50 bg-bg-light dark:bg-bg-darkSecondary shadow-card">
            <div class="flex justify-between mb-1">
                <span class="font-medium">Total:</span>
                <span class="font-medium cart-total text-xl">$220.00 USD</span>
            </div>
            <p class="text-sm text-text-gray mb-2">Taxes and shipping calculated at checkout</p>

            <label class="flex items-center mb-4 border-t border-border-light dark:border-opacity-50">
                <input type="checkbox" class="p-0 form-checkbox h-4 w-4 text-text-gray focus:ring-bg-primary">
                <span class="ml-2 text-sm">I agree with <a href="#"
                        class="underline text-text-gray hover:text-bg-primary transition-colors">terms and
                        conditions</a></span>
            </label>

            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('frontend.checkout') }}" class="btn-primary w-full text-center py-1">Checkout</a>
                <a href="{{ route('frontend.cart') }}"
                    class="btn-secondary w-full text-center py-1 border border-border-dark dark:border-white dark:border-opacity-50 text-text-gray hover:text-text-dark dark:hover:text-white transition-colors">View
                    Cart</a>
            </div>
        </div>
    </div>
</div>
