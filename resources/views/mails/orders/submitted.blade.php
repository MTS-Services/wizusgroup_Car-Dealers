<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $isAdmin ? 'New Order Submitted' : 'Order Confirmation' }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px; color: #111827;">
    <table width="100%"
        style="max-width: 700px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #dc2626;">
                    {{ $isAdmin ? '📢 New Order Submitted' : '🛒 Order Submitted Successfully' }}
                </h2>

                <p>
                    Hello {{ $isAdmin ? 'Admin' : $order->user?->full_name ?? 'Customer' }},
                </p>
                <p>
                    {{ $isAdmin ? 'A new order has been placed. See details below:' : 'Your order has been received successfully. Here are the details:' }}
                </p>

                <hr>

                <h3>📦 Order Summary</h3>
                <ul>
                    <li><strong>Order Number:</strong> #{{ $order->order_number }}</li>
                    <li><strong>Status:</strong> {{ $order->status_label }}</li>
                    <li><strong>Container Type:</strong> {{ $order->container_type_label }}</li>
                    <li><strong>Shipping Port:</strong> {{ $order->shippingPort?->name ?? 'N/A' }}</li>
                    <li><strong>Destination Port:</strong> {{ $order->destinationPort?->name ?? 'N/A' }}</li>
                    <li><strong>Submitted At:</strong> {{ $order->created_at_formatted }}</li>
                </ul>

                <hr>

                <h3>👤 Customer Info</h3>
                <ul>
                    <li><strong>Name:</strong> {{ $order->user?->name }}</li>
                    <li><strong>Email:</strong> {{ $order->user?->email }}</li>
                    <li><strong>Phone:</strong> {{ $order->user?->phone }}</li>
                    <li><strong>Whatsapp:</strong> {{ $order->user?->whatsapp ?? $order->shipping?->phone }}</li>
                    <li><strong>Address:</strong><br>
                        {{ $order->shipping?->address_line_1 }}<br>
                        {{ $order->shipping?->city?->name }},
                        {{ $order->shipping?->state?->name }},
                        {{ $order->shipping?->country?->name }}
                    </li>
                </ul>

                <hr>

                <h3>🧾 Order Items</h3>
                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                    style="border-collapse: collapse; margin-bottom: 15px;">
                    <thead style="background-color: #e5e7eb;">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product?->name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product?->price ?? 0, 2) }}</td>
                                <td>${{ number_format($item->quantity * ($item->product?->price ?? 0), 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p><strong>Total Quantity:</strong> {{ $order->items->sum('quantity') }}</p>
                <p><strong>Total Price:</strong> ${{ number_format($order->total, 2) }}</p>

                <hr>

                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $isAdmin ? '#' : route('frontend.container-order', $order->order_number) }}"
                        style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px;">
                        {{ $isAdmin ? 'View in Admin Panel' : 'View Your Order' }}
                    </a>
                </div>

                <p style="margin-top: 40px;">Regards,<br><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
    </table>
</body>

</html>
