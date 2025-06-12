/**
 * Modern Checkout Manager - A reusable order items management system for checkout page
 * Supports multiple UI layouts (sidebar, table, grid, etc.)
 * Author: Your Name
 * Version: 1.0.0 - Order items management during checkout
 */

class CheckoutManager {
    constructor(config = {}) {
        this.config = {
            // API Routes
            routes: {
                remove: config.routes?.remove || '/checkout/remove-item',
                update: config.routes?.update || '/checkout/update-quantity',
                items: config.routes?.items || '/checkout/items',
                ...config.routes
            },

            // UI Selectors - can be customized for different layouts
            selectors: {
                itemsContainer: config.selectors?.itemsContainer || '#checkout-items-container',
                emptyMessage: config.selectors?.emptyMessage || '#checkout-empty-message',
                totalDisplay: config.selectors?.totalDisplay || '.order-total',
                subtotalDisplay: config.selectors?.subtotalDisplay || '.order-subtotal',
                tableBody: config.selectors?.tableBody || '#checkout-table-body',
                ...config.selectors
            },

            // UI Type (table, grid, etc.)
            uiType: config.uiType || 'table',

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

            // Order ID for checkout
            orderId: config.orderId || null,

            // Debug mode
            debug: config.debug || false,

            ...config
        };

        this.orderData = {
            items: [],
            subtotal: 0,
            total: 0
        };

        // Track if events are already bound to prevent duplicates
        this.eventsBound = false;

        this.init();
    }

    /**
     * Initialize the checkout manager
     */
    init() {
        this.log('Initializing Checkout Manager...');
        this.bindEvents();
        this.loadOrderItems();
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

        // Event delegation for checkout actions - use namespaced events
        $(document).on('click.checkoutManager', `${selectors.itemsContainer} button, ${selectors.tableBody} button`, (event) => {
            this.handleCheckoutAction(event);
        });

        this.eventsBound = true;
        this.log('Event listeners bound successfully');
    }

    /**
     * Unbind all event listeners
     */
    unbindEvents() {
        $(document).off('.checkoutManager');
        this.eventsBound = false;
        this.log('Event listeners unbound');
    }

    /**
     * Handle all checkout-related button clicks
     */
    handleCheckoutAction(event) {
        const $target = $(event.currentTarget);
        const itemId = $target.data('itemId') || $target.data('item-id') || $target.data('id');

        if (!itemId) return;

        event.preventDefault();
        event.stopPropagation();

        // Prevent multiple rapid clicks
        if ($target.prop('disabled') || $target.hasClass('processing')) {
            return;
        }

        // Add processing class to prevent double clicks
        $target.addClass('processing').prop('disabled', true);

        if ($target.hasClass('quantity-increase') || $target.hasClass('increase-quantity')) {
            this.updateQuantity(itemId, 'increase').finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        } else if ($target.hasClass('quantity-decrease') || $target.hasClass('decrease-quantity')) {
            this.updateQuantity(itemId, 'decrease').finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        } else if ($target.hasClass('remove-item') || $target.hasClass('remove')) {
            this.removeItem(itemId).finally(() => {
                $target.removeClass('processing').prop('disabled', false);
            });
        }
    }

    /**
     * Update item quantity
     */
    async updateQuantity(itemId, action) {
        const currentItem = this.findOrderItem(itemId);
        if (!currentItem) {
            this.log(`Item ${itemId} not found in order data`);
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
                new_quantity: newQuantity,
                // order_id: this.config.orderId
            });

            const {
                status,
                message,
                item_id: updatedItemId,
                new_quantity: serverQuantity,
                item_subtotal,
                order_subtotal,
                order_total
            } = response.data;

            this.updateOrderTotals(order_subtotal, order_total);

            if (status === 'success') {
                // Update local order data first
                this.updateLocalOrderItemQuantity(updatedItemId, serverQuantity, item_subtotal);

                // Then update UI
                this.updateOrderItemInUI(updatedItemId, serverQuantity, item_subtotal);
                this.showNotification(message, 'success');
            }

