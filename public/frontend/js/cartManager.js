/**
 * Modern Cart Manager - A reusable and professional cart management system
 * Supports multiple UI layouts (sidebar, table, grid, etc.)
 * Author: Your Name
 * Version: 1.0.1 - Fixed quantity update issues
 */

class CartManager {
    constructor(config = {}) {
        this.config = {
            // API Routes
            routes: {
                add: config.routes?.add || '/cart/add',
                remove: config.routes?.remove || '/cart/remove',
                update: config.routes?.update || '/cart/update-quantity',
                items: config.routes?.items || '/cart/items',
                ...config.routes
            },

            // UI Selectors - can be customized for different layouts
            selectors: {
                sidebar: config.selectors?.sidebar || '.cartSidebar',
                closeSidebar: config.selectors?.closeSidebar || '.closeCartSidebar',
                itemsContainer: config.selectors?.itemsContainer || '#cart-items-container',
                emptyMessage: config.selectors?.emptyMessage || '#cart-empty-message',
                totalDisplay: config.selectors?.totalDisplay || '.cart-total',
                tableBody: config.selectors?.tableBody || '#cart-table-body',
                ...config.selectors
            },

            // UI Type (sidebar, table, grid, etc.)
            uiType: config.uiType || 'sidebar',

            // Currency settings
            currency: {
                symbol: config.currency?.symbol || '$',
                position: config.currency?.position || 'before', // 'before' or 'after'
                decimals: config.currency?.decimals || 2,
                ...config.currency
            },

            // Notification settings
            notifications: {
                enabled: config.notifications?.enabled !== false,
                type: config.notifications?.type || 'toastr', // 'toastr', 'alert', 'custom'
                ...config.notifications
            },

            // Debug mode
            debug: config.debug || false,

            ...config
        };

        this.cartData = {
            items: [],
            total: 0
        };

        // Track if events are already bound to prevent duplicates
        this.eventsBound = false;

        this.init();
    }

    /**
     * Initialize the cart manager
     */
    init() {
        this.log('Initializing Cart Manager...');
        this.bindEvents();
        this.loadCartItems();
    }

    /**
     * Bind all event listeners
     */
    bindEvents() {
        // Prevent binding events multiple times
        if (this.eventsBound) {
            this.log('Events already bound, skipping...');
            return;
        }

        const { selectors } = this.config;

        // Unbind any existing events first
        this.unbindEvents();

        // Close sidebar functionality
        $(document).on('click.cartManager', selectors.closeSidebar, () => {
            this.closeSidebar();
        });

        // Event delegation for cart actions - use namespaced events
        $(document).on('click.cartManager', `${selectors.itemsContainer} button, ${selectors.tableBody} button`, (event) => {
            this.handleCartAction(event);
        });

        this.eventsBound = true;
        this.log('Event listeners bound successfully');
    }

    /**
     * Unbind all event listeners
     */
    unbindEvents() {
        $(document).off('.cartManager');
        this.eventsBound = false;
        this.log('Event listeners unbound');
    }

    /**
     * Handle all cart-related button clicks
     */
    handleCartAction(event) {
        const $target = $(event.currentTarget);
        const itemId = $target.data('itemId') || $target.data('item-id');

        if (!itemId) return;

        event.preventDefault();
        event.stopPropagation();

        // Prevent multiple rapid clicks
        if ($target.prop('disabled') || $target.hasClass('processing')) {
            return;
        }

        // Add processing class to prevent double clicks
        $target.addClass('processing').prop('disabled', true);

        if ($target.hasClass('quantity-increase')) {
            this.updateQuantity(itemId, 'increase').finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        } else if ($target.hasClass('quantity-decrease')) {
            this.updateQuantity(itemId, 'decrease').finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        } else if ($target.hasClass('remove-item')) {
            this.removeItem(itemId).finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        }
    }

    /**
     * Add product to cart
     */
    async addToCart(productId, quantity = 1) {
        try {
            this.log(`Adding product ${productId} to cart...`);

            const response = await this.makeRequest(this.config.routes.add, {
                product_id: productId,
                quantity: quantity
            });

            const { status, message, cart_item, cart_total } = response.data;

            this.updateCartTotal(cart_total);

            if (status === 'success') {
                // Update local cart data
                this.updateLocalCartData(cart_item, 'add');

                this.addCartItemToUI(cart_item);
                this.showNotification(message, 'success');
                this.openSidebar();
            } else if (status === 'info') {
                if (cart_item) {
                    // Update local cart data
                    this.updateLocalCartData(cart_item, 'update');

                    this.updateCartItemInUI(cart_item.id, cart_item.quantity, cart_item.price * cart_item.quantity);
                }
                this.showNotification(message, 'info');
                this.openSidebar();
            }

            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to add product to cart');
            throw error;
        }
    }

