<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Status Update - #{{ $order->order_number }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px; color: #111827;">
    <table width="100%"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #dc2626; margin-bottom: 20px;">
                    📦 Order Status Update
                </h2>

                <p style="font-size: 16px; margin-bottom: 20px;">
                    Hello {{ $isAdmin ? 'Admin' : $order->user?->full_name }},
                </p>

                <p style="font-size: 14px; color: #6b7280; margin-bottom: 25px;">
                    {{ $isAdmin ? 'We have an update regarding an order.' : 'We have an update regarding your order. Here are the latest details:' }}
                </p>

                <!-- Order Info Card -->
                <div
                    style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                    <h3 style="margin-top: 0; margin-bottom: 15px; color: #1e293b;">
                        🛒 Order #{{ $order->order_number }}
                    </h3>

                    <table width="100%" style="font-size: 14px;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;"><strong>Order Date:</strong>
                            </td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
                                {{ $order->created_at_formatted }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;"><strong>Items:</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
                                {{ $order->items?->sum('quantity') ?? 0 }} items</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;"><strong>Order Value:</strong>
                            </td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
                                @php
                                    $total = $order->total;
                                    if ($order->containerReservation) {
                                        $total += $order->containerReservation?->total ?? 0;
                                    }
                                @endphp
                                ${{ number_format($order->total ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Last Updated:</strong></td>
                            <td style="padding: 8px 0;">
                                {{ $order->updated_at_formatted }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Status Update -->
                <div
                    style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 20px; margin-bottom: 25px;">
                    <h3 style="margin-top: 0; margin-bottom: 10px; color: #15803d;">
                        📋 Current Status
                    </h3>
                    <p style="font-size: 18px; font-weight: bold; color: #15803d; margin-bottom: 10px;">
                        {{ $order->status_label ?? 'Status Update' }}
                    </p>
                    <p style="font-size: 14px; color: #374151; margin-bottom: 0; line-height: 1.5;">
                        {{ $isAdmin ? 'An order status has been updated. Please check the details for more information about the order progress.' : 'Your order status has been updated. Please check the details for more information about your order progress.' }}
                    </p>
                </div>

                <!-- Shipping Info (if available) -->
                @if ($order->shippingPort || $order->destinationPort || $order->container)
                    <div
                        style="background-color: #fef7cd; border: 1px solid #fde047; border-radius: 6px; padding: 15px; margin-bottom: 25px;">
                        <h4 style="margin-top: 0; margin-bottom: 10px; color: #92400e;">🚢 Shipping Information</h4>
                        @if ($order->shippingPort && $order->destinationPort)
                            <p style="margin: 5px 0; font-size: 14px;"><strong>Route:</strong>
                                {{ $order->shippingPort->name }} → {{ $order->destinationPort->name }}</p>
                        @endif
                        @if ($order->container)
                            <p style="margin: 5px 0; font-size: 14px;"><strong>Container:</strong>
                                {{ $order->container->title ?? 'Assigned' }}</p>
                        @endif
                        <p style="margin: 5px 0; font-size: 14px;"><strong>Container Type:</strong>
                            {{ $order->container_type_label }}</p>
                    </div>
                @endif

                <!-- Action Button -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $isAdmin ? route('om.order.details', encrypt($order->id)) : route('user.order.details', $order->order_number) }}"
                        style="background-color: #dc2626; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                        📋 View Order Details
                    </a>
                </div>

                <!-- Footer -->
                <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 30px;">
                    <p style="font-size: 12px; color: #6b7280; margin-bottom: 10px;">
                        {{ $isAdmin ?: 'If you have any questions about your order status, please don\'t hesitate to contact us.' }}
                    </p>
                    <p style="margin-top: 20px; font-size: 14px;">
                        Best regards,<br>
                        <strong>{{ config('app.name') }}</strong>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
