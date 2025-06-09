<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $isAdmin ? 'New Container Reservation Request' : 'Container Reservation Confirmation' }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px; color: #111827;">
    <table width="100%"
        style="max-width: 700px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #dc2626;">
                    {{ $isAdmin ? '📢 New Container Join Request' : '🚢 Container Join Confirmation' }}
                </h2>

                <p>
                    Hello {{ $isAdmin ? 'Admin' : $order->user?->full_name ?? 'Customer' }},
                </p>
                <p>
                    {{ $isAdmin ? 'A new container reservation request has been submitted. See details below:' : 'Your container reservation request has been received successfully. Here are the details:' }}
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

                <h3>🚢 Container Information</h3>
                @if ($order->container)
                    <ul>
                        <li><strong>Container:</strong> {{ $order->container?->title }}</li>
                        <li><strong>Container Type:</strong> {{ $order->container_type_label ?? 'N/A' }}</li>
                        <li><strong>Dimensions:</strong> {{ $order->container?->length_m }}m ×
                            {{ $order->container?->width_m }}m × {{ $order->container?->height_m }}m</li>
                        <li><strong>Max Weight:</strong> {{ $order->container?->max_weight_kg ?? 'N/A' }} kg</li>
                        <li><strong>Base Cost:</strong> ${{ number_format($order->container?->base_cost ?? 0, 2) }}
                        </li>
                        <li><strong>Per CBM Cost:</strong>
                            ${{ number_format($order->container?->per_cbm_cost ?? 0, 2) }}</li>
                        {{-- <li><strong>Departure Date:</strong>
                            {{ $order->container?->departure_date ? \Carbon\Carbon::parse($order->container?->departure_date)->format('M d, Y') : 'N/A' }}
                        </li> --}}
                    </ul>
                @else
                    <p style="color: #dc2626;">Container information not available</p>
                @endif

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

                <p><strong>Total Order Quantity:</strong> {{ $order->items->sum('quantity') }}</p>
                <p><strong>Total Order Price:</strong> ${{ number_format($order->total, 2) }}</p>

                <hr>

                <h3>📏 Cargo Dimensions & Container Pricing</h3>
                @php
                    $totalHeight = $order->items->sum(
                        fn($item) => optional($item->product)->height_m
                            ? $item->product->height_m * $item->quantity
                            : 0,
                    );
                    $totalWidth = $order->items->sum(
                        fn($item) => optional($item->product)->width_m ? $item->product->width_m * $item->quantity : 0,
                    );
                    $totalLength = $order->items->sum(
                        fn($item) => optional($item->product)->length_m
                            ? $item->product->length_m * $item->quantity
                            : 0,
                    );
                    $totalWeight = $order->items->sum(
                        fn($item) => optional($item->product)->weight_kg
                            ? $item->product->weight_kg * $item->quantity
                            : 0,
                    );
                    $totalCBM = $totalHeight + $totalWidth + $totalLength;

                    $containerPrice = 0;
                    $reservePrice = 0;
                    if ($order->container) {
                        $containerPrice = $order->container?->per_cbm_cost * $totalCBM + $order->container?->base_cost;
                        $reservePrice = $containerPrice / 2;
                    }
                @endphp

                <ul>
                    <li><strong>Total Cargo Dimensions:</strong> {{ number_format($totalLength, 2) }}m ×
                        {{ number_format($totalWidth, 2) }}m × {{ number_format($totalHeight, 2) }}m</li>
                    <li><strong>Total Weight:</strong> {{ number_format($totalWeight, 2) }} kg</li>
                    <li><strong>Total CBM:</strong> {{ number_format($totalCBM, 2) }} m³</li>
                </ul>

                @if ($order->container && $containerPrice > 0)
                    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 6px; margin: 15px 0;">
                        <h4 style="margin-top: 0; color: #374151;">💰 Container Shipping Cost Breakdown</h4>
                        <ul style="margin-bottom: 0;">
                            <li><strong>Base Cost:</strong> ${{ number_format($order->container?->base_cost, 2) }}</li>
                            <li><strong>CBM Cost:</strong> ${{ number_format($order->container?->per_cbm_cost, 2) }} ×
                                {{ number_format($totalCBM, 2) }} m³ =
                                ${{ number_format($order->container?->per_cbm_cost * $totalCBM, 2) }}</li>
                            <li><strong>Total Container Price:</strong> <span
                                    style="font-size: 18px; color: #dc2626;">${{ number_format($containerPrice, 2) }}</span>
                            </li>
                            <li><strong>Reserve Amount (50%):</strong> <span
                                    style="font-size: 16px; color: #059669;">${{ number_format($reservePrice, 2) }}</span>
                            </li>
                        </ul>
                    </div>
                @endif

                <hr>

                <div style="background-color: #dbeafe; padding: 20px; border-radius: 6px; margin: 20px 0;">
                    <h3 style="margin-top: 0; color: #1e40af;">💰 Total Cost Summary</h3>
                    <table width="100%" style="font-size: 16px;">
                        <tr>
                            <td><strong>Order Total:</strong></td>
                            <td style="text-align: right;"><strong>${{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                        @if ($containerPrice > 0)
                            <tr>
                                <td><strong>Container Shipping:</strong></td>
                                <td style="text-align: right;">
                                    <strong>${{ number_format($containerPrice, 2) }}</strong>
                                </td>
                            </tr>
                            <tr style="border-top: 2px solid #1e40af; font-size: 18px; color: #1e40af;">
                                <td><strong>Grand Total:</strong></td>
                                <td style="text-align: right;">
                                    <strong>${{ number_format($order->total + $containerPrice, 2) }}</strong>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>

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
