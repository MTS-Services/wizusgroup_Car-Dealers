@if ($order->status == App\Models\Order::STATUS_INITIATED)
    <a href="{{ route('frontend.checkout', $order->order_number) }}" class="text-text-secondary hover:text-text-tertiary">
        <i data-lucide="eye" class="w-5 h-5"></i>
    </a>
@elseif ($order->status == App\Models\Order::STATUS_PENDING)
    <a href="{{ route('frontend.container-order', $order->order_number) }}" class="text-text-secondary hover:text-text-tertiary">
        <i data-lucide="eye" class="w-5 h-5"></i>
    </a>
@else
    <a href="{{ route('user.order.details', $order->order_number) }}" class="text-text-secondary hover:text-text-tertiary">
        <i data-lucide="eye" class="w-5 h-5"></i>
    </a>
    @if($order->container)
        <a href="{{ route('user.container.details', $order->container?->slug) }}" class="text-text-secondary hover:text-text-tertiary">
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>
    @endif
@endif
