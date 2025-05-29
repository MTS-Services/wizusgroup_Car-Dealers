@extends('frontend.layouts.app')

@section('content')
    @php
        $container_quantity = $container_product->quantity;
        $reserve_quantity = (int) $container
            ->containerReservations()
            ->where('product_id', $container_product->product_id)
            ->where('status', '!=', App\Models\ContainerReservation::STATUS_DECLINE)
            ->sum('quantity');
    @endphp
    {{-- Details Section --}}
    <section class="py-6 sm:py-8 lg:py-12 bg-bg-light dark:bg-bg-dark-tertiary/50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Container Details --}}
                <div
                    class="lg:col-span-6  bg-bg-white dark:bg-bg-dark-tertiary  shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg">
                    <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                {{ $container->title ?? __('Untitled') }}
                            </h3>
                            <span class="px-2.5 py-1 bg-bg-wiz_green text-white rounded-full text-base font-medium">
                                {{ $container->status_label ?? __('Active') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mt-3">
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('From') }}</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container->shippingPort?->name ?? __('N/A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Destination') }}</p>
                                <p class="text-sm text-text-primary dark:text-text-light">
                                    {{ $container->destinationPort?->name ?? __('N/A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 text-sm text-text-primary dark:text-text-light">
                        <div class="flex items-center mb-4">
                            <i class="far fa-calendar-alt text-text-primary dark:text-text-light mr-2 text-sm"></i>
                            <span class="font-medium text-base">{{ __('Deadline:') }}
                                {{ dateFormat($container->deadline) }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Length') }}</p>
                                <p class="text-base font-bold">{{ $container->length_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Width') }}</p>
                                <p class="text-base font-bold">{{ $container->width_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Height') }}</p>
                                <p class="text-base font-bold">{{ $container->height_cm }} cm</p>
                            </div>
                            <div
                                class="bg-bg-gray dark:bg-bg-dark-secondary p-3 rounded-lg flex justify-between items-center py-4">
                                <p class="text-base text-text-primary dark:text-text-light uppercase font-medium">
                                    {{ __('Max Weight') }}</p>
                                <p class="text-base font-bold">{{ $container->max_weight_kg }} kg</p>
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

                {{-- Product Details --}}
                <div class="lg:col-span-6">
                    <div
                        class="bg-bg-white dark:bg-bg-dark-tertiary shadow-card dark:shadow-dark-card overflow-hidden border border-border-gray dark:border-border-dark-secondary rounded-lg h-full">
                        <div class="p-5 border-b border-border-gray dark:border-border-dark-secondary">
                            <h3 class="text-lg font-semibold text-text-primary dark:text-text-light">
                                {{ __('Product Details') }}
                            </h3>
                        </div>

                        <div class="p-5">
                            <div class="flex flex-col lg:flex-row gap-6">
                                {{-- Product Image --}}
                                <div class="w-full lg:w-1/2 h-64 lg:h-auto overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ storage_url($container_product->product?->primaryImage->first()?->image) }}"
                                        alt="{{ $container_product->product?->name }}"
                                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                </div>

                                {{-- Product Details --}}
                                <div class="w-full lg:w-1/2">
                                    <h3 class="text-xl font-bold text-text-primary dark:text-white mb-4">
                                        {{ $container_product?->product->name }}
                                    </h3>

                                    <div class="space-y-4">
                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    {{ __('Quantity') }}</p>
                                                <p class="text-base font-bold">
                                                    {{ $container_quantity }}/{{ $reserve_quantity }}
                                                </p>
                                            </div>
                                        </div>

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
                                                <p class="text-base font-bold">${{ $container_product->reserve_price }}</p>
                                            </div>
                                        </div>

                                        <div class="w-full bg-bg-gray dark:bg-bg-dark-secondary p-4 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <p class="text-base font-medium text-text-primary dark:text-text-light">
                                                    {{ __('Status') }}</p>
                                                <p class="text-base font-bold">
                                                    {{ $container_product?->product->status_label ?? __('Available') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Form Section --}}
    <section class="py-6 sm:py-8 lg:py-12">
        <div class="container">
            @if ($reserve_quantity >= $container_quantity)
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
                        action="{{ route('frontend.group-shipping.join-request', ['container_slug' => $container->slug, 'product_slug' => $container_product->product?->slug]) }}"
                        method="post" class="space-y-5 p-5">
                        @csrf
                        <div class="grid grid-cols-2 tablet:grid-cols-3 gap-4">
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
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group">
                                <label for="quantity"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Quantity') }}<span class="text-red-500">*</span>
                                </label>
                                <select name="quantity" id="quantity"
                                    class="w-full select px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                    @for ($i = 1; $i <= $container_product->quantity - $reserve_quantity; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'quantity']" />
                            </div>

                            <div class="form-group">
                                <label for="price"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Price (USD)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="price" name="price"
                                    value="{{ $container_product->price }}"
                                    class="w-full px-4 py-2.5 text-sm text-text-primary dark:text-text-light border border-border-gray dark:border-border-dark-secondary rounded-lg shadow-card dark:shadow-dark-card focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                                <x-frontend.input-error :datas="['errors' => $errors, 'field' => 'price']" />
                            </div>
                            <div class="form-group">
                                <label for="reserve_price"
                                    class="block text-sm font-medium text-text-primary dark:text-text-light mb-1.5">
                                    {{ __('Reserve Price (USD)') }}<span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="reserve_price" name="reserve_price"
                                    value="{{ $container_product->reserve_price }}"
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
            $('#quantity').on('change', function() {
                var quantity = $(this).val();
                var price = $('#price').val();
                var reserve_price = $('#reserve_price').val();
                var total = quantity * @json($container_product->price);
                var reserve_total = quantity * @json($container_product->reserve_price);
                $('#price').val(numberFormat(total, 2, false));
                $('#reserve_price').val(numberFormat(reserve_total, 2, false));
            });
        })
    </script>
@endpush
