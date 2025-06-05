<div class="product-card flex flex-col h-full hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
    data-product="1">

    <a href="{{ route('frontend.product.details', $product->slug) }}">
        <div class="h-60 w-full overflow-hidden">
            {{-- transition: transform 0.7s ease; --}}
            <img src="{{ storage_url($product->primaryImage->first()?->image) }}"
                alt="{{ $product->primaryImage->first()?->alt ?? $product->name }}"
                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
        </div>
        <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary flex flex-col flex-1 justify-between">
            <h3
                class="text-base lg:text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                {{ $product->name }}
            </h3>
            <div>
                <div class="flex justify-between items-center">
                    <p class="text-base lg:text-lg xl:text-xl font-bold text-text-danger">
                        ${{ number_format($product->price, 2) }}</p>
                    {{-- quantity --}}
                    <p class="text-sm lg:text-base xl:text-lg text-text-danger font-semibold dark:text-text-white">
                        {{ __('Stock: ') }}<span
                            class="font-normal text-text-wiz_orange">{{ $product->quantity }}</span></p>
                </div>
                <p class="text-text-primary dark:text-text-white mt-2">{{ $product->brand?->name }}</p>
                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                    <span>{{ $product->year }}</span>
                    @if ($product->model?->name)
                        <span class="mx-2">|</span>
                    @endif
                    <span>{{ $product->model?->name }}</span>
                </div>
                <div class="flex justify-center items-center mt-4 gap-y-4 gap-x-2">

                    @foreach ($buttons as $button)
                        <x-frontend.primary-button class="{{ isset($button['class']) ? $button['class'] : '' }}"
                            data_id="{{ $button['data_id'] ?? '' }}" icon="{{ $button['icon'] }}"
                            href="{{ $button['route'] }}" bg="{{ $button['bg'] }}">{{ __($button['label']) }}
                        </x-frontend.primary-button>
                    @endforeach

                </div>
            </div>

        </div>
    </a>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('.add-to-cart-{{ $product->id }}').on('click', function() {
            const productId = $(this).data('id');
            addToCart(productId);
        })

    })
</script>
