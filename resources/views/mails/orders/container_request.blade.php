<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $isAdmin ? 'New Container Request' : 'Container Request Confirmation' }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px; color: #111827;">
    <table width="100%"
        style="max-width: 700px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #dc2626;">
                    {{ $isAdmin ? '📢 New Container Request Submitted' : '📦 Container Request Confirmation' }}
                </h2>

                <p>
                    Hello {{ $isAdmin ? 'Admin' : $order->user?->full_name ?? 'Customer' }},
                </p>
                <p>
                    {{ $isAdmin ? 'A new container request has been submitted. See details below:' : 'Your container
                    request has been received successfully. We will arrange a suitable container for your shipment and
                    notify you once available.' }}
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

                <h3>🚢 Requested Container Requirements</h3>
                @php
                $totalHeight = $order->items->sum(fn($item) => optional($item->product)->height_m ?
                $item->product->height_m * $item->quantity : 0);
                $totalWidth = $order->items->sum(fn($item) => optional($item->product)->width_m ?
                $item->product->width_m * $item->quantity : 0);
                $totalLength = $order->items->sum(fn($item) => optional($item->product)->length_m ?
                $item->product->length_m * $item->quantity : 0);
                $totalWeight = $order->items->sum(fn($item) => optional($item->product)->weight_kg ?
                $item->product->weight_kg * $item->quantity : 0);
                $totalCBM = $totalHeight * $totalWidth * $totalLength;
                @endphp

                <div
                    style="background-color: #fef3c7; padding: 15px; border-radius: 6px; margin: 15px 0; border-left: 4px solid #f59e0b;">
                    <h4 style="margin-top: 0; color: #92400e;">📏 Minimum Container Specifications Required</h4>
                    <ul style="margin-bottom: 0;">
                        <li><strong>Minimum Length:</strong> {{ number_format($totalLength, 2) }} meters</li>
                        <li><strong>Minimum Width:</strong> {{ number_format($totalWidth, 2) }} meters</li>
                        <li><strong>Minimum Height:</strong> {{ number_format($totalHeight, 2) }} meters</li>
                        <li><strong>Minimum Weight Capacity:</strong> {{ number_format($totalWeight, 2) }} kg</li>
                        <li><strong>Estimated CBM:</strong> {{ number_format($totalCBM, 2) }} m³</li>
                        <li><strong>Route:</strong> {{ $order->shippingPort?->name ?? 'N/A' }} → {{
                            $order->destinationPort?->name ?? 'N/A' }}</li>
                        <li><strong>Container Type Preference:</strong> {{ $order->container_type_label }}</li>
                    </ul>
                </div>

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
                            <th>Dimensions (L×W×H)</th>
                            <th>Weight</th>
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
                            <td>
                                {{ number_format(($item->product?->length_m ?? 0), 2) }}×{{
                                number_format(($item->product?->width_m ?? 0), 2) }}×{{
                                number_format(($item->product?->height_m ?? 0), 2) }}m
                            </td>
                            <td>{{ number_format(($item->product?->weight_kg ?? 0) * $item->quantity, 2) }} kg</td>
                            <td>${{ number_format($item->product?->price ?? 0, 2) }}</td>
                            <td>${{ number_format($item->quantity * ($item->product?->price ?? 0), 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 15px 0;">
                    <h4 style="margin-top: 0; color: #374151;">📊 Order Totals</h4>
                    <ul style="margin-bottom: 0;">
                        <li><strong>Total Product Quantity:</strong> {{ $order->items->sum('quantity') }} items</li>
                        <li><strong>Total Cargo Weight:</strong> {{ number_format($totalWeight, 2) }} kg</li>
                        <li><strong>Total Cargo Volume:</strong> {{ number_format($totalCBM, 2) }} m³</li>
                        <li><strong>Total Order Price:</strong> <span style="font-size: 18px; color: #dc2626;">${{
                                number_format($order->total, 2) }}</span></li>
                    </ul>
                </div>

                <hr>

                <div
                    style="background-color: #e0f2fe; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #0288d1;">
                    <h3 style="margin-top: 0; color: #01579b;">📋 Next Steps</h3>
                    <p style="margin-bottom: 10px;"><strong>{{ $isAdmin ? 'Admin Action Required:' : 'What happens
                            next:' }}</strong></p>
                    <ul style="margin-bottom: 0;">
                        @if($isAdmin)
                        <li>Review the container requirements and customer details</li>
                        <li>Search for available containers matching the specifications</li>
                        <li>Contact the customer with container options and pricing</li>
                        <li>Arrange container allocation once confirmed</li>
                        @else
                        <li>Our team will review your container requirements</li>
                        <li>We'll search for suitable containers on your preferred route</li>
                        <li>You'll receive container options and pricing within 24-48 hours</li>
                        <li>Once you confirm, we'll proceed with container allocation</li>
                        @endif
                    </ul>
                </div>

                @if(!$isAdmin)
                <div
                    style="background-color: #fef7cd; padding: 15px; border-radius: 6px; margin: 15px 0; border-left: 4px solid #eab308;">
                    <p style="margin: 0; color: #a16207;"><strong>⏰ Important:</strong> Container pricing will be
                        provided based on availability and route. You'll be notified via email and WhatsApp once we have
                        suitable options for your shipment.</p>
                </div>
                @endif

                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $isAdmin ? '#' : route('frontend.container-order', $order->order_number) }}"
                        style="background-color: #2563eb; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px;">
                        {{ $isAdmin ? 'View in Admin Panel' : 'View Your Request' }}
                    </a>
                </div>

                <p style="margin-top: 40px;">Regards,<br><strong>{{ config('app.name') }}</strong></p>
            </td>
        </tr>
    </table>
</body>

</html>