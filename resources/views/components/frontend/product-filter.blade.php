@props(['categories', 'subcategories', 'brands', 'models'])
<form action="{{ route('frontend.products.filter', isset($category) ? $category->slug : '') }}" method="POST">
    @csrf
    <div class="shadow-card rounded-lg dark:bg-bg-dark-tertiary">
        <!-- Category Filter -->
        <div class="p-4 pb-0">
            <div data-target="category-filter">
                <h3 class="text-xl font-medium">{{ __('Category') }}</h3>
            </div>

            <div class="filter-content" id="category-filter">
                <div class="mt-2">
                    <select class="select select2" name="subcategory" id="subcategory">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($subcategories as $children)
                            <option value="{{ $children->slug }}"
                                {{ request()->subcategory == $children->slug ? 'selected' : '' }}>
                                {{ $children->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Brand Filter -->
        <div class="p-4 pb-0">
            <div data-target="brand-filter">
                <h3 class="text-xl font-medium">{{ __('Brand') }}</h3>
            </div>

            <div class="filter-content" id="brand-filter">
                <div class="mt-2">
                    <select name="brand" id="brand" class="select select2">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}"
                                {{ request()->brand == $brand->slug ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>

        <!-- Model Filter -->
        <div class="p-4 pb-0">
            <div data-target="model-filter">
                <h3 class="text-xl font-medium">{{ __('Model') }}</h3>
            </div>

            <div class="filter-content" id="model-filter">
                <div class="mt-2">
                    <select name="model" id="model" class="select select2">
                        <option value="">{{ __('All') }}</option>

                        @foreach ($models as $model)
                            <option value="{{ $model->slug }}"
                                {{ request()->model == $model->slug ? 'selected' : '' }}>
                                {{ $model->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
        </div>

        <!-- Year Filter -->
        <div class="p-4 pb-0">
            <div data-target="year-filter">
                <h3 class="text-xl font-medium">{{ __('Year') }}</h3>
            </div>

            <div class="filter-content" id="year-filter">
                <div class="mt-2">
                    <select name="year" id="year" class="select select2">
                        <option value=" ">{{ __('All') }}</option>
                        @for ($i = date('Y'); $i >= 1900; $i--)
                            <option value="{{ $i }}" {{ request()->year == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        {{-- Price Filter --}}
        <details class="collapse collapse-arrow" open>
            <summary class="collapse-title text-xl font-medium">{{ __('Price') }}</summary>
            <div class="collapse-content">
                <div class="mb-3">
                    <div class="relative w-full price-slider">
                        <div class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full">
                        </div>
                        <div class="absolute h-1 z-[2] rounded-full bg-bg-primary slider-range"></div>
                        <input type="range" name="start_price" min="0" max="500000"
                            value="{{ request()->start_price ?? 20 }}"
                            class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                        <input type="range" min="0" name="end_price" max="500000"
                            value="{{ request()->end_price ?? 500000 }}"
                            class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                    </div>
                </div>

                <!-- Price display -->
                <div class="pt-8">
                    <p class="text-sm lg:text-base">
                        {{ __('Price:') }} <span
                            class="text-text-danger min-price">${{ request()->start_price ?? 20 }}</span>
                        -
                        <span class="text-text-danger max-price">${{ request()->end_price ?? 50000 }}</span>
                    </p>
                </div>
            </div>
        </details>

        <button type="submit"
            class="w-full btn-primary hover:bg-bg-tertiary py-2 rounded-md transition-all duration-200 flex items-center justify-center group">
            <span>{{ __('Sherch') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </div>
</form>
