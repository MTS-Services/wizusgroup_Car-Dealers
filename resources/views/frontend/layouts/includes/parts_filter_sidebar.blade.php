<!-- Sidebar -->
<div
    class="partsFilterSidebar fixed top-0 left-0 min-h-screen h-full w-4/5 lg:w-1/2 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-dark-tertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto p-2 xl:p-3">
        <div class="flex justify-between items-center border-b border-b-border-dark border-opacity-20 dark:border-border-gray dark:border-opacity-50 pb-5">
            <h4>{{ __('Parts & Accessories Fillters') }}</h4>
            <button class="closePartsFilterSidebar" title="Close Sidebar">
                <span
                    class="w-10 h-10 flex items-center justify-center bg-bg-primary hover:bg-bg-tertiary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>
        {{-- Sidebar Filter --}}
        <div class="space-y-6 shadow-card rounded-lg dark:bg-bg-dark-tertiary m-4 mt-6">
            <div class="px-4 pt-4">
                <div data-target="category-filter">
                    <h3 class="text-sm md:text-base font-medium pb-2">{{ __('Category') }}</h3>
                </div>

                <div class="filter-content" id="category-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>{{ __('All Agricultural') }}</option>
                            <option>{{ __('Tractors') }}</option>
                            <option>{{ __('Harvesters') }}</option>
                            <option>{{ __('Plows') }}</option>
                            <option>{{ __('Seeders') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <div data-target="brand-filter">
                    <h3 class="text-sm md:text-base font-medium pb-2">{{ __('Make') }}</h3>
                </div>

                <div class="filter-content" id="brand-filter">
                    <div class="mt-2">
                        <select class="w-full border border-border-gray dark:border-opacity-50 rounded-md px-3 py-2">
                            <option>{{ __('All') }}</option>
                            <option>{{ __('Kubota') }}</option>
                            <option>{{ __('Iseki') }}</option>
                            <option>{{ __('John Deere') }}</option>
                            <option>{{ __('Mitsubishi') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                {{-- Price Filter --}}
                <details class="collapse collapse-arrow" open>
                    <summary class="collapse-title text-base font-medium">{{ __('Price') }}</summary>
                    <div class="collapse-content">
                        <div class="mb-3">
                            <div class="relative w-full price-slider">
                                <div class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full">
                                </div>
                                <div class="absolute h-1 z-[2] rounded-full bg-bg-primary slider-range"></div>
                                <input type="range" min="0" max="500" value="20"
                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                                <input type="range" min="0" max="500" value="300"
                                    class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                            </div>
                        </div>
                        <!-- Price display -->
                        <div class="pt-8">
                            <p class="text-sm lg:text-base">
                                {{ __('Price:') }} <span
                                    class="text-text-danger min-price">{{ __("$20") }}</span> -
                                <span class="text-text-danger max-price">{{ __("$300") }}</span>
                            </p>
                        </div>
                    </div>
                </details>
            </div>
            <div class="px-4 pb-4">
                <button
                    class="w-full bg-bg-primary hover:bg-bg-tertiary text-white py-2 rounded-md transition-colors duration-200 flex items-center justify-center group">
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