    /**
     * Update item quantity
     */
    async updateQuantity(itemId, action) {
        const currentItem = this.findCartItem(itemId);
        if (!currentItem) {
            this.log(`Item ${itemId} not found in cart data`);
            return;
        }

        let newQuantity = currentItem.quantity;

        if (action === 'increase') {
            newQuantity++;
        } else if (action === 'decrease') {
            newQuantity--;
        }

        if (newQuantity > currentItem.product.quantity) {
            this.log(`Quantity limit reached: ${currentItem.product.quantity}`);
            this.showNotification(`Quantity limit reached: ${currentItem.product.quantity}`, 'warning');
            return;
        }

        if (newQuantity < 1) {
            this.log('Minimum quantity is 1.');
            this.showNotification('Minimum quantity is 1.', 'warning');
            return;
        }

        try {
            this.log(`Updating quantity for item ${itemId} from ${currentItem.quantity} to ${newQuantity}...`);

            const response = await this.makeRequest(this.config.routes.update, {
                item_id: itemId,
                new_quantity: newQuantity
            });

            const { status, message, item_id: updatedItemId, new_quantity: serverQuantity, item_subtotal, cart_total } = response.data;

            this.updateCartTotal(cart_total);

            if (status === 'success') {
                // Update local cart data first
                this.updateLocalCartItemQuantity(updatedItemId, serverQuantity, item_subtotal);

                // Then update UI
                this.updateCartItemInUI(updatedItemId, serverQuantity, item_subtotal);
                this.showNotification(message, 'success');
            }

            if (status === 'info') {
                this.updateCartItemInUI(updatedItemId, serverQuantity, item_subtotal);
                this.showNotification(message, 'info');
            }

            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update quantity');
            throw error;
        }
    }

    /**
     * Remove item from cart
     */
    async removeItem(itemId) {
        try {
            this.log(`Removing item ${itemId} from cart...`);

            const response = await this.makeRequest(this.config.routes.remove, {
                item_id: itemId
            });

            const { status, message, removed_item_id, cart_total } = response.data;

            if (status === 'success') {
                // Update local cart data
                this.removeFromLocalCartData(removed_item_id);

                this.removeCartItemFromUI(removed_item_id);
                this.updateCartTotal(cart_total);
                this.showNotification(message, 'success');
            }

            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to remove item');
            throw error;
        }
    }

    /**
     * Load cart items from server
     */
    async loadCartItems() {
        try {
            this.log('Loading cart items...');

            const response = await this.makeRequest(this.config.routes.items, {}, 'POST');
            const { cart_items, cart_total } = response.data;

            // Update local cart data
            this.cartData.items = cart_items || [];
            this.cartData.total = cart_total || 0;

            this.renderAllCartItems(this.cartData.items);
            this.updateCartTotal(this.cartData.total);

            this.log('Cart items loaded successfully', this.cartData);
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to load cart items');
            throw error;
        }
    }

    /**
     * Update local cart data when item is added
     */
    updateLocalCartData(cartItem, action) {
        if (action === 'add') {
            const existingIndex = this.cartData.items.findIndex(item => item.id === cartItem.id);
            if (existingIndex >= 0) {
                this.cartData.items[existingIndex] = cartItem;
            } else {
                this.cartData.items.push(cartItem);
            }
        } else if (action === 'update') {
            const existingIndex = this.cartData.items.findIndex(item => item.id === cartItem.id);
            if (existingIndex >= 0) {
                this.cartData.items[existingIndex] = cartItem;
            }
        }

        this.log('Local cart data updated:', this.cartData);
    }

    /**
     * Update local cart item quantity
     */
    updateLocalCartItemQuantity(itemId, newQuantity, newSubtotal) {
        const itemIndex = this.cartData.items.findIndex(item => item.id == itemId);
        if (itemIndex >= 0) {
            this.cartData.items[itemIndex].quantity = newQuantity;
            // Update price if needed (newSubtotal / newQuantity)
            if (newQuantity > 0) {
                this.cartData.items[itemIndex].price = newSubtotal / newQuantity;
            }
            this.log(`Local cart item ${itemId} updated to quantity ${newQuantity}`);
        }
    }

    /**
     * Remove item from local cart data
     */
    removeFromLocalCartData(itemId) {
        this.cartData.items = this.cartData.items.filter(item => item.id != itemId);
        this.log(`Item ${itemId} removed from local cart data`);
    }

