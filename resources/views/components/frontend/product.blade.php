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
                <p class="text-base lg:text-lg xl:text-xl font-bold text-text-danger">
                    ${{ number_format($product->price, 2) }}
                </p>
                <p class="text-text-primary dark:text-text-white mt-2">{{ $product->brand?->name }}</p>
                <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                    <span>{{ $product->year }}</span>
                    @if ($product->model?->name)
                        <span class="mx-2">|</span>
                    @endif
                    <span>{{ $product->model?->name }}</span>
                </div>
                <div class="flex justify-center items-center mt-4">
                    <div
                        class="flex items-center justify-center gap-2 border border-bg-tertiary rounded-md w-full py-2  hover:bg-text-tertiary me-2 text-text-tertiary text-sm hover:text-text-white transition-all duration-300">
                        <span>
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </span>
                        <a href="" class="">{{ __('Buy Now') }}</a>
                    </div>
                    <div
                        class="flex items-center justify-center gap-2 border border-bg-tertiary rounded-md w-full py-2 bg-text-tertiary  hover:bg-transparent ms-2 text-text-white text-sm hover:text-text-primary transition-all duration-300">
                        <span>
                            <i data-lucide="shopping-basket" class="w-4 h-4"></i>
                        </span>
                        <button type="button" class=" add-to-cart-{{ $product->id }}" data-id="{{ $product->id }}">
                            {{ __('Add to Cart') }}
                        </button>
                    </div>
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
