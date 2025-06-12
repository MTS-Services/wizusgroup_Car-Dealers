@extends('frontend.layouts.app', ['page_slug' => 'orders'])

@section('title', 'Order Finished')

@section('content')
    <div class="container mx-auto px-4 py-8 " id="order_details_container">
        <div class="max-w-4xl mx-auto">

            <!-- Order Voucher -->
            <div id="voucher" class="bg-white border-2 border-gray-300 rounded-lg shadow-xl p-8 mb-8">
                <!-- Header -->
                <div class="text-center border-b-2 border-gray-200 pb-6 mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        @if (isset($order->container) && $order->container)
                            {{ __('CONTAINER JOIN & ORDER DETAILS') }}
                        @else
                            {{ __('CONTAINER REQUEST & ORDER DETAILS') }}
                        @endif
                    </h1>
                    <div class="text-lg text-gray-600">
                        <p>{{ __('Order Number') }}: <span
                                class="font-semibold text-blue-600">#{{ $order->order_number }}</span></p>
                        <p>{{ __('Order Date') }}: <span
                                class="font-semibold">{{ $order->created_at->format('F d, Y') }}</span>
                        </p>
                        <p>{{ __('Status') }}: <span
                                class="font-semibold text-green-600">{{ $order->status_label ?? 'Pending' }}</span></p>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('👤 Customer Information') }}</h3>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-medium">{{ __('Name') }}:</span>
                                {{ $order->user?->full_name ?? 'N/A' }}</p>
                            <p><span class="font-medium">{{ __('Email') }}:</span> {{ $order->user?->email ?? 'N/A' }}
                            </p>
                            <p><span class="font-medium">{{ __('Phone') }}:</span> {{ $order->user?->phone }}</p>

                            <p><span class="font-medium">{{ __('WhatsApp') }}:</span> {{ $order->user?->whatsapp }}
                            </p>

                        </div>
                    </div>

                    @if ($order->shipping)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('📍 Shipping Information') }}</h3>
                            <div class="space-y-2 text-sm">
                                @if ($order->shipping->email)
                                    <p><span class="font-medium">{{ __('Email') }}:</span> {{ $order->shipping->email }}
                                    </p>
                                @endif
                                @if ($order->shipping->address_line_1)
                                    <p><span class="font-medium">{{ __('Address') }}:</span>
                                        {{ $order->shipping->address_line_1 }}</p>
                                @endif
                                @if ($order->shipping->city)
                                    <p><span class="font-medium">{{ __('City') }}:</span>
                                        {{ $order->shipping->city->name ?? $order->shipping->city }}</p>
                                @endif
                                @if ($order->shipping->state)
                                    <p><span class="font-medium">{{ __('State') }}:</span>
                                        {{ $order->shipping->state->name ?? $order->shipping->state }}</p>
                                @endif
                                @if ($order->shipping->country)
                                    <p><span class="font-medium">{{ __('Country') }}:</span>
                                        {{ $order->shipping->country->name ?? $order->shipping->country }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Shipping Route -->
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('🚢 Shipping Route') }}</h3>
                    <div class="grid md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p><span class="font-medium">{{ __('From') }}:</span>
                                {{ $order->shippingPort->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-center">
                            <span class="text-blue-600 font-bold">→</span>
                        </div>
                        <div>
                            <p><span class="font-medium">{{ __('To') }}:</span>
                                {{ $order->destinationPort->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <p class="mt-2"><span class="font-medium">{{ __('Container Type') }}:</span>
                        {{ $order->container_type_label ?? 'N/A' }}</p>
                </div>

                <!-- Container Information (if exists) -->
                @if (isset($order->container) && $order->container)
                    <div class="bg-green-50 p-4 rounded-lg mb-6 border-l-4 border-green-500">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('🚢 Container Information') }}
                            <span class="font-bold">({{ $order->container->status_label }})</span>
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p><span class="font-medium">{{ __('Container') }}:</span>
                                    {{ $order->container->title ?? 'N/A' }}</p>
                                <p><span class="font-medium">{{ __('Type') }}:</span>
                                    {{ $order->container_type_label ?? 'N/A' }}</p>
                                <p><span class="font-medium">{{ __('Dimensions') }}:</span>
                                    {{ $order->container->length_m ?? 0 }}m × {{ $order->container->width_m ?? 0 }}m ×
                                    {{ $order->container->height_m ?? 0 }}m</p>
                            </div>
                            <div>
                                <p><span class="font-medium">{{ __('Max Weight') }}:</span>
                                    {{ number_format($order->container->max_weight_kg ?? 0) }} kg</p>
                                <p><span class="font-medium">{{ __('Base Cost') }}:</span>
                                    ${{ number_format($order->container->base_cost ?? 0, 2) }}</p>
                                <p><span class="font-medium">{{ __('Per CBM Cost') }}:</span>
                                    ${{ number_format($order->container->per_cbm_cost ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Container Request Information -->
                    @php
                        $totalHeight = $order->items->sum(
                            fn($item) => optional($item->product)->height_m
                                ? $item->product->height_m * $item->quantity
                                : 0,
                        );
                        $totalWidth = $order->items->sum(
                            fn($item) => optional($item->product)->width_m
                                ? $item->product->width_m * $item->quantity
                                : 0,
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
                        $totalCBM = $totalHeight * $totalWidth * $totalLength;
                    @endphp
                    <div class="bg-yellow-50 p-4 rounded-lg mb-6 border-l-4 border-yellow-500">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">
                            {{ __('📏 Requested Container Requirements') }}</h3>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p><span class="font-medium">{{ __('Minimum Length') }}:</span>
                                    {{ number_format($totalLength, 2) }} meters</p>
                                <p><span class="font-medium">{{ __('Minimum Width') }}:</span>
                                    {{ number_format($totalWidth, 2) }} meters</p>
                                <p><span class="font-medium">{{ __('Minimum Height') }}:</span>
                                    {{ number_format($totalHeight, 2) }} meters</p>
                            </div>
                            <div>
                                <p><span class="font-medium">{{ __('Minimum Weight Capacity') }}:</span>
                                    {{ number_format($totalWeight, 2) }} kg</p>
                                <p><span class="font-medium">{{ __('Estimated CBM') }}:</span>
                                    {{ number_format($totalCBM, 2) }} m³</p>
                                <p><span class="font-medium">{{ __('Container Type Preference') }}:</span>
                                    {{ $order->container_type_label ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Items -->
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-4 text-gray-800">{{ __('📦 Order Items') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left">#</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">{{ __('Product') }}</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Qty') }}</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Dimensions (L×W×H)') }}
                                    </th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">{{ __('Weight') }}</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">{{ __('Unit Price') }}</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $index => $item)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $item->product->name ?? 'N/A' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $item->quantity }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            {{ number_format($item->product->length_m ?? 0, 2) }}×{{ number_format($item->product->width_m ?? 0, 2) }}×{{ number_format($item->product->height_m ?? 0, 2) }}m
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            {{ number_format(($item->product->weight_kg ?? 0) * $item->quantity, 2) }} kg
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">
                                            ${{ number_format($item->product->price ?? 0, 2) }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right">
                                            ${{ number_format($item->quantity * ($item->product->price ?? 0), 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
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

                    $order->containerPrice = 0;
                    $reservePrice = 0;
                    if (isset($order->container) && $order->container) {
                        $order->containerPrice =
                            $order->container->per_cbm_cost * $totalCBM + $order->container->base_cost;
                        $reservePrice = $order->containerPrice / 2;
                    }
                @endphp

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('📊 Order Summary') }}</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p><span class="font-medium">{{ __('Total Items') }}:</span>
                                {{ $order->items->sum('quantity') }}</p>
                            <p><span class="font-medium">{{ __('Total Cargo Dimensions') }}:</span>
                                {{ number_format($totalLength, 2) }}m × {{ number_format($totalWidth, 2) }}m ×
                                {{ number_format($totalHeight, 2) }}m</p>
                            <p><span class="font-medium">{{ __('Total Weight') }}:</span>
                                {{ number_format($totalWeight, 2) }} kg</p>
                        </div>
                        <div>
                            <p><span class="font-medium">{{ __('Total CBM') }}:</span> {{ number_format($totalCBM, 2) }}
                                m³</p>
                            <p><span class="font-medium">{{ __('Order Total') }}:</span> <span
                                    class="text-lg font-bold text-blue-600">${{ number_format($order->total, 2) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Container Pricing (if container exists) -->
                @if (isset($order->container) && $order->container && $order->containerPrice > 0)
                    <div class="bg-blue-50 p-4 rounded-lg mb-6 border-l-4 border-blue-500">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('💰 Container Shipping Cost') }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>{{ __('Base Cost') }}:</span>
                                <span>${{ number_format($order->container->base_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('Per CBM Cost') }}:</span>
                                <span>${{ number_format($order->container->per_cbm_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('CBM Cost') }} (${{ number_format($order->container->per_cbm_cost, 2) }} ×
                                    {{ number_format($totalCBM, 2) }} m³):</span>
                                <span>${{ number_format($order->container->per_cbm_cost * $totalCBM, 2) }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>{{ __('Total Container Price') }}:</span>
                                <span class="text-red-600">${{ number_format($order->containerPrice, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium text-green-600">
                                <span>{{ __('Reserve Amount (50%)') }}:</span>
                                <span>${{ number_format($reservePrice, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="bg-blue-100 p-6 rounded-lg border-2 border-blue-300">
                        <h3 class="font-bold text-xl mb-4 text-blue-800 text-center">{{ __('💰 Total Cost Summary') }}
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-lg">
                                <span class="font-medium">{{ __('Order Total') }}:</span>
                                <span class="font-bold">${{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-lg">
                                <span class="font-medium">{{ __('Container Shipping') }}:</span>
                                <span class="font-bold">${{ number_format($order->containerPrice, 2) }}</span>
                            </div>
                            <hr class="border-blue-300">
                            <div class="flex justify-between text-2xl font-bold text-blue-800">
                                <span>{{ __('Grand Total') }}:</span>
                                <span>${{ number_format($order->total + $order->containerPrice, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- <!-- Next Steps -->
                <div class="bg-indigo-50 p-4 rounded-lg mt-6 border-l-4 border-indigo-500">
                    <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('📋 Next Steps') }}</h3>
                    <ul class="text-sm space-y-1">
                        @if (isset($order->container) && $order->container)
                            <li>• {{ __('Our team will review your container reservation') }}</li>
                            <li>• {{ __('You will receive payment instructions within 24 hours') }}</li>
                            <li>• {{ __('Container booking will be confirmed after payment') }}</li>
                            <li>• {{ __('Shipping schedule and documentation will be provided') }}</li>
                        @else
                            <li>• {{ __('Our team will review your container requirements') }}</li>
                            <li>• {{ __('We will search for suitable containers on your route') }}</li>
                            <li>• {{ __('You will receive container options and pricing within 24-48 hours') }}</li>
                            <li>• {{ __('Container allocation will proceed once you confirm your choice') }}</li>
                        @endif
                    </ul>
                </div> --}}

                <!-- Contact Information -->
                <div class="bg-yellow-50 p-4 rounded-lg mt-6 border-l-4 border-yellow-500">
                    <h3 class="font-semibold text-lg mb-3 text-gray-800">{{ __('📞 Contact Us') }}</h3>
                    <p class="text-sm mb-2">
                        {{ __('For any questions or concerns about your order, please contact us:') }}</p>
                    <div class="text-sm space-y-1">
                        <p>• {{ __('Email') }}: {{ settings('email') }}</p>
                        <p>• {{ __('Phone') }}: {{ settings('phone') }}</p>
                        <p>• {{ __('WhatsApp') }}: {{ settings('whatsapp') }}</p>
                        <p>• {{ __('Business Hours') }}: {{ __('Always open') }}</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 pt-6 border-t-2 border-gray-200">
                    <p class="text-gray-600 text-sm">{{ __('Thank you for choosing') }}
                        <strong>{{ config('app.name') }}</strong>
                    </p>
                    {{-- <p class="text-gray-500 text-xs mt-2">{{ __('This voucher was generated on') }}
                        {{ now()->format('F d, Y \a\t h:i A') }}</p> --}}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center space-x-4">
                <a href="{{ route('user.profile', ['slug' => 'orders']) }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg">
                    {{ __('View All Orders') }}
                </a>
                <button onclick="downloadVoucher()"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">
                    {{ __('Print Voucher') }}
                </button>
            </div>
        </div>
    </div>

    <script>
        function downloadVoucher() {
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            const voucherContent = document.getElementById('voucher').innerHTML;

            printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Order Voucher - #{{ $order->order_number }}</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; color: #333; }
                            .bg-gray-50 { background-color: #f9fafb; }
                            .bg-blue-50 { background-color: #eff6ff; }
                            .bg-green-50 { background-color: #f0fdf4; }
                            .bg-yellow-50 { background-color: #fefce8; }
                            .bg-indigo-50 { background-color: #eef2ff; }
                            .bg-blue-100 { background-color: #dbeafe; }
                            .border-l-4 { border-left: 4px solid; }
                            .border-green-500 { border-left-color: #10b981; }
                            .border-yellow-500 { border-left-color: #f59e0b; }
                            .border-blue-500 { border-left-color: #3b82f6; }
                            .border-indigo-500 { border-left-color: #6366f1; }
                            .border-blue-300 { border-color: #93c5fd; }
                            .text-blue-600 { color: #2563eb; }
                            .text-green-600 { color: #16a34a; }
                            .text-red-600 { color: #dc2626; }
                            .text-blue-800 { color: #1e40af; }
                            .p-4 { padding: 1rem; }
                            .p-6 { padding: 1.5rem; }
                            .mb-3 { margin-bottom: 0.75rem; }
                            .mb-6 { margin-bottom: 1.5rem; }
                            .mt-6 { margin-top: 1.5rem; }
                            .mt-8 { margin-top: 2rem; }
                            .pt-6 { padding-top: 1.5rem; }
                            .rounded-lg { border-radius: 0.5rem; }
                            .font-semibold { font-weight: 600; }
                            .font-bold { font-weight: 700; }
                            .text-lg { font-size: 1.125rem; }
                            .text-xl { font-size: 1.25rem; }
                            .text-2xl { font-size: 1.5rem; }
                            .text-3xl { font-size: 1.875rem; }
                            .text-sm { font-size: 0.875rem; }
                            .text-xs { font-size: 0.75rem; }
                            .text-center { text-align: center; }
                            .text-right { text-align: right; }
                            .space-y-1 > * + * { margin-top: 0.25rem; }
                            .space-y-2 > * + * { margin-top: 0.5rem; }
                            .space-y-3 > * + * { margin-top: 0.75rem; }
                            .grid { display: grid; }
                            .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                            .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
                            .gap-4 { gap: 1rem; }
                            .flex { display: flex; }
                            .justify-between { justify-content: space-between; }
                            .border { border: 1px solid #d1d5db; }
                            .border-t-2 { border-top: 2px solid #d1d5db; }
                            .border-b-2 { border-bottom: 2px solid #d1d5db; }
                            .border-2 { border: 2px solid; }
                            .border-gray-200 { border-color: #e5e7eb; }
                            .border-gray-300 { border-color: #d1d5db; }
                            table { border-collapse: collapse; width: 100%; }
                            th, td { border: 1px solid #d1d5db; padding: 8px; }
                            th { background-color: #f3f4f6; }
                            @media print {
                                body { margin: 0; }
                            }
                        </style>
                    </head>
                    <body>
                        ${voucherContent}
                    </body>
                    </html>
                `);

            printWindow.document.close();
            printWindow.focus();

            // Wait for content to load then print
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 250);
        }
    </script>

@endsection
