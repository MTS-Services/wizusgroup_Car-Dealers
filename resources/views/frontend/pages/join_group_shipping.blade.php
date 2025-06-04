@extends('frontend.layouts.app')

@section('content')
    {{-- Details Section --}}
    <section class="py-6 sm:py-8 lg:py-12 bg-bg-light dark:bg-bg-dark-tertiary/50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-12 gap-6">
                {{-- Container Details --}}
                <div
                    class="{{ isset($product) ? 'col-span-9' : 'col-span-12' }}  bg-bg-white dark:bg-bg-dark-tertiary  shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg">
                    <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                        <div class="flex justify-between items-baseline">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                {{ $container->title ?? __('Untitled') }}
                            </h3>
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('From') }}</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container?->shippingPort?->name ?? __('N/A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Destination') }}</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container?->destinationPort?->name ?? __('N/A') }}
                                </p>
                            </div>
                            <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-base font-medium">
                                {{ $container->status_label ?? __('Active') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 text-sm text-text-primary dark:text-text-light">
                        <div class="flex items-center mb-4">
                            <i class="far fa-calendar-alt text-text-primary dark:text-text-light mr-2 text-sm"></i>
                            <span class="font-medium text-base">{{ __('Deadline:') }}
                                {{ dateFormat($container->deadline) }}</span>
                        </div>
                        <div class="grid grid-cols-5 gap-4">
                            <div class="col-span-2 h-fit">
                                <img class="w-full max-h-80 h-full object-cover" src="{{ storage_url($container->image) }}"
                                    alt="{{ $container->title ?? 'Untitled' }}">
                            </div>
                            <div class="col-span-3">
                                <div class=" grid grid-cols-2 gap-4 h-fit">
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Length') }}</p>
                                        <p class="text-base font-bold">{{ $container->length_m }} cm</p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Width') }}</p>
                                        <p class="text-base font-bold">{{ $container->width_m }} cm</p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Height') }}</p>
                                        <p class="text-base font-bold">{{ $container->height_m }} cm</p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Max Weight') }}</p>
                                        <p class="text-base font-bold">{{ $container->max_weight_kg }} kg</p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Base Cost') }}</p>
                                        <p class="text-base font-bold">{{ '$' . number_format($container->base_cost, 2) }}
                                        </p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Per Kilogram Cost') }}</p>
                                        <p class="text-base font-bold">
                                            {{ '$' . number_format($container->per_kg_cost, 2) }}
                                        </p>
                                    </div>
                                    <div
                                        class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                        <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                            {{ __('Per Cubic Meter Cost') }}</p>
                                        <p class="text-base font-bold">
                                            {{ '$' . number_format($container->per_cbm_cost, 2) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-medium text-base">{{ __('Capacity') }}</span>
                                        <span>{{ $container->getFilledPercentageAttribute() }}% {{ __('filled') }}</span>
                                    </div>
                                    <div class="w-full bg-bg-gray rounded-full h-2.5">
                                        <div class="bg-bg-wiz_orange h-2.5 rounded-full text-base"
                                            style="width: {{ $container->getFilledPercentageAttribute() }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- Product Details --}}
                @if (isset($product))
                    <div class="col-span-3">
                        <div
                            class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg h-full">
                            <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                                <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                    {{ __('Product Details') }}
                                </h3>
                            </div>

                            <div class="p-5">
                                <div class="flex flex-col gap-6">
                                    <div class="w-full  h-64 lg:h-auto overflow-hidden rounded-lg shadow-md">
                                        <img src="{{ isset($product) ? storage_url($product?->primaryImage->first()?->image) : '' }}"
                                            alt="{{ isset($product) ? $product?->name : '' }}"
                                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                    </div>
                                    <div class="w-full ">
                                        <h3 class="text-xl font-bold text-text-primary dark:text-white mb-4">
                                            {{ $product->name }}
                                        </h3>

                                        <div class="space-y-4">
                                            <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                        {{ __('Price') }}</p>
                                                    <p class="text-base font-bold">${{ $container_product->price }}</p>
                                                </div>
                                            </div>

                                            <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                        {{ __('Reserve Price') }}</p>
                                                    <p class="text-base font-bold">${{ $container_product->reserve_price }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </section>

    {{-- Form Section --}}
    <section class="py-6 sm:py-8 lg:py-12">
        <div class="container">
            @if ($container->getFilledPercentageAttribute() >= 100)
                <div class="bg-bg-white dark:bg-bg-dark-tertiary overflow-hidden rounded-lg">
                    <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                        <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                            {{ __('The selected container has reached its capacity for this product.') }}
                        </h3>
                    </div>
                </div>
            @else
                <div class="bg-bg-white dark:bg-bg-dark-tertiary overflow-hidden rounded-lg">
                    <form
                        action="{{ route('frontend.group-shipping.join-request', ['container_slug' => $container->slug]) }}"
                        method="post" class="space-y-5 p-5">
                        @csrf
                        <div class="grid grid-cols-3 tablet:grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="email"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Email') }} <span class="text-red-500">*</span> </label>
                                <input type="text" id="email" name="email"
                                    placeholder="{{ __('Enter your email') }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                            </div>
                            <div class="form-group">
                                <label for="whatsapp"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Whatsapp') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="whatsapp" name="whatsapp"
                                    placeholder="{{ __('Enter your whatsapp') }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'whatsapp']" />
                            </div>
                            <div class="form-group">
                                <label for="product_id"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Product') }}</label>
                                <select name="product_id" id="product_id" {{ isset($product) ? 'disabled' : '' }}
                                    class="select w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                    <option value="" selected>{{ __('Select a product') }}</option>
                                    @foreach ($products as $product1)
                                        <option value="{{ $product1->id }}"
                                            {{ old('product_id') == $product1->id ? 'selected' : '' }}>
                                            {{ $product1->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'email']" />
                            </div>
                            <div class="form-group">
                                <label for="product_name"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Product Name') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="product_name" name="product_name"
                                    value="{{ isset($product) ? $product?->name : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'product_name']" />
                            </div>
                            <div class="form-group">
                                <label for="height_m"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Height (m)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="height_m" name="height_m"
                                    value="{{ isset($product) ? $product?->height_m : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'height_m']" />
                            </div>
                            <div class="form-group">
                                <label for="width_m"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Width (m)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="width_m" name="width_m"
                                    value="{{ isset($product) ? $product?->width_m : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'width_m']" />
                            </div>
                            <div class="form-group">
                                <label for="length_m"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Length (m)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="length_m" name="length_m"
                                    value="{{ isset($product) ? $product?->length_m : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'length_m']" />
                            </div>
                            <div class="form-group">
                                <label for="weight_kg"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Weight (kg)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="weight_kg" name="weight_kg"
                                    value="{{ isset($product) ? $product?->weight_kg : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'weight_kg']" />
                            </div>
                            <div class="form-group">
                                <label for="quantity"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Quantity') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="quantity" name="quantity"
                                    value="{{ isset($product) ? 1 : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'quantity']" />
                            </div>
                            <div class="form-group">
                                <label for="price"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Price (USD)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="price" name="price"
                                    value="{{ isset($container_product) ? $container_product?->price : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'price']" />
                            </div>

                            <div class="form-group">
                                <label for="reserve_price"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Reserve Price (USD)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="reserve_price" name="reserve_price"
                                    value="{{ isset($container_product) ? $container_product?->reserve_price : '' }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'reserve_price']" />
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="note"
                                class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                {{ __('Note (optional)') }}
                            </label>
                            <textarea id="note" name="note" rows="4" placeholder="{{ __('Enter your note') }}"
                                class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"></textarea>
                            <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'note']" />
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="btn-primary !bg-bg-wiz_orange float-end">
                                {{ __('Submit Join Request') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {

            function getPrice(cbm, weight_kg) {
                let base_cost = `{{ $container->base_cost }}`;
                let per_cbm_cost = `{{ $container->per_cbm_cost }}`;
                let per_kg_cost = `{{ $container->per_kg_cost }}`;
                let price = base_cost + (cbm * per_cbm_cost);
                // let price = base_cost + (cbm * per_cbm_cost) + (weight_kg * per_kg_cost);
                $('#price').val(numberFormat(price, 2, false));
                $('#reserve_price').val(numberFormat((price / 2), 2, false));

            }

            $('#quantity').on('input', function() {

                let cbm = $('#height_m').val() * $('#width_m').val() * $('#length_m').val();
                let weight_kg = $('#weight_kg').val();
                getPrice(cbm, weight_kg);

                if ($('#quantity').val() < 1) {
                    $('#price').val(0);
                    $('#reserve_price').val(0);
                } else {
                    $('#price').val(numberFormat($('#price').val() * $(this).val(), 2, false));
                    $('#reserve_price').val(numberFormat($('#reserve_price').val() * $(this).val(), 2,
                        false));
                }

            });

            $('#product_id').on('change', async function() {
                let route = "{{ route('axios.get-product') }}";
                let product = await getProduct($(this).val(), route);
                if (product == null) {
                    $('#product_name').val('');
                    $('#height_m').val('');
                    $('#width_m').val('');
                    $('#length_m').val('');
                    $('#weight_kg').val('');
                    return;
                } else {
                    $('#product_name').val(product.name);
                    $('#height_m').val(product.height_m);
                    $('#width_m').val(product.width_m);
                    $('#length_m').val(product.length_m);
                    $('#weight_kg').val(product.weight_kg);
                    $('#quantity').val(1);
                    let cbm = product.height_m * product.width_m * product.length_m;
                    let weight_kg = product.weight_kg;
                    getPrice(cbm, weight_kg);
                }

                console.log(product); // Now logs the actual product
            });

        });
    </script>
@endpush
