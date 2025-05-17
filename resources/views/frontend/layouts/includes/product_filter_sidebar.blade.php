<!-- Sidebar -->
<div
    class="filterSidebar fixed top-0 left-0 min-h-screen h-full w-4/5 lg:w-1/2 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-tertiary shadow-lg z-[99999999999]">

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
        <div class="space-y-6 shadow-card rounded-lg p-2">
            <!-- Category Filter -->
            <div>
                <div data-target="category-filter">
                    <h3 class="text-base md:text-lg  font-medium">Category</h3>
                </div>

                <div class="filter-content" id="category-filter">
                    <div class="mt-2">
                        <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <option>All Agricultural</option>
                            <option>Tractors</option>
                            <option>Harvesters</option>
                            <option>Plows</option>
                            <option>Seeders</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Brand Filter -->
            <div>
                <div data-target="brand-filter">
                    <h3 class="text-base md:text-lg font-medium">Brand</h3>
                </div>

                <div class="filter-content" id="brand-filter">
                    <div class="mt-2">
                        <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <option>All</option>
                            <option>Kubota</option>
                            <option>Iseki</option>
                            <option>John Deere</option>
                            <option>Mitsubishi</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Model Filter -->
            <div>
                <div data-target="model-filter">
                    <h3 class="text-base md:text-lg font-medium">Model</h3>
                </div>

                <div class="filter-content" id="model-filter">
                    <div class="mt-2">
                        <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
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

            <!-- Year Filter -->
            <div>
                <div data-target="year-filter">
                    <h3 class="text-base md:text-lg font-medium">Year</h3>
                </div>

                <div class="filter-content" id="year-filter">
                    <div class="mt-2">
                        <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <option>All</option>
                            <option>2020 - Present</option>
                            <option>2010 - 2019</option>
                            <option>2000 - 2009</option>
                            <option>1990 - 1999</option>
                            <option>Before 1990</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Price Filter -->
            <div>
                <div data-target="price-filter">
                    <h3 class="text-base md:text-lg font-medium">Price</h3>
                </div>

                <div class="filter-content" id="price-filter">
                    <div class="mt-2">
                        <select class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                            <option>All</option>
                            <option>Under $5,000</option>
                            <option>$5,000 - $10,000</option>
                            <option>$10,000 - $20,000</option>
                            <option>$20,000 - $50,000</option>
                            <option>Over $50,000</option>
                        </select>
                    </div>
                </div>
            </div>

            <button
                class="w-full bg-bg-primary dark:bg-bg-dark text-white py-2 rounded-md transition-colors duration-200 flex items-center justify-center group">
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