    /**
     * Render all cart items based on UI type
     */
    renderAllCartItems(cartItems) {
        const { selectors, uiType } = this.config;

        if (uiType === 'sidebar') {
            this.renderSidebarItems(cartItems);
        } else if (uiType === 'table') {
            this.renderTableItems(cartItems);
        } else if (uiType === 'grid') {
            this.renderGridItems(cartItems);
        }

        this.reinitializeIcons();
    }

    /**
     * Render items for sidebar layout
     */
    renderSidebarItems(cartItems) {
        const $container = $(this.config.selectors.itemsContainer);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$container.length) return;

        // Remove existing cart items
        $container.find('.cart-item-single').remove();

        if (cartItems && cartItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
        } else {
            $emptyMessage?.addClass('hidden');
            cartItems.forEach(item => {
                const itemHtml = this.generateSidebarItemHtml(item);
                $container.append(itemHtml);
            });
        }
    }

    /**
     * Render items for table layout
     */
    renderTableItems(cartItems) {
        const $tableBody = $(this.config.selectors.tableBody);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$tableBody.length) return;

        $tableBody.empty();

        if (cartItems && cartItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
            $tableBody.append(`
                <tr>
                    <td colspan="6" class="text-center py-8 text-text-gray dark:text-text-white">
                        Your cart is empty
                    </td>
                </tr>
            `);
        } else {
            $emptyMessage?.addClass('hidden');
            cartItems.forEach(item => {
                const itemHtml = this.generateTableItemHtml(item);
                $tableBody.append(itemHtml);
            });
        }
    }

    /**
     * Render items for grid layout
     */
    renderGridItems(cartItems) {
        const $container = $(this.config.selectors.itemsContainer);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$container.length) return;

        $container.find('.cart-item-grid').remove();

        if (cartItems && cartItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
        } else {
            $emptyMessage?.addClass('hidden');
            cartItems.forEach(item => {
                const itemHtml = this.generateGridItemHtml(item);
                $container.append(itemHtml);
            });
        }
    }

    /**
     * Generate HTML for sidebar item
     */
    generateSidebarItemHtml(item) {
        const productImageUrl = this.getProductImage(item);
        const brandName = item.product.brand?.name || '';
        const modelName = item.product.model?.name || '';
        const subtotal = item.price * item.quantity;

        return `
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg shadow-md dark:bg-bg-dark-secondary transition-all duration-200 hover:shadow-lg cart-item-single" data-item-id="${item.id}">
                <div class="relative flex-shrink-0">
                    <img src="${productImageUrl}" alt="${item.product.name}" class="w-24 h-24 object-contain rounded-md">
                </div>
                <div class="flex-1 flex flex-col justify-between w-full">
                    <div>
                        <h3 class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 truncate sm:whitespace-normal">
                            ${item.product.name}
                        </h3>
                        <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">${brandName} / ${modelName}</p>
                        <p class="font-bold text-lg text-bg-primary whitespace-nowrap item-subtotal">${this.formatCurrency(subtotal)}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center gap-5 mt-3 w-full">
                        ${this.generateQuantityControls(item)}
                        ${this.generateRemoveButton(item.id)}
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Generate HTML for table item
     */
    generateTableItemHtml(item) {
        const productImageUrl = this.getProductImage(item);
        const brandName = item.product.brand?.name || '';
        const modelName = item.product.model?.name || '';
        const subtotal = item.price * item.quantity;

        return `
            <tr class="cart-item-table border-b border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50" data-item-id="${item.id}">
                <td class="py-4">
                    <img src="${productImageUrl}" alt="${item.product.name}" class="w-24 h-24 object-contain rounded-md">
                </td>
                <td class="py-4">
                    <h3 class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1">
                        ${item.product.name}
                    </h3>
                    <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">
                        ${brandName} / ${modelName}
                    </p>
                </td>
                <td class="py-4">${this.formatCurrency(item.price)}</td>
                <td class="py-4">
                    ${this.generateQuantityControls(item)}
                </td>
                <td class="py-4">
                    <p class="font-bold text-lg text-bg-primary whitespace-nowrap item-subtotal">
                        ${this.formatCurrency(subtotal)}
                    </p>
                </td>
                <td class="py-4">
                    ${this.generateRemoveButton(item.id)}
                </td>
            </tr>
        `;
    }

    /**
     * Generate HTML for grid item
     */
    generateGridItemHtml(item) {
        const productImageUrl = this.getProductImage(item);
        const brandName = item.product.brand?.name || '';
        const modelName = item.product.model?.name || '';
        const subtotal = item.price * item.quantity;

        return `
            <div class="cart-item-grid bg-white dark:bg-bg-dark rounded-lg shadow-md p-6 transition-all duration-200 hover:shadow-lg" data-item-id="${item.id}">
                <div class="text-center mb-4">
                    <img src="${productImageUrl}" alt="${item.product.name}" class="w-32 h-32 object-contain mx-auto rounded-md">
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-lg text-text-dark dark:text-text-white mb-2">
                        ${item.product.name}
                    </h3>
                    <p class="text-sm text-text-gray dark:text-text-white dark:text-opacity-70 mb-3">
                        ${brandName} / ${modelName}
                    </p>
                    <p class="font-bold text-xl text-bg-primary mb-4 item-subtotal">
                        ${this.formatCurrency(subtotal)}
                    </p>
                    <div class="flex items-center justify-center gap-4 mb-4">
                        ${this.generateQuantityControls(item)}
                    </div>
                    ${this.generateRemoveButton(item.id)}
                </div>
            </div>
        `;
    }

    /**
     * Generate quantity control buttons
     */
    generateQuantityControls(item) {
        return `
            <div class="flex items-center gap-2 flex-shrink-0">
                <button
                    class="quantity-decrease btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                    title="Decrease Quantity"
                    data-item-id="${item.id}"
                    data-current-quantity="${item.quantity}"
                    ${item.quantity === 1 ? 'disabled' : ''}>
                    <i data-lucide="minus" class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                </button>
                <span class="quantity-display px-3 py-1 bg-bg-light dark:bg-bg-dark-tertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">${item.quantity}</span>
                <button
                    class="quantity-increase btn btn-ghost btn-circle btn-sm border border-gray-800/10 dark:border-gray-200 text-lg group"
                    title="Increase Quantity"
                    data-item-id="${item.id}"
                    data-current-quantity="${item.quantity}">
                    <i data-lucide="plus" class="w-4 h-4 group-hover:text-text-secondary transition-all duration-300 ease-linear"></i>
                </button>
            </div>
        `;
    }

    /**
     * Generate remove button
     */
    generateRemoveButton(itemId) {
        return `
            <button
                class="btn btn-ghost btn-circle remove-item text-text-gray hover:text-red-600 transition-colors"
                title="Remove Item" data-item-id="${itemId}">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        `;
    }

    /**
     * Add cart item to UI
     */
    addCartItemToUI(item) {
        const { selectors, uiType } = this.config;

        // Check if item already exists
        if (this.isItemInUI(item.id)) {
            this.updateCartItemInUI(item.id, item.quantity, item.price * item.quantity);
            return;
        }

        const $emptyMessage = $(selectors.emptyMessage);
        $emptyMessage?.addClass('hidden');

        if (uiType === 'sidebar') {
            const $container = $(selectors.itemsContainer);
            const itemHtml = this.generateSidebarItemHtml(item);
            $container.append(itemHtml);
        } else if (uiType === 'table') {
            const $tableBody = $(selectors.tableBody);
            // Remove empty row if it exists
            $tableBody.find('tr:has(td[colspan])').remove();
            const itemHtml = this.generateTableItemHtml(item);
            $tableBody.append(itemHtml);
        } else if (uiType === 'grid') {
            const $container = $(selectors.itemsContainer);
            const itemHtml = this.generateGridItemHtml(item);
            $container.append(itemHtml);
        }

        this.reinitializeIcons();
    }

    /**
     * Update cart item in UI
     */
    updateCartItemInUI(itemId, newQuantity, newSubtotal) {
        const $itemElement = $(`[data-item-id="${itemId}"]`);

        if ($itemElement.length) {
            // Update quantity display
            $itemElement.find('.quantity-display').text(newQuantity);

            // Update subtotal
            $itemElement.find('.item-subtotal').text(this.formatCurrency(newSubtotal));

            // Update ALL data attributes for both buttons
            $itemElement.find('.quantity-increase, .quantity-decrease').attr('data-current-quantity', newQuantity);

            // Manage disabled state for decrease button
            const $decreaseButton = $itemElement.find('.quantity-decrease');
            if (newQuantity <= 1) {
                $decreaseButton.prop('disabled', true).attr('disabled', 'disabled');
            } else {
                $decreaseButton.prop('disabled', false).removeAttr('disabled');
            }

            this.log(`UI updated for item ${itemId}: quantity=${newQuantity}, subtotal=${newSubtotal}`);
        } else {
            this.log(`Warning: Could not find UI element for item ${itemId}`);
        }
    }

    /**
     * Remove cart item from UI
     */
    removeCartItemFromUI(itemId) {
        const $itemElement = $(`[data-item-id="${itemId}"]`);
        const { selectors } = this.config;

        if ($itemElement.length) {
            $itemElement.remove();
        }

        // Check if cart is empty
        const $container = $(selectors.itemsContainer);
        const $tableBody = $(selectors.tableBody);
        const $emptyMessage = $(selectors.emptyMessage);

        const hasItems = $container.find('.cart-item-single, .cart-item-grid').length > 0 ||
            $tableBody.find('.cart-item-table').length > 0;

        if (!hasItems) {
            $emptyMessage?.removeClass('hidden');

            // For table layout, add empty row
            if (this.config.uiType === 'table' && $tableBody.length) {
                $tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-8 text-text-gray dark:text-text-white">
                            Your cart is empty
                        </td>
                    </tr>
                `);
            }
        }
    }

    /**
     * Update cart total display
     */
    updateCartTotal(total) {
        this.cartData.total = total;
        $(this.config.selectors.totalDisplay).text(this.formatCurrency(total));
    }

    /**
     * Open sidebar
     */
    openSidebar() {
        if (this.config.uiType === 'sidebar') {
            $(this.config.selectors.sidebar).css('transform', 'translateX(0)');
        }
    }

    /**
     * Close sidebar
     */
    closeSidebar() {
        if (this.config.uiType === 'sidebar') {
            $(this.config.selectors.sidebar).css('transform', 'translateX(100%)');
        }
    }

    /**
     * Utility Methods
     */

    getProductImage(item) {
        return item.product.primary_image?.[0]?.modified_image ||
            'https://placehold.co/96x96/E0E0E0/333333?text=No+Image';
    }

    formatCurrency(amount) {
        const { symbol, position, decimals } = this.config.currency;
        const number = parseFloat(amount || 0);

        // Format number with commas and fixed decimals
        const formatted = number.toLocaleString(undefined, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });

        return position === 'before' ? `${symbol}${formatted}` : `${formatted}${symbol}`;
    }

    findCartItem(itemId) {
        return this.cartData.items.find(item => item.id == itemId);
    }

    isItemInUI(itemId) {
        return $(`[data-item-id="${itemId}"]`).length > 0;
    }

    reinitializeIcons() {
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    async makeRequest(url, data, method = 'POST') {
        return axios({
            method: method,
            url: url,
            data: data,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    }

    showNotification(message, type = 'info') {
        if (!this.config.notifications.enabled) return;

        const { type: notificationType } = this.config.notifications;

        if (notificationType === 'toastr' && typeof toastr !== 'undefined') {
            toastr[type](message);
        } else if (notificationType === 'alert') {
            alert(message);
        } else if (notificationType === 'custom' && this.config.notifications.customHandler) {
            this.config.notifications.customHandler(message, type);
        }
    }

    handleError(error, fallbackMessage) {
        this.log('Error:', error);

        let errorMessage = fallbackMessage;
        if (error.response?.data?.message) {
            errorMessage = error.response.data.message;
        }

        this.showNotification(errorMessage, 'error');
    }

    log(...args) {
        if (this.config.debug) {
            console.log('[CartManager]', ...args);
        }
    }

    /**
     * Public API Methods
     */

    // Get current cart data
    getCartData() {
        return { ...this.cartData };
    }

    // Get item count
    getItemCount() {
        return this.cartData.items.reduce((count, item) => count + item.quantity, 0);
    }

    // Get cart total
    getCartTotal() {
        return this.cartData.total;
    }

    // Refresh cart from server
    async refresh() {
        return this.loadCartItems();
    }

    // Clear entire cart
    async clearCart() {
        try {
            const response = await this.makeRequest('/cart/clear', {});
            if (response.data.status === 'success') {
                this.cartData.items = [];
                this.cartData.total = 0;
                this.renderAllCartItems([]);
                this.updateCartTotal(0);
                this.showNotification('Cart cleared successfully', 'success');
            }
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to clear cart');
            throw error;
        }
    }

    // Destroy cart manager and cleanup
    destroy() {
        this.unbindEvents();
        this.cartData = { items: [], total: 0 };
        this.log('Cart Manager destroyed');
    }
}

// Global function to make adding to cart easier
window.addToCart = function (productId, quantity = 1) {
    if (window.cartManager) {
        return window.cartManager.addToCart(productId, quantity);
    } else {
        console.error('Cart Manager not initialized');
    }
};

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CartManager;
}
