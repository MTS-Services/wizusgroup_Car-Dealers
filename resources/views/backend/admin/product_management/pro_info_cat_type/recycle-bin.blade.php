{{-- @extends('backend.admin.layouts.master', ['page_slug' => 'product_info_cat_type']) --}}
@section('title', 'Product Information Category Type Recycle Bin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Product Information Category Type Recycle Bin') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product-info-category-type.index',
                            'label' => 'Back',
                            'permissions' => ['product-info-category-type-list'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Product Info Category') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Deleted By') }}</th>
                                <th>{{ __('Deleted Date') }}</th>
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
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable

                ['product_info_cat_id', true,true]
                ['name', true, true],
                ['status', true, true],
                ['deleted_by', true, true],
                ['deleted_at', true, true],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('pm.product-info-category-type.recycle-bin') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3,4],
                model: 'ProductInfoCategoryType',
            };
            // initializeDataTable(details);

            initializeDataTable(details);
        })
    </script>
@endpush
