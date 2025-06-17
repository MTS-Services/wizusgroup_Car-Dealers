<div class="search-container relative z-50">
    <button class="hover:text-text-secondary transition-all duration-300 ease-linear mt-1.5" type="button"
        aria-label="Open search" title="Search products">
        <i data-lucide="search" class="w-6 h-6"></i>
    </button>

    <dialog class="modal" id="search-modal">
        <div class="modal-box bg-base-100 border border-base-300 shadow-2xl max-w-4xl h-full max-h-[77vh] p-0 overflow-hidden">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-6 top-6 z-10">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </form>

            <div class="bg-base-200 p-6 border-b border-base-300">
                <h3 class="text-2xl font-bold mb-2">{{ __('Search Products') }}</h3>
                <p class="text-base-content/70 text-sm">
                    {{ __('Find products and categories instantly') }}
                </p>
            </div>

            <div class="p-6">
                <form id="search-form" class="mb-6">
                    <div class="join w-full">
                        <div class="input join-item w-2/3">
                            <i data-lucide="search" class="w-5 h-5"></i>

                            <input type="search" name="q" placeholder="Search for products..."
                                class="search-input" autocomplete="off" aria-label="Search products" />
                        </div>

                        <select name="category" class="select category-select join-item w-1/3">
                            <option value="all" selected>All Categories</option>
                            @foreach (App\Models\Category::with('childrens')->where('parent_id', null)->get() as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="overflow-y-auto max-h-[50vh] custom-scrollbar search-suggestions">

                    <div class="text-center py-12">

                        <div class="mb-6 mx-auto w-16 h-16 text-base-content/30">
                            <i data-lucide="search" class="w-full h-full"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">
                            {{ __('Start Your Search') }}
                        </h3>
                        <p class="text-base-content/70">
                            {{ __('Type in the search box above to find products') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>{{ __('close') }}</button>
        </form>
    </dialog>
</div>

<style>
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(var(--base-content-rgb), 0.05);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: hsl(var(--p));
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: hsl(var(--pf));
    }

    /* Animations */
    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .loading-skeleton {
        background: linear-gradient(90deg, rgba(var(--base-content-rgb), 0.1) 25%,
                rgba(var(--base-content-rgb), 0.2) 50%,
                rgba(var(--base-content-rgb), 0.1) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
</style>

@include('frontend.includes.search-js')
