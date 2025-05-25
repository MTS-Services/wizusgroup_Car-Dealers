@extends('backend.admin.layouts.master', ['page_slug' => 'product_attribute_value'])
@section('title', 'Product Attribute Value List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Product Attribute Value List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product-attr-value.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['product-attribute-value-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product-attr-value.create',
                            'label' => 'Add New',
                            'permissions' => ['product_attribute_value-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Attribute Name') }}</th>
                                <th>{{ __('Value') }}</th>
                                <th>{{ __('Status') }}</th>
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
    {{-- Details Modal  --}}
    <x-backend.admin.details-modal :datas="['modal_title' => 'Product Attribute Value Details']" />
@endsection
@push('js')
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable
                ['product_attribute_id', true, true],
                ['value', true, true],
                ['status', true, true],
                ['creater_id', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('pm.product-attr-value.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5],
                model: 'ProductAttributeValue',
            };
            initializeDataTable(details);
        })
    </script>
@endpush
@push('js')
    {{-- Show details scripts --}}
    <script src="{{ asset('modal/details_modal.js') }}"></script>
    <script>
        // Event listener for viewing details
        $(document).on("click", ".view", function() {
            let id = $(this).data("id");
            let route = "{{ route('pm.product-attr-value.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [
            {
                label: "Product Name",
                key: "product_name",
            },    
            {
                    label: "Attibute Name",
                    key: "attribute_name",

                },
                {
                    label: "Value",
                    key: "value",

                },

                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                }

            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