            if (status === 'info') {
                this.updateLocalOrderItemQuantity(updatedItemId, serverQuantity, item_subtotal);
                this.updateOrderItemInUI(updatedItemId, serverQuantity, item_subtotal);
                this.showNotification(message, 'info');
            }

            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update quantity');
            throw error;
        }
    }

    /**
     * Remove item from order
     */
    async removeItem(itemId) {
        try {
            this.log(`Removing item ${itemId} from order...`);

            const response = await this.makeRequest(this.config.routes.remove, {
                item_id: itemId,
                // order_id: this.config.orderId
            });

            const { status, message, removed_item_id, order_subtotal, order_total } = response.data;

            if (status === 'success') {
                // Update local order data
                this.removeFromLocalOrderData(removed_item_id);

                this.removeOrderItemFromUI(removed_item_id);
                this.updateOrderTotals(order_subtotal, order_total);
                this.showNotification(message, 'success');
            }

            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to remove item');
            throw error;
        }
    }

    /**
     * Load order items from server
     */
    async loadOrderItems() {
        try {
            this.log('Loading order items...');

            const response = await this.makeRequest(this.config.routes.items, {
                order_id: this.config.orderId
            }, 'POST');

            const { order_items, order_subtotal, order_total } = response.data;

            // Update local order data
            this.orderData.items = order_items || [];
            this.orderData.subtotal = order_subtotal || 0;
            this.orderData.total = order_total || 0;

            this.renderAllOrderItems(this.orderData.items);
            this.updateOrderTotals(this.orderData.subtotal, this.orderData.total);

            this.log('Order items loaded successfully', this.orderData);
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to load order items');
            throw error;
        }
    }

    /**
     * Update local order item quantity
     */
    updateLocalOrderItemQuantity(itemId, newQuantity, newSubtotal) {
        const itemIndex = this.orderData.items.findIndex(item => item.id == itemId);
        if (itemIndex >= 0) {
            this.orderData.items[itemIndex].quantity = newQuantity;
            // Update price if needed (newSubtotal / newQuantity)
            if (newQuantity > 0) {
                this.orderData.items[itemIndex].price = newSubtotal / newQuantity;
            }
            this.log(`Local order item ${itemId} updated to quantity ${newQuantity}`);
        }
    }

    /**
     * Remove item from local order data
     */
    removeFromLocalOrderData(itemId) {
        this.orderData.items = this.orderData.items.filter(item => item.id != itemId);
        this.log(`Item ${itemId} removed from local order data`);
    }

    /**
     * Render all order items based on UI type
     */
     renderAllOrderItems(orderItems) {
        const { uiType } = this.config;

        if (uiType === 'sidebar') {
            this.renderSidebarItems(orderItems);
        } else if (uiType === 'table') {
            this.renderTableItems(orderItems);
        } else if (uiType === 'grid') {
            this.renderGridItems(orderItems);
        }

        this.reinitializeIcons();
    }

    /**
     * Render items for sidebar layout
     */
    renderSidebarItems(orderItems) {
        const $container = $(this.config.selectors.itemsContainer);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$container.length) return;

        // Remove existing order items
        $container.find('.order-item-single').remove();

        if (orderItems && orderItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
        } else {
            $emptyMessage?.addClass('hidden');
            orderItems.forEach(item => {
                const itemHtml = this.generateSidebarItemHtml(item);
                $container.append(itemHtml);
            });
        }
    }

    /**
     * Render items for table layout
     */
    renderTableItems(orderItems) {
        const $tableBody = $(this.config.selectors.tableBody);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$tableBody.length) return;

        $tableBody.empty();

        if (orderItems && orderItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
            $tableBody.append(`
                <tr>
                    <td colspan="6" class="text-center py-8 text-text-gray dark:text-text-white">
                        Your order is empty
                    </td>
                </tr>
            `);
        } else {
            $emptyMessage?.addClass('hidden');
            orderItems.forEach(item => {
                const itemHtml = this.generateTableItemHtml(item);
                $tableBody.append(itemHtml);
            });
        }
    }

    /**
     * Render items for grid layout
     */
    renderGridItems(orderItems) {
        const $container = $(this.config.selectors.itemsContainer);
        const $emptyMessage = $(this.config.selectors.emptyMessage);

        if (!$container.length) return;

        $container.find('.order-item-grid').remove();

        if (orderItems && orderItems.length === 0) {
            $emptyMessage?.removeClass('hidden');
        } else {
            $emptyMessage?.addClass('hidden');
            orderItems.forEach(item => {
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
        const subtotal = item.unit_price * item.quantity;

        return `
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-lg shadow-md dark:bg-bg-dark-secondary transition-all duration-200 hover:shadow-lg order-item-single" data-item-id="${item.id}">
                <div class="relative flex-shrink-0">
                    <img src="${productImageUrl}" alt="${item.product.name}" class="w-24 h-24 object-contain rounded-md">
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-between w-full">
                    <div class='min-w-0'>
                        <h3 class="font-semibold text-base text-text-dark dark:text-text-white leading-snug mb-1 break-words line-clamp-2 sm:whitespace-normal">
                            ${item.product.name}
                        </h3>
                        <p class="text-xs text-text-gray dark:text-text-white dark:text-opacity-70">${brandName} / ${modelName}</p>
                        <p class="font-bold text-lg text-bg-primary whitespace-nowrap item-subtotal">${this.formatCurrency(subtotal)}</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 mt-3 w-full">
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
            <tr class="order-item-table border-b border-border-dark border-opacity-20 dark:border-white dark:border-opacity-50" data-item-id="${item.id}">
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
            <div class="order-item-grid bg-white dark:bg-bg-dark rounded-lg shadow-md p-6 transition-all duration-200 hover:shadow-lg" data-item-id="${item.id}">
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
                    class="quantity-decrease decrease-quantity btn btn-ghost btn-circle btn-sm border border-gray-800/10 text-lg group"
                    title="Decrease Quantity"
                    data-item-id="${item.id}"
                    data-id="${item.id}"
                    data-current-quantity="${item.quantity}"
                    data-current-item-quantity="${item.quantity}"
                    ${item.quantity === 1 ? 'disabled' : ''}>
                    <i data-lucide="minus" class="w-4 h-4 group-hover:text-text-wiz_orange transition-all duration-300 ease-linear"></i>
                </button>
                <span class="quantity-display quantity-show px-3 py-1 bg-bg-light dark:bg-bg-dark-tertiary rounded-full font-medium text-text-dark dark:text-text-white min-w-[30px] text-center">${item.quantity}</span>
                <button
                    class="quantity-increase increase-quantity btn btn-ghost btn-circle btn-sm border border-gray-800/10 dark:border-gray-200 text-lg group"
                    title="Increase Quantity"
                    data-item-id="${item.id}"
                    data-id="${item.id}"
                    data-current-quantity="${item.quantity}"
                    data-current-item-quantity="${item.quantity}">
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
                class="btn btn-ghost btn-circle remove-item remove text-text-gray hover:text-red-600 transition-colors"
                title="Remove Item"
                data-item-id="${itemId}"
                data-id="${itemId}">
                <i data-lucide="trash-2" class="w-5 h-5"></i>
            </button>
        `;
    }

    /**
     * Update order item in UI
     */
    updateOrderItemInUI(itemId, newQuantity, newSubtotal) {
        const $itemElement = $(`[data-item-id="${itemId}"]`);

        if ($itemElement.length) {
            // Update quantity display
            $itemElement.find('.quantity-display, .quantity-show').text(newQuantity);

            // Update subtotal
            $itemElement.find('.item-subtotal').text(this.formatCurrency(newSubtotal));

            // Update ALL data attributes for both buttons
            $itemElement.find('.quantity-increase, .quantity-decrease, .increase-quantity, .decrease-quantity')
                .attr('data-current-quantity', newQuantity)
                .attr('data-current-item-quantity', newQuantity);

            // Manage disabled state for decrease button
            const $decreaseButton = $itemElement.find('.quantity-decrease, .decrease-quantity');
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
     * Remove order item from UI
     */
    removeOrderItemFromUI(itemId) {
        const $itemElement = $(`[data-item-id="${itemId}"]`);
        const { selectors } = this.config;

        if ($itemElement.length) {
            $itemElement.remove();
        }

        // Check if order is empty
        const $container = $(selectors.itemsContainer);
        const $tableBody = $(selectors.tableBody);
        const $emptyMessage = $(selectors.emptyMessage);

        const hasItems = $container.find('.order-item-single, .order-item-grid').length > 0 ||
            $tableBody.find('.order-item-table').length > 0;

        if (!hasItems) {
            $emptyMessage?.removeClass('hidden');

            // For table layout, add empty row
            if (this.config.uiType === 'table' && $tableBody.length) {
                $tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-8 text-text-gray dark:text-text-white">
                            Your order is empty
                        </td>
                    </tr>
                `);
            }
        }
    }

    /**
     * Update order totals display
     */
    updateOrderTotals(subtotal, total) {
        this.orderData.subtotal = subtotal;
        this.orderData.total = total;

        $(this.config.selectors.subtotalDisplay).text(this.formatCurrency(subtotal));
        $(this.config.selectors.totalDisplay).text(this.formatCurrency(total));
    }

    /**
     * Utility Methods
     */

    getProductImage(item) {
        return item.product.primary_image?.[0]?.modified_image ||
            item.product.primaryImage?.[0]?.image ||
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

    findOrderItem(itemId) {
        return this.orderData.items.find(item => item.id == itemId);
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
            console.log('[CheckoutManager]', ...args);
        }
    }

    /**
     * Public API Methods
     */

    // Get current order data
    getOrderData() {
        return { ...this.orderData };
    }

    // Get item count
    getItemCount() {
        return this.orderData.items.reduce((count, item) => count + item.quantity, 0);
    }

    // Get order total
    getOrderTotal() {
        return this.orderData.total;
    }

    // Get order subtotal
    getOrderSubtotal() {
        return this.orderData.subtotal;
    }

    // Refresh order from server
    async refresh() {
        return this.loadOrderItems();
    }

    // Destroy checkout manager and cleanup
    destroy() {
        this.unbindEvents();
        this.orderData = { items: [], subtotal: 0, total: 0 };
        this.log('Checkout Manager destroyed');
    }
}

// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CheckoutManager;
}
