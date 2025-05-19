@extends('backend.admin.layouts.master', ['page_slug' => 'product_info_cat'])
@section('title', 'Product Info Category List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Product Info Category List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product-info-category.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['product-info-category-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.product-info-category.create',
                            'label' => 'Add New',
                            'permissions' => ['product-info-category-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
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
    {{-- Admin Details Modal  --}}
    <x-backend.admin.details-modal :datas="['modal_title' => 'Company Details']" />
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [

                ['name', true, true],
                ['status', true, true],
                ['created_by', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('pm.product-info-category.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5],
                model: 'ProductInfoCategory',
            };
            initializeDataTable(details);
        })
    </script>
@endpush
@push('js')
    {{-- Show details scripts --}}
    <script src="{{ asset('modal/details_modal.js') }}"></script>
    <script>
        $(document).on("click", ".view", function() {
            let id = $(this).data("id");
            let route = "{{ route('pm.product-info-category.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: "Name",
                    key: "name"
                },
                {
                    label: "Slug",
                    key: "slug"
                },
                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                },
            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
