<!-- Sidebar -->
<div
    class="auctionfilterSidebar fixed top-0 left-0 min-h-screen h-full w-4/5 lg:w-1/2 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-tertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto p-3 xl:p-3">
        <div class="flex justify-between items-center border-b border-b-border-gray dark:border-opacity-20 pb-5">
            <h4>{{ __('Auction fillters') }}</h4>
            <button class="closeAuctionFilterSidebar" title="Close Sidebar">
                <span class="w-10 h-10 flex items-center justify-center bg-bg-primary hover:bg-bg-tertiary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>
        {{-- Sidebar Filter --}}
        <div class="space-y-6 dark:border dark:border-border-gray dark:border-opacity-20 shadow-card rounded-lg dark:bg-bg-dark-tertiary mt-4 mx-2">
            <div class="px-4 pt-4">
                <div data-target="category-filter">
                    <h3 class="text-sm md:text-base font-medium mb-2">{{ __("Category") }}</h3>
                </div>

                <div class="filter-content" id="category-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>{{ __("All Agricultural") }}</option>
                            <option>{{ __("Tractors") }}</option>
                            <option>{{ __("Harvesters") }}</option>
                            <option>{{ __("Plows") }}</option>
                            <option>{{ __("Seeders") }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div data-target="brand-filter">
                    <h3 class="text-sm md:text-base font-medium mb-2">{{ __("Make") }}</h3>
                </div>

                <div class="filter-content" id="brand-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>{{ __("All") }}</option>
                            <option>{{ __("Kubota") }}</option>
                            <option>{{ __("Iseki") }}</option>
                            <option>{{ __("John Deere") }}</option>
                            <option>{{ __("Mitsubishi") }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div data-target="model-filter">
                    <h3 class="text-sm md:text-base font-medium mb-2">{{ __("End Time") }}</h3>
                </div>

                <div class="filter-content" id="model-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>{{ __("All") }}</option>
                            <option>{{ __("ZL1-215") }}</option>
                            <option>{{ __("TM15") }}</option>
                            <option>{{ __("GL-29") }}</option>
                            <option>{{ __("1070") }}</option>
                            <option>{{ __("MT200") }}</option>
                            <option>{{ __("TU1500F") }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-4">
                <button
                    class="w-full btn-primary hover:bg-bg-tertiary py-2 rounded-md transition-all duration-300 flex items-center justify-center group">
                    <span>Sherch</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
