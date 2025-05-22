<div class="product-card hover:translate-y-[-8px] hover:shadow-lg transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden cursor-pointer"
    data-product="1">
    <a href="{{ route('frontend.product.details', $product->slug) }}">
        <div class="max-h-80 w-full  overflow-hidden">
            {{-- transition: transform 0.7s ease; --}}
            <img src="{{storage_url($product->primaryImage->first()?->image)}}" alt="{{$product->primaryImage->first()?->alt ?? $product->name}}"
                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110">
        </div>
        <div class="p-4 bg-bg-light dark:bg-bg-dark-tertiary">
            <h3
                class="text-base lg:text-lg font-semibold hover:text-text-tertiary text-text-primary dark:text-text-white transition-colors duration-200">
                {{$product->model?->name}}</h3>
            <p class="text-base lg:text-lg xl:text-xl font-bold text-text-danger">${{ number_format($product->price,2) }}</p>
            <div class="flex items-center text-text-primary dark:text-text-white mt-2 text-sm">
                <span>{{$product->year}}</span>
                <span class="mx-2">|</span>
                <span>{{$product->brand?->name}}</span>
            </div>
        </div>
    </a>
</div>
