@extends('backend.admin.layouts.master', ['page_slug' => 'product', 'product_type' => $product_type ?? ''])
@section('title', 'Product List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">
                        {{ $product_type == App\Models\Product::PRODUCT_TYPE_PARTS ? 'Parts & Accessories List' : ($product_type == App\Models\Product::PRODUCT_TYPE_DROPSHIPPING ? 'Dropshipping Product List' : ($product_type == 'out-of-stock' ? 'Out of Stock Product List' : 'Product List')) }}
                    </h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product.recycle-bin',
                            'params' => ['product_type' => $product_type],
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['product-restore'],
                        ]" />
                        @if ($product_type != 'out-of-stock')
                            <x-backend.admin.button :datas="[
                                'routeName' => 'pm.product.create',
                                'params' => ['product_type' => $product_type],
                                'label' => 'Add New',
                                'permissions' => ['product-create'],
                            ]" />
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Cost Price') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Featured') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable
                ['name', true, true],
                ['price', true, true],
                ['cost_price', true, true],
                ['status', true, true],
                ['is_featured', true, true],
                ['created_by', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('pm.product.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5, 6, 7],
                model: 'Product',
            };
            initializeDataTable(details);
        })
    </script>
@endpush
