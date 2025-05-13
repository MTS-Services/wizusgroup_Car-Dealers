<div class="product">

    <figure>
        <img src="{{ asset($items['image']) }}" alt="{{ $items['title'] }}" />
    </figure>
    <div class="card-body">
        <a href="{{route('frontend.singel_product')}}" class="product-title">{{ $items['title'] }}</a>
        <div class="product-prices">
            <span class="product-price">${{ $items['price'] }}</span>
            <span class="product-old-price">{{ $items['old_price'] }}</span>
        </div>
    </div>
    <div class="product-actions">
        <a href="#" class="btn-product">
            <span>{{ __('Add to Cart') }}</span>
            <i>
                <i data-lucide="shopping-basket"></i>
            </i>
        </a>
        <a href="#" class="btn-product">
            <span>{{ __('Add to Wishlist') }}</span>
            <i>
                <i data-lucide="heart"></i>
            </i>
        </a>
        <a href="#" class="btn-product">
            <span>{{ __('Quick View') }}</span>
            <i>
                <i data-lucide="eye"></i>
            </i>
        </a>
    </div>
</div>
