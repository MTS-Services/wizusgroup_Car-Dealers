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
                <a href="{{ route('frontend.checkout') }}" class="btn-primary w-full text-center py-1">Checkout</a>
                <a href="{{ route('frontend.cart') }}"
                    class="btn-secondary w-full text-center py-1 border border-border-dark dark:border-white dark:border-opacity-50 text-text-gray hover:text-text-dark dark:hover:text-white transition-colors">View
                    Cart</a>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(productId) {
        axios.post('{{ route('frontend.cart.add') }}', {
            product_id: productId
        }).then(response => {
            $('.cartSidebar').css('transform', 'translateX(0)');
            console.log(response.data);

            const {
                status,
                message,
                cart_item,
                cart_total
            } = response.data;

            // Ensure updateCartTotalDisplay function is globally available or included in a shared script
            if (typeof updateCartTotalDisplay === 'function') {
                updateCartTotalDisplay(cart_total);
            } else {
                console.error("updateCartTotalDisplay function is not defined.");
            }

            if (status === 'success') {
                // Append new item to sidebar
                if (typeof appendCartItemHtml === 'function') {
                    appendCartItemHtml(cart_item);
                } else {
                    console.error("appendCartItemHtml function is not defined.");
                }
            } else if (status === 'info') {
                // If item was already in cart, you might want to show a message
                // or highlight the existing item if it's visible in the sidebar.
                // For now, we just update the total (which is already done).
                console.warn(message);
            }

        }).catch(error => {
            console.error('Error adding product to cart:', error);
            // Handle error (e.g., show a user-friendly message)
        })
    }

    // Helper function to format currency
    function formatCurrency(amount) {
        return `$${parseFloat(amount).toFixed(2)}`;
    }

    // Function to update the main cart total display
    function updateCartTotalDisplay(total) {
        $('.cart-total').text(formatCurrency(total) + ' USD');
    }

    // Function to generate HTML for a single cart item
    function generateCartItemHtml(item) {
        // Corrected: Using 'modified_image' accessor from ProductImage model
        const productImageUrl = item.product.primary_image[0] ? item.product.primary_image[0].modified_image : 'https://placehold.co/96x96/E0E0E0/333333?text=No+Image';
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
        const $cartItemsContainer = $('#cart-items-container');
        const $cartEmptyMessage = $('#cart-empty-message');

        if (!$cartItemsContainer.length || !$cartEmptyMessage.length) {
            console.error("Cart sidebar elements not found for appending.");
            return;
        }

        // Check if the item already exists in the DOM to avoid duplicates
        if ($cartItemsContainer.find(`[data-item-id="${item.id}"]`).length) {
            console.warn(`Item with ID ${item.id} already exists in sidebar.`);
            return; // Do not append if already present
        }

        $cartEmptyMessage.addClass('hidden'); // Hide empty message if an item is added
        const itemHtml = generateCartItemHtml(item);
        $cartItemsContainer.append(itemHtml);

        // Re-render lucide icons for the newly added item
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    // Function to update an existing item's quantity and subtotal in the sidebar
    function updateCartItemHtml(itemId, newQuantity, newSubtotal) {
        const $itemElement = $(`#cart-items-container [data-item-id="${itemId}"]`);
        if ($itemElement.length) {
            $itemElement.find('.quantity-display').text(newQuantity);
            $itemElement.find('.item-subtotal').text(formatCurrency(newSubtotal));

            // Update data-current-quantity attributes for buttons
            $itemElement.find('.quantity-increase, .quantity-decrease').data('currentQuantity', newQuantity);
        }
    }

    // Function to remove an item from the sidebar
    function removeCartItemHtml(itemId) {
        const $itemElement = $(`#cart-items-container [data-item-id="${itemId}"]`);
        const $cartItemsContainer = $('#cart-items-container');
        const $cartEmptyMessage = $('#cart-empty-message');

        if ($itemElement.length) {
            $itemElement.remove();
        }

        // If no items left, show empty message
        if ($cartItemsContainer.length && $cartItemsContainer.children().length === 0) {
            if ($cartEmptyMessage.length) {
                $cartEmptyMessage.removeClass('hidden');
            }
        }
    }

    // Function to render all cart items (used for initial load)
    function renderAllCartItems(cartItems) {
        const $cartItemsContainer = $('#cart-items-container');
        const $cartEmptyMessage = $('#cart-empty-message');

        if (!$cartItemsContainer.length || !$cartEmptyMessage.length) {
            console.error("Cart sidebar elements not found for initial rendering.");
            return;
        }

        $cartItemsContainer.empty(); // Clear existing content

        if (cartItems.length === 0) {
            $cartEmptyMessage.removeClass('hidden');
        } else {
            $cartEmptyMessage.addClass('hidden');
            cartItems.forEach(item => {
                const itemHtml = generateCartItemHtml(item);
                $cartItemsContainer.append(itemHtml);
            });
        }
        // Re-render lucide icons for all items
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        const $closeCartSidebarBtn = $('.closeCartSidebar');
        const $cartSidebar = $('.cartSidebar');
        const $cartItemsContainer = $('#cart-items-container');

        // Close sidebar functionality
        if ($closeCartSidebarBtn.length) {
            $closeCartSidebarBtn.on('click', function() {
                if ($cartSidebar.length) {
                    $cartSidebar.css('transform', 'translateX(100%)');
                }
            });
        }

        // Initial fetch of cart items when the page loads
        // This relies on renderAllCartItems and updateCartTotalDisplay being globally available
        if ($cartItemsContainer.length && typeof renderAllCartItems === 'function' &&
            typeof updateCartTotalDisplay === 'function') {
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
            $cartItemsContainer.on('click', 'button', function(event) {
                const $target = $(this); // The clicked button

                const itemId = $target.data('itemId');
                if (!itemId) return; // Button doesn't have an item ID

                if ($target.hasClass('quantity-increase') || $target.hasClass('quantity-decrease')) {
                    let currentQuantity = parseInt($target.data('currentQuantity'));
                    let newQuantity;
                    
                    if ($target.hasClass('quantity-increase')) {
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

                        if (typeof updateCartTotalDisplay === 'function') {
                            updateCartTotalDisplay(cart_total); // Always update total
                        }

                        if (status === 'success') {
                            if (typeof updateCartItemHtml === 'function') {
                                updateCartItemHtml(item_id, new_quantity, item_subtotal);
                            }
                        } else if (status === 'removed') {
                            if (typeof removeCartItemHtml === 'function') {
                                removeCartItemHtml(removed_item_id);
                            }
                        }
                        // Assuming toastr is a global jQuery plugin
                        if (typeof toastr !== 'undefined' && typeof toastr.log === 'function') {
                            toastr.log(message);
                        } else {
                            console.log(message);
                        }
                    }).catch(error => {
                        console.error('Error updating quantity:', error);
                        // Handle error (e.g., show a user-friendly message)
                    });

                } else if ($target.hasClass('remove-item')) {
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
                            if (typeof removeCartItemHtml === 'function') {
                                removeCartItemHtml(removed_item_id);
                            }
                            if (typeof updateCartTotalDisplay === 'function') {
                                updateCartTotalDisplay(cart_total);
                            }
                        }
                        // Assuming toastr is a global jQuery plugin
                        if (typeof toastr !== 'undefined' && typeof toastr.log === 'function') {
                            toastr.log(message);
                        } else {
                            console.log(message);
                        }
                    }).catch(error => {
                        console.error('Error removing item:', error);
                        // Handle error
                    });
                }
            });
        }
    });
</script>
