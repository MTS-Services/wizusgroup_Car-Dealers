<!-- Sidebar -->
<div
    class="filterSidebar fixed top-0 left-0 min-h-screen h-full w-4/5 lg:w-1/2 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto p-2 xl:p-3">
        <div class="flex justify-between items-center border-b border-b-border-light pb-5">
            <h4>{{ __('Filter') }}</h4>
            <button class="closeFilterSidebar" title="Close Sidebar">
                <span class="w-10 h-10 flex items-center justify-center bg-bg-primary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>
        {{-- Sidebar Filter --}}
        {{-- Sidebar Filter --}}
        <div class="space-y-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary">
            <h2
                class="text-lg md:text-xl font-semibold capitalize border-b bg-bg-light border-border-gray dark:border-opacity-50 p-4">
                Auction fillters</h2>
            <div class="px-4">
                <div data-target="category-filter">
                    <h3 class="text-sm md:text-base font-medium">Category</h3>
                </div>

                <div class="filter-content" id="category-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>All Agricultural</option>
                            <option>Tractors</option>
                            <option>Harvesters</option>
                            <option>Plows</option>
                            <option>Seeders</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div data-target="brand-filter">
                    <h3 class="text-sm md:text-base font-medium">Make</h3>
                </div>

                <div class="filter-content" id="brand-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>All</option>
                            <option>Kubota</option>
                            <option>Iseki</option>
                            <option>John Deere</option>
                            <option>Mitsubishi</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div data-target="model-filter">
                    <h3 class="text-sm md:text-base font-medium">End Time</h3>
                </div>

                <div class="filter-content" id="model-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>All</option>
                            <option>ZL1-215</option>
                            <option>TM15</option>
                            <option>GL-29</option>
                            <option>1070</option>
                            <option>MT200</option>
                            <option>TU1500F</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-4">
                <button
                    class="w-full bg-bg-primary text-white py-2 rounded-md transition-colors duration-200 flex items-center justify-center group">
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
