<!-- Sidebar -->
<div
    class="filterSidebar fixed top-0 left-0 min-h-screen h-full w-2/4 -translate-x-full transition-all duration-300 ease-in-out bg-bg-light dark:bg-bg-darkTertiary shadow-lg z-[99999999999]">

    <div class="h-screen overflow-auto p-5">
        <div class="flex justify-between items-center border-b border-b-border-light pb-5">
            <h4>{{ __("Filter") }}</h4>
            <button class="closeFilterSidebar" title="Close Sidebar">
                <span class="w-10 h-10 flex items-center justify-center bg-bg-secondary rounded-full text-text-white">
                    <i data-lucide="x" class="text-lg"></i>
                </span>
            </button>
        </div>
        <div class="mt-5">
            <div class="text-sm p-4">
                <ul class="opacity-100">
                    <li class="my-3"><a
                            class="text-text-black dark:text-text-white hover:text-text-accent font-font-md"
                            href="#">{{ __("Men's top (20)") }}</a></li>
                    <li class="my-3"><a
                            class="text-text-black dark:text-text-white hover:text-text-accent font-font-md"
                            href="#">{{ __('Men (20)') }}</a></li>
                    <li class="my-3"><a
                            class="text-text-black dark:text-text-white hover:text-text-accent font-font-md"
                            href="#">{{ __('Women (20)') }}</a></li>
                    <li class="my-3"><a
                            class="text-text-black dark:text-text-white hover:text-text-accent font-font-md"
                            href="#">{{ __('Kid (20)') }}</a></li>
                    <li class="my-3"><a
                            class="text-text-black dark:text-text-white hover:text-text-accent font-font-md"
                            href="#">{{ __('T-shirt (20)') }}</a></li>
                </ul>
            </div>
            <div class="divider m-0"></div>
            {{-- Availability --}}
            <details class="collapse collapse-arrow" open>
                <summary class="collapse-title pb-0 font-semibold ">
                    <span>{{ __('Availability') }}</span>
                </summary>
                <div class="collapse-content text-sm">
                    <label for="" class="flex items-center gap-2 py-2">
                        <input type="checkbox" name="availability-checkbox" id="stock-in"
                            class="availability-checkbox checkbox checkbox-sm dark:border-white"> <span
                            class="text-text-black dark:text-text-white">{{ __('In Stock') }}</span>
                    </label>
                    <label for="stock-out" class="flex items-center gap-2">
                        <input type="checkbox" name="availability-checkbox" id="stock-out"
                            class="availability-checkbox checkbox checkbox-sm dark:border-white"> <span
                            class="text-text-black dark:text-text-white">{{ __('Out Of Stock') }}</span>
                    </label>
                </div>
            </details>

            <div class="divider m-0"></div>
            {{-- Price --}}
            <details class="collapse collapse-arrow" open>
                <summary class="collapse-title pb-0 font-semibold">{{ __('Price') }}</summary>
                <div class="collapse-content">
                    <div class="mb-4">
                        <div class="relative w-full price-slider">
                            <div class="absolute w-full h-1 bg-bg-dark bg-opacity-40 z-[1] rounded-full"></div>
                            <div class="absolute h-1 z-[2] rounded-full bg-bg-orange slider-range"></div>
                            <input type="range" min="0" max="500" value="20"
                                class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none min-range">
                            <input type="range" min="0" max="500" value="300"
                                class="absolute p-0 top-1/2 -translate-y-1/2 w-full z-[3] pointer-events-none appearance-none max-range">
                        </div>
                    </div>

                    <!-- Price display -->
                    <div class="pt-8">
                        <p class="text-sm">
                            {{ __("Price:") }} <span class="text-text-danger min-price">{{ __("$20") }}</span> -
                            <span class="text-text-danger max-price">{{ __("$300") }}</span>
                        </p>
                    </div>
                </div>
            </details>


            <div class="divider m-0"></div>

            {{-- Colors --}}
            <details class="collapse collapse-arrow" open>
                <summary class="collapse-title font-semibold ">{{ __("Color") }}</summary>
                <div class="collapse-content text-sm">
                    <div class="flex flex-wrap gap-3">
                        <x-frontend.color-input color="red" />
                        <x-frontend.color-input color="#000" />
                        <x-frontend.color-input color="red" />
                        <x-frontend.color-input color="#000" />
                        <x-frontend.color-input color="red" />
                        <x-frontend.color-input color="#000" />
                        <x-frontend.color-input color="red" />
                        <x-frontend.color-input color="#000" />
                        <x-frontend.color-input color="red" />
                        <x-frontend.color-input color="#000" />
                    </div>
                </div>
            </details>

            <div class="divider m-0"></div>

            {{-- Size --}}
            <details class="collapse collapse-arrow" open>
                <summary class="collapse-title font-semibold ">{{ __("Size") }}</summary>
                <div class="collapse-content text-sm">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
                            $sizes = [
                                [
                                    'size' => 'S',
                                    'stock' => '20',
                                ],
                                [
                                    'size' => 'M',
                                    'stock' => '20',
                                ],
                                [
                                    'size' => 'L',
                                    'stock' => '20',
                                ],
                                [
                                    'size' => 'XL',
                                    'stock' => '20',
                                ],
                                [
                                    'size' => 'XXL',
                                    'stock' => '20',
                                ],
                                [
                                    'size' => 'XXXL',
                                    'stock' => '5',
                                ],
                            ];
                        @endphp

                        @foreach ($sizes as $size)
                            <x-frontend.size :datas="$size" />
                        @endforeach
                    </div>
                </div>
            </details>

            <div class="divider m-0"></div>
            {{-- Brand --}}
            <details class="collapse collapse-arrow" open>
                <summary class="collapse-title font-semibold ">{{ (__("Brand")) }}</summary>
                <div class="collapse-content text-sm">
                    <div class="flex flex-col gap-3">
                        @php
                            $brands = [
                                [
                                    'brand' => 'Apple',
                                    'stock' => '20',
                                ],
                                [
                                    'brand' => 'Samsung',
                                    'stock' => '20',
                                ],
                                [
                                    'brand' => 'One Plus',
                                    'stock' => '20',
                                ],
                            ];
                        @endphp

                        @foreach ($brands as $brand)
                            <x-frontend.brand :datas="$brand" />
                        @endforeach
                    </div>
                </div>
            </details>

        </div>
    </div>
</div>
