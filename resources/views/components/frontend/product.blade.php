<div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
    data-product="1">
    <div class="h-60 w-full  overflow-hidden">
        {{-- transition: transform 0.7s ease; --}}
        <img src="{{ storage_url($product->primaryImage->first()?->image) }}"
            alt="{{ $product->primaryImage->first()?->alt ?? $product->name }}"
            class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
    </div>
    <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary flex flex-col justify-between min-h-52">
        <div>
            <h3
                class="text-base lg:text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                {{ $product->name }}</h3>
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
        </div>
        <div class="flex justify-center items-center mt-4">
            <a href="{{ route('frontend.product.details', $product->slug) }}"
                class="btn-primary rounded-md w-full hover:bg-bg-tertiary me-2">{{ __('View Details') }}</a>
            <button type="button"
                class="btn-primary rounded-md w-full bg-bg-tertiary hover:bg-text-secondary ms-2 add-to-cart-{{ $product->id }}"
                data-id="{{ $product->id }}">
                {{ __('Add to Cart') }}
            </button>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('.add-to-cart-{{ $product->id }}').on('click', function() {
            const productId = $(this).data('id');

            axios.post('{{ route('frontend.cart.add') }}', {
                product_id: productId
            }).then(response => {
                $('.cartSidebar').css('transform', 'translateX(0)');
                console.log(response.data);

                const { status, message, cart_item, cart_total } = response.data;

                // Ensure updateCartSidebar function is globally available or included in a shared script
                if (typeof updateCartTotalDisplay === 'function') {
                    updateCartTotalDisplay(cart_total);
                } else {
                    console.error("updateCartTotalDisplay function is not defined.");
                }

                if (status === 'success') {
                    // Append new item to sidebar
                    if (typeof appendCartItemHtml === 'function') {
                        appendCartItemHtml(cart_item);
                    } else {
                        console.error("appendCartItemHtml function is not defined.");
                    }
                } else if (status === 'info') {
                    // If item was already in cart, you might want to show a message
                    // or highlight the existing item if it's visible in the sidebar.
                    // For now, we just update the total (which is already done).
                    console.warn(message);
                }

            }).catch(error => {
                console.error('Error adding product to cart:', error);
                // Handle error (e.g., show a user-friendly message)
            })
        })

    })
</script>
