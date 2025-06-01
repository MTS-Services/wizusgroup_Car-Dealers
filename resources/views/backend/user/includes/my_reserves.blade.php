<div class="bg-bg-gray dark:bg-opacity-20 p-10 pt-0">
    <div class="max-w-6xl mx-auto">
        <!-- Orders Panel Header -->
        <div class="pb-4">
            <h2 class="text-xl lg:text-2xl font-medium text-text-primary dark:text-text-white">
                {{ __('My Orders') }}</h2>
        </div>

        <!-- Orders Panel -->
        <div class="bg-bg-white dark:bg-bg-dark-tertiary rounded-lg shadow-md overflow-hidden">
            <!-- Filters and Search -->
            <div
                class="p-4 border-b dark:border-b-border-gray dark:border-opacity-50 flex flex-wrap justify-between items-center">
                <div class="flex space-x-2 mb-2 sm:mb-0">
                    <a href="#" class="btn-item bg-bg-tertiary btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                        All Orders
                    </a>
                    <a href="#" class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                        Pending
                    </a>
                    <a href="#" class="btn-item btn-primary py-2 rounded-md hover:bg-bg-tertiary">
                        Completed
                    </a>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Search orders..."
                        class="pl-10 pr-4 py-2 border border-border-gray dark:border-opacity-50 rounded-md focus:outline-none focus:ring-1 focus:ring-bg-tertiary">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-gray">
                        <i class="w-5 h-5" data-lucide="search"></i>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-bg-gray bg-opacity-50 dark:bg-opacity-20 text-left">
                        <tr>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Order ID</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Amount</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-sm font-medium text-text-primary dark:text-text-light uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray dark:divide-opacity-50">
                        <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                #WG-10234</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                Industrial Machinery</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                May
                                15, 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                $12,500.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-800 text-text-white">
                                    Delivered
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="#"
                                    class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                #WG-10233</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                Conveyor System</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                May
                                10, 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                $8,750.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-800 text-text-white">
                                    In Transit
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="#"
                                    class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-bg-gray dark:bg-opacity-20 hover:bg-opacity-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-text-gray dark:text-text-light">
                                #WG-10232</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                Packaging Equipment</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                May
                                5, 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-gray dark:text-text-light">
                                $5,200.00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-bg-tertiary text-text-white">
                                    Processing
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="#"
                                    class="inline-block text-text-secondary hover:text-text-tertiary mr-3">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 border-t dark:border-border-gray dark:border-opacity-50 flex items-center justify-between">
                <div class="text-sm text-text-gray dark:text-text-light">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span
                        class="font-medium">12</span>
                    orders
                </div>
                <div class="flex space-x-2">
                    <a href="#"
                        class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm disabled:opacity-50"
                        disabled>
                        Previous
                    </a>
                    <a href="#" class="btn-primary py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary">
                        1
                    </a>
                    <a href="#"
                        class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                        2
                    </a>
                    <a href="#"
                        class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                        3
                    </a>
                    <a href="#"
                        class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                        4
                    </a>
                    <a href="#"
                        class="btn-primary bg-bg-white text-text-gray border border-border-gray py-1 px-3 rounded-md text-sm hover:bg-bg-tertiary hover:text-text-white">
                        Next
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
