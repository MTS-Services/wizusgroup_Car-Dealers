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
            <!-- Cart items will be rendered here dynamically -->
            <p class="text-center text-text-gray dark:text-text-white" id="cart-empty-message">Your cart is empty.</p>
        </div>

        {{-- Checkout Card --}}
        <div
            class="px-6 py-2 border-t border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50 bg-bg-light dark:bg-bg-darkSecondary shadow-card">
            <div class="flex justify-between mb-1">
                <span class="font-medium">Total:</span>
                <span class="font-medium cart-total text-xl">$0.00 USD</span>
            </div>
            <p class="text-sm text-text-gray mb-2">Taxes and shipping calculated at checkout</p>

            <label class="flex items-center mb-4 border-t border-border-light dark:border-opacity-50">
                <input type="checkbox" class="p-0 form-checkbox h-4 w-4 text-text-gray focus:ring-bg-primary">
                <span class="ml-2 text-sm">I agree with <a href="#"
                        class="underline text-text-gray hover:text-bg-primary transition-colors">terms and
                        conditions</a></span>
            </label>

            <div class="flex items-center justify-between gap-3 pb-6">
                <form action="{{ route('frontend.checkout.submit') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full text-center py-1">{{ __('Checkout') }}</button>
                </form>
                <a href="{{ route('frontend.cart') }}"
                    class="btn-secondary w-full text-center py-1 border border-border-dark dark:border-white dark:border-opacity-50 text-text-gray hover:text-text-dark dark:hover:text-white transition-colors">View
                    Cart</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Helper function to format currency
    function formatCurrency(amount) {
        return `$${parseFloat(amount).toFixed(2)}`;
    }

    // Function to update the main cart total display
    function updateCartTotalDisplay(total) {
        const cartTotalDisplay = document.querySelector('.cart-total');
        if (cartTotalDisplay) {
            cartTotalDisplay.textContent = formatCurrency(total) + ' USD';
        }
    }

    // Function to generate HTML for a single cart item
    function generateCartItemHtml(item) {
        const productImageUrl = item.product.primary_image ? item.product.primary_image.image_url :
            'https://placehold.co/96x96/E0E0E0/333333?text=No+Image';
        const brandName = item.product.brand ? item.product.brand.name : '';
        const modelName = item.product.model ? item.product.model.name : '';
        const subtotal = item.price * item.quantity;

        return `
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg shadow-md dark:bg-bg-dark-secondary transition-all duration-200 hover:shadow-lg" data-item-id="${item.id}">
                <div class="relative flex-shrink-0">
                    <img src="${productImageUrl}" alt="${item.product.name}" class="w-24 h-24 object-contain rounded-md">
                </div>
                <div class="flex-1 flex flex-col justify-between w-full">
                    <div>
                        <h3 class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 truncate sm:whitespace-normal">
                            ${item.product.name}
                        </h3>
                        <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">${brandName} / ${modelName}</p>
                        <p class="font-bold text-lg text-bg-primary whitespace-nowrap item-subtotal">${formatCurrency(subtotal)}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-5 mt-3 w-full">
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button
                                class="quantity-decrease btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                title="Decrease Quantity" data-item-id="${item.id}" data-current-quantity="${item.quantity}">
                                <i data-lucide="minus" class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                            </button>
                            <span class="quantity-display px-3 py-1 bg-bg-light dark:bg-bg-darkTertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">${item.quantity}</span>
                            <button
                                class="quantity-increase btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                                title="Increase Quantity" data-item-id="${item.id}" data-current-quantity="${item.quantity}">
                                <i data-lucide="plus" class="w-4 h-4 group-hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                            </button>
                        </div>
                        <button
                            class="btn btn-ghost btn-circle remove-item text-text-gray hover:text-red-600 transition-colors"
                            title="Remove Item" data-item-id="${item.id}">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to append a new item to the cart sidebar
    function appendCartItemHtml(item) {
        const cartItemsContainer = document.getElementById('cart-items-container');
        const cartEmptyMessage = document.getElementById('cart-empty-message');

        if (!cartItemsContainer || !cartEmptyMessage) {
            console.error("Cart sidebar elements not found for appending.");
            return;
        }

        // Check if the item already exists in the DOM to avoid duplicates
        if (cartItemsContainer.querySelector(`[data-item-id="${item.id}"]`)) {
            console.warn(`Item with ID ${item.id} already exists in sidebar.`);
            return; // Do not append if already present
        }

        cartEmptyMessage.classList.add('hidden'); // Hide empty message if an item is added
        const itemHtml = generateCartItemHtml(item);
        cartItemsContainer.insertAdjacentHTML('beforeend', itemHtml);

        // Re-render lucide icons for the newly added item
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    // Function to update an existing item's quantity and subtotal in the sidebar
    function updateCartItemHtml(itemId, newQuantity, newSubtotal) {
        const itemElement = document.querySelector(`#cart-items-container [data-item-id="${itemId}"]`);
        if (itemElement) {
            const quantityDisplay = itemElement.querySelector('.quantity-display');
            const itemSubtotalDisplay = itemElement.querySelector('.item-subtotal');
            const increaseBtn = itemElement.querySelector('.quantity-increase');
            const decreaseBtn = itemElement.querySelector('.quantity-decrease');

            if (quantityDisplay) {
                quantityDisplay.textContent = newQuantity;
            }
            if (itemSubtotalDisplay) {
                itemSubtotalDisplay.textContent = formatCurrency(newSubtotal);
            }
            // Update data-current-quantity attributes for buttons
            if (increaseBtn) {
                increaseBtn.dataset.currentQuantity = newQuantity;
            }
            if (decreaseBtn) {
                decreaseBtn.dataset.currentQuantity = newQuantity;
            }
        }
    }

    // Function to remove an item from the sidebar
    function removeCartItemHtml(itemId) {
        const itemElement = document.querySelector(`#cart-items-container [data-item-id="${itemId}"]`);
        const cartItemsContainer = document.getElementById('cart-items-container');
        const cartEmptyMessage = document.getElementById('cart-empty-message');

        if (itemElement) {
            itemElement.remove();
        }

        // If no items left, show empty message
        if (cartItemsContainer && cartItemsContainer.children.length === 0) {
            if (cartEmptyMessage) {
                cartEmptyMessage.classList.remove('hidden');
            }
        }
    }

    // Function to render all cart items (used for initial load)
    function renderAllCartItems(cartItems) {
        const cartItemsContainer = document.getElementById('cart-items-container');
        const cartEmptyMessage = document.getElementById('cart-empty-message');

        if (!cartItemsContainer || !cartEmptyMessage) {
            console.error("Cart sidebar elements not found for initial rendering.");
            return;
        }

        cartItemsContainer.innerHTML = ''; // Clear existing content

        if (cartItems.length === 0) {
            cartEmptyMessage.classList.remove('hidden');
        } else {
            cartEmptyMessage.classList.add('hidden');
            cartItems.forEach(item => {
                const itemHtml = generateCartItemHtml(item);
                cartItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
            });
        }
        // Re-render lucide icons for all items
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const closeCartSidebarBtn = document.querySelector('.closeCartSidebar');
        const cartSidebar = document.querySelector('.cartSidebar');
        const cartItemsContainer = document.getElementById('cart-items-container');

        // Close sidebar functionality
        if (closeCartSidebarBtn) {
            closeCartSidebarBtn.addEventListener('click', function() {
                if (cartSidebar) {
                    cartSidebar.style.transform = 'translateX(100%)';
                }
            });
        }

        // Initial fetch of cart items when the page loads
        if (cartItemsContainer) {
            axios.post('{{ route('frontend.cart.items') }}')
                .then(response => {
                    renderAllCartItems(response.data.cart_items);
                    updateCartTotalDisplay(response.data.cart_total);
                })
                .catch(error => {
                    console.error('Error fetching initial cart items:', error);
                    // Optionally display a user-friendly error message
                });

            // Event delegation for quantity change and remove buttons
            cartItemsContainer.addEventListener('click', function(event) {
                const target = event.target.closest('button');

                if (!target) return; // Not a button

                const itemId = target.dataset.itemId;
                if (!itemId) return; // Button doesn't have an item ID

                if (target.classList.contains('quantity-increase') || target.classList.contains(
                        'quantity-decrease')) {
                    let currentQuantity = parseInt(target.dataset.currentQuantity);
                    let newQuantity;

                    if (target.classList.contains('quantity-increase')) {
                        newQuantity = currentQuantity + 1;
                    } else { // quantity-decrease
                        newQuantity = currentQuantity - 1;
                    }

                    axios.post('{{ route('frontend.cart.update-quantity') }}', {
                        item_id: itemId,
                        new_quantity: newQuantity
                    }).then(response => {
                        const {
                            status,
                            message,
                            item_id,
                            new_quantity,
                            item_subtotal,
                            removed_item_id,
                            cart_total
                        } = response.data;

                        updateCartTotalDisplay(cart_total); // Always update total

                        if (status === 'success') {
                            updateCartItemHtml(item_id, new_quantity, item_subtotal);
                        } else if (status === 'removed') {
                            removeCartItemHtml(removed_item_id);
                        }
                        console.log(message);
                    }).catch(error => {
                        console.error('Error updating quantity:', error);
                        // Handle error (e.g., show a user-friendly message)
                    });

                } else if (target.classList.contains('remove-item')) {
                    axios.post('{{ route('frontend.cart.remove') }}', {
                        item_id: itemId
                    }).then(response => {
                        const {
                            status,
                            message,
                            removed_item_id,
                            cart_total
                        } = response.data;
                        if (status === 'success') {
                            removeCartItemHtml(removed_item_id);
                            updateCartTotalDisplay(cart_total);
                        }
                        console.log(message);
                    }).catch(error => {
                        console.error('Error removing item:', error);
                        // Handle error
                    });
                }
            });
        }
    });
</script>
