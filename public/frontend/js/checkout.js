/**
 * Simple Cart Manager - Focused on quantity updates, removal, and totals
 * Author: Your Name
 * Version: 1.0.0
 */

class SimpleCartManager {
    constructor(config = {}) {
        this.config = {
            // API Routes
            routes: {
                updateQuantity: config.routes?.updateQuantity || "/checkout/quantity-update",
                removeItem: config.routes?.removeItem || "/checkout/remove-item",
                ...config.routes
            },

            // UI Selectors
            selectors: {
                quantityDisplay: config.selectors?.quantityDisplay || '.quantity-display',
                itemSubtotal: config.selectors?.itemSubtotal || '.item-subtotal',
                orderTotal: config.selectors?.orderTotal || '.order-total',
                orderSubtotal: config.selectors?.orderSubtotal || '.order-subtotal',
                ...config.selectors
            },

            // Currency settings
            currency: {
                symbol: config.currency?.symbol || '$',
                position: config.currency?.position || 'before',
                decimals: config.currency?.decimals || 2,
                ...config.currency
            },

            // Notification settings
            notifications: {
                enabled: config.notifications?.enabled !== false,
                type: config.notifications?.type || 'console', // 'console', 'alert', 'toastr', 'custom'
                ...config.notifications
            },

            // Debug mode
            debug: config.debug || false,

            ...config
        };

        this.subTotal = 0;
        this.eventsBound = false;

        this.init();
    }

    /**
     * Initialize the cart manager
     */
    init() {
        this.log('Initializing Simple Order Item Manager...');
        this.bindEvents();
        this.calculateInitialTotals();
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

        // Unbind any existing events first
        this.unbindEvents();

        // Increase quantity
        $(document).on('click.simpleCartManager', '.increase-quantity', (e) => {
            this.handleQuantityIncrease(e);
        });

        // Decrease quantity
        $(document).on('click.simpleCartManager', '.decrease-quantity', (e) => {
            this.handleQuantityDecrease(e);
        });

        // Remove item
        $(document).on('click.simpleCartManager', '.remove', (e) => {
            this.handleRemoveItem(e);
        });

        this.eventsBound = true;
        this.log('Event listeners bound successfully');
    }

    /**
     * Unbind all event listeners
     */
    unbindEvents() {
        $(document).off('.simpleCartManager');
        this.eventsBound = false;
        this.log('Event listeners unbound');
    }

    /**
     * Handle quantity increase
     */
    handleQuantityIncrease(event) {
        const $button = $(event.currentTarget);
        const itemId = $button.data('id');
        const currentQuantity = $button.data('current-item-quantity');
        const newQuantity = currentQuantity + 1;

        this.log(`Increasing quantity for item ${itemId} from ${currentQuantity} to ${newQuantity}`);
        this.updateQuantity(itemId, newQuantity, $button);
    }

    /**
     * Handle quantity decrease
     */
    handleQuantityDecrease(event) {
        const $button = $(event.currentTarget);
        const itemId = $button.data('id');
        const currentQuantity = $button.data('current-item-quantity');
        const newQuantity = currentQuantity - 1;

        if (newQuantity < 1) {
            this.showNotification('Minimum quantity is 1', 'warning');
            return;
        }

        this.log(`Decreasing quantity for item ${itemId} from ${currentQuantity} to ${newQuantity}`);
        this.updateQuantity(itemId, newQuantity, $button);
    }

    /**
     * Handle remove item
     */
    handleRemoveItem(event) {
        const $button = $(event.currentTarget);
        const itemId = $button.data('id');

        this.log(`Removing item ${itemId}`);
        this.removeItem(itemId, $button);
    }

    /**
     * Update item quantity
     */
    async updateQuantity(itemId, quantity, $triggerButton = null) {
        try {
            // Disable button to prevent double clicks
            if ($triggerButton) {
                $triggerButton.prop('disabled', true).addClass('processing');
            }

            const response = await axios.post(this.config.routes.updateQuantity, {
                item_id: itemId,
                quantity: quantity
            });

            this.log('Quantity update response:', response.data);

            // Update UI with new values
            this.updateQuantityInUI(itemId, quantity, response.data);

            // Recalculate totals
            this.calculateTotals();

            this.showNotification('Quantity updated successfully', 'success');

        } catch (error) {
            this.handleError(error, 'Failed to update quantity');
        } finally {
            // Re-enable button
            if ($triggerButton) {
                $triggerButton.prop('disabled', false).removeClass('processing');
            }
        }
    }

    /**
     * Remove item from cart
     */
    async removeItem(itemId, $triggerButton = null) {
        try {
            // Disable button to prevent double clicks
            if ($triggerButton) {
                $triggerButton.prop('disabled', true).addClass('processing');
            }

            const response = await axios.post(this.config.routes.removeItem, {
                item_id: itemId
            });

            this.log('Remove item response:', response.data);

            // Remove item from UI
            this.removeItemFromUI(itemId);

            // Recalculate totals
            this.calculateTotals();

            this.showNotification('Item removed successfully', 'success');

        } catch (error) {
            this.handleError(error, 'Failed to remove item');
        } finally {
            // Re-enable button (though it might be removed)
            if ($triggerButton) {
                $triggerButton.prop('disabled', false).removeClass('processing');
            }
        }
    }

