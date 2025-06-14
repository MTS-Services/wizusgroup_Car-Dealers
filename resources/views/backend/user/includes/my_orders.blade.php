<div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
    <div class="max-w-6xl mx-auto">
        <!-- Orders Panel Header -->
        <div class="pb-4">
            <h2 class="text-xl lg:text-2xl font-semibold text-text-primary dark:text-text-white">
                {{ __('My Orders') }}</h2>
        </div>

        <!-- Orders Panel -->
        <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-lg shadow-md overflow-hidden">
            <!-- Filters and Search -->
            <div
                class="p-4 border-b dark:border-b-border-gray dark:border-opacity-50 flex flex-wrap justify-between items-center">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.profile', ['slug' => 'orders', 'tab' => 'all']) }}"
                        class="btn-item {{ request('tab') == 'all' || request('tab') == null ? ' bg-bg-tertiary ' : '' }} btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                        {{ __('All Orders') }}
                    </a>
                    <a href="{{ route('user.profile', ['slug' => 'orders', 'tab' => 'pending']) }}"
                        class="btn-item {{ request('tab') == 'pending' ? ' bg-bg-tertiary ' : '' }} btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                        {{ __('Pending') }}
                    </a>
                    <a href="{{ route('user.profile', ['slug' => 'orders', 'tab' => 'submitted']) }}"
                        class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary {{ request('tab') == 'submitted' ? ' bg-bg-tertiary ' : '' }}">
                        {{ __('Submitted') }}
                    </a>
                    <a href="{{ route('user.profile', ['slug' => 'orders', 'tab' => 'shipped']) }}"
                        class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary {{ request('tab') == 'shipped' ? ' bg-bg-tertiary ' : '' }}">
                        {{ __('Shipped') }}
                    </a>
                    <a href="{{ route('user.profile', ['slug' => 'orders', 'tab' => 'completed']) }}"
                        class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary {{ request('tab') == 'completed' ? ' bg-bg-tertiary ' : '' }}">
                        {{ __('Completed') }}
                    </a>
                </div>
                @if (isset($not_use))
                    {{-- <div class="relative">
                        <input type="text" placeholder="Search orders..."
                            class="pl-10 pr-4 py-2 border border-border-gray dark:border-opacity-50 rounded-md focus:outline-none focus:ring-1 focus:ring-bg-tertiary">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-gray">
                            <i class="w-5 h-5" data-lucide="search"></i>
                        </div>
                    </div> --}}
                @endif

            </div>
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-bg-gray bg-opacity-50 dark:bg-opacity-20 text-left">
                        <tr>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                {{ __('Order Number') }}</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                {{ __('Date') }}</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                {{ __('Amount') }}</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                {{ __('Status') }}</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                {{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray dark:divide-opacity-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                                <td class="px-6 py-4 text-sm font-medium text-text-gray dark:text-text-light">
                                    {{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-sm text-text-gray dark:text-text-light">
                                    {{ $order->created_at_formatted }}</td>
                                <td class="px-6 py-4 text-sm text-text-gray dark:text-text-light">
                                    ${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_tailwind_color }} text-text-white">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @include('components.frontend.order-actions', ['order' => $order])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="block md:hidden">
                @foreach ($orders as $order)
                    <div class="bg-bg-white dark:bg-bg-dark rounded-lg shadow p-2 m-4">
                        <div class="text-sm text-text-primary dark:text-text-light font-medium mb-2">
                            {{ __('Order Number') }}: <span class="text-text-gray">{{ $order->order_number }}</span>
                        </div>
                        <div class="text-sm text-text-primary dark:text-text-light">
                            {{ __('Date') }}: <span
                                class="text-text-gray">{{ $order->created_at_formatted }}</span>
                        </div>
                        <div class="text-sm text-text-primary dark:text-text-light">
                            {{ __('Amount') }}: <span
                                class="text-text-gray">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="text-sm text-text-primary dark:text-text-light">
                            {{ __('Status') }}:
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $order->status_tailwind_color }} text-white inline-block">
                                {{ $order->status_label }}
                            </span>
                        </div>
                        <div class="mt-2 flex gap-2">
                            @include('components.frontend.order-actions', ['order' => $order])
                        </div>
                    </div>
                @endforeach
            </div>


            @if ($orders->hasPages())
                <div
                    class="px-6 py-4 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                    <div class="text-sm text-text-gray dark:text-text-light">
                        Showing <span class="font-medium">{{ $orders->firstItem() }}</span> to
                        <span class="font-medium">{{ $orders->lastItem() }}</span> of
                        <span class="font-medium">{{ $orders->total() }}</span> orders
                    </div>

                    <div class="flex space-x-2">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <span
                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm opacity-50 cursor-not-allowed">
                                Previous
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                Previous
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="btn-primary py-1 px-3 rounded-md text-sm bg-bg-tertiary text-text-white">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                                Next
                            </a>
                        @else
                            <span
                                class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm opacity-50 cursor-not-allowed">
                                Next
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
