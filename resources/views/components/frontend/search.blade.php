<div class="relative search-container">
    <button class="text-2xl toggle-search-btn " type="button">
        <i data-lucide="search"
            class="relative top-1 text-text-primary dark:text-text-white hover:text-text-accent dark:hover:text-text-accent transition-all duration-300 ease-linear"></i>
    </button>
    <form action="{{ route('frontend.home') }}"
        class="searchForm absolute top-1/2 right-[110%] transform -translate-y-1/2 transition-all duration-300 ease-in-out scale-95 opacity-0 pointer-events-none max-w-[500px] min-w-64 lg:min-w-96 z-50">
        <div class="join w-full">
            <div class="w-full">
                <label class="input input-search">
                    <svg class="h-[1em] opacity-50 stroke-current" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </g>
                    </svg>
                    <input type="search" required placeholder="Search" />
                </label>
            </div>
            <button class="btn-search join-item" type="submit">{{ __('Search') }}</button>
        </div>
    </form>
</div>