    /**
     * Update quantity in UI
     */
    updateQuantityInUI(itemId, newQuantity, responseData = null) {
        const $itemRow = $(`[data-item-id="${itemId}"]`);

        if ($itemRow.length) {
            // Update quantity display
            $itemRow.find(this.config.selectors.quantityDisplay).text(newQuantity);

            // Update data attributes for buttons
            $itemRow.find('.increase-quantity, .decrease-quantity')
                .attr('data-current-item-quantity', newQuantity);

            // If response contains subtotal, update it
            if (responseData && responseData.item_subtotal) {
                const formattedSubtotal = this.formatCurrency(responseData.item_subtotal);
                $itemRow.find(this.config.selectors.itemSubtotal).text(formattedSubtotal);
            } else {
                // Calculate subtotal from price and quantity
                const unitPrice = this.getUnitPriceFromRow($itemRow);
                if (unitPrice) {
                    const subtotal = unitPrice * newQuantity;
                    const formattedSubtotal = this.formatCurrency(subtotal);
                    $itemRow.find(this.config.selectors.itemSubtotal).text(formattedSubtotal);
                }
            }

            this.log(`UI updated for item ${itemId}: quantity=${newQuantity}`);
        } else {
            this.log(`Warning: Could not find UI element for item ${itemId}`);
        }
    }

    /**
     * Remove item from UI
     */
    removeItemFromUI(itemId) {
        const $itemRow = $(`[data-item-id="${itemId}"]`);

        if ($itemRow.length) {
            $itemRow.fadeOut(300, function() {
                $(this).remove();
            });
            this.log(`Item ${itemId} removed from UI`);
        } else {
            this.log(`Warning: Could not find UI element for item ${itemId}`);
        }
    }

    /**
     * Calculate initial totals on page load
     */
    calculateInitialTotals() {
        this.calculateTotals();
    }

    /**
     * Calculate and update cart totals
     */
    calculateTotals() {
        let subtotal = 0;

        // Calculate subtotal from all visible cart items
        $('[data-item-id]').each((index, element) => {
            const $row = $(element);
            const itemSubtotal = this.getSubtotalFromRow($row);
            if (itemSubtotal) {
                subtotal += itemSubtotal;
            }
        });

        this.subTotal = subtotal;

        // Update UI
        this.updateTotalsInUI(subtotal);

        this.log(`Totals calculated: subtotal=${subtotal}`);
    }

    /**
     * Update totals in UI
     */
    updateTotalsInUI(subtotal) {
        const formattedSubtotal = this.formatCurrency(subtotal);

        // Update subtotal displays
        $(this.config.selectors.cartSubtotal).text(formattedSubtotal);

        // Update total displays (assuming total = subtotal for now)
        $(this.config.selectors.cartTotal).text(formattedSubtotal);
    }

    /**
     * Get unit price from a cart item row
     */
    getUnitPriceFromRow($row) {
        const priceText = $row.find('.unit-price, .item-price').text();
        return this.parseCurrency(priceText);
    }

    /**
     * Get subtotal from a cart item row
     */
    getSubtotalFromRow($row) {
        const subtotalText = $row.find(this.config.selectors.itemSubtotal).text();
        return this.parseCurrency(subtotalText);
    }

    /**
     * Parse currency string to number
     */
    parseCurrency(currencyString) {
        if (!currencyString) return 0;

        // Remove currency symbol and thousand separators, keep decimal point
        const cleanString = currencyString
            .replace(/[^\d.,]/g, '') // Remove all non-digit, non-comma, non-dot characters
            .replace(/,/g, ''); // Remove commas (thousand separators)

        return parseFloat(cleanString) || 0;
    }

    /**
     * Format currency
     */
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

    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        if (!this.config.notifications.enabled) return;

        const { type: notificationType } = this.config.notifications;

        if (notificationType === 'toastr' && typeof toastr !== 'undefined') {
            toastr[type](message);
        } else if (notificationType === 'alert') {
            alert(message);
        } else if (notificationType === 'custom' && this.config.notifications.customHandler) {
            this.config.notifications.customHandler(message, type);
        } else {
            console.log(`[Cart ${type.toUpperCase()}]:`, message);
        }
    }

    /**
     * Handle errors
     */
    handleError(error, fallbackMessage) {
        this.log('Error:', error);

        let errorMessage = fallbackMessage;
        if (error.response?.data?.message) {
            errorMessage = error.response.data.message;
        }

        this.showNotification(errorMessage, 'error');
    }

    /**
     * Debug logging
     */
    log(...args) {
        if (this.config.debug) {
            console.log('[SimpleCartManager]', ...args);
        }
    }

    /**
     * Public API Methods
     */

    // Get current subtotal
    getSubTotal() {
        return this.subTotal;
    }

    // Manually recalculate totals
    recalculateTotals() {
        this.calculateTotals();
    }

    // Destroy cart manager and cleanup
    destroy() {
        this.unbindEvents();
        this.subTotal = 0;
        this.log('Simple Cart Manager destroyed');
    }
}



// Export for module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = SimpleCartManager;
}
