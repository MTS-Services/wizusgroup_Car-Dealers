@extends('backend.admin.layouts.master', ['page_slug' => 'tax_rate'])
@section('title', 'Tax Rate List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Tax Rate List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.tax-rate.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['tax-rate-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.tax-rate.create',
                            'label' => 'Add New',
                            'permissions' => ['tax-rate-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Tax Class') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('Tax Rate') }}</th>
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
    <x-backend.admin.details-modal :datas="['modal_title' => 'tax-rate Details']" />
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [

                ['tax_class_id', true, true],
                ['name', true, true],
                ['country_id', true, true],
                ['city_id', true, true],
                ['rate', true, true],
                ['status', true, true],
                ['created_by', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('pm.tax-rate.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                model: 'TaxRate',
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
            let route = "{{ route('pm.tax-rate.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: "Name",
                    key: "name"
                },

                {
                    label: "Tax Class",
                    key: "tax_class_id"
                },
                {
                    label: "Tax Rate",
                    key: "rate"
                },
                {
                    label: "Country",
                    key: "country_id"
                },
                {
                    label: "State",
                    key: "state"
                },
                {
                    label: "City",
                    key: "city_id"
                },
                {
                    label: "Priority",
                    key: "priority",
                    color: "priority_color",
                },

                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                },
                {
                    label: "Compound",
                    key: "compound_label",
                    color: "compound_color",
                },



            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
