@extends('backend.admin.layouts.master', ['page_slug' => "order_{$status}"])
@section('title', 'Order List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Order List') }}</h4>
                    <div class="buttons">
                        {{-- <x-backend.admin.button :datas="[
                            'routeName' => 'gs.container.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['container-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'gs.container.create',
                            'label' => 'Add New',
                            'permissions' => ['container-create'],
                        ]" /> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Order') }}</th>
                                <th>{{ __('Shipping Port') }}</th>
                                <th>{{ __('Destination Port') }}</th>
                                <th>{{ __('Customer') }}</th>
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
    <x-backend.admin.details-modal :datas="['modal_title' => 'Container Details']" />
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                ['order_number', true, true],
                ['shipping_port', true, true],
                ['destination_port', true, true],
                ['user_id', true, true],
                ['status', true, true],
                ['created_by', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('om.order.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5, 6, 7],
                model: 'Order',
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
            let route = "{{ route('gs.container.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: "Title",
                    key: "title"
                },
                {
                    label: "Slug",
                    key: "slug"
                },
                {
                    label: "Shipping Port",
                    key: "shipping_port_name"
                },
                {
                    label: "Destination Port",
                    key: "destination_port_name"
                },
                {
                    label: "Image",
                    key: "modified_image",
                    type: "image"
                },
                {
                    label: "Deadline",
                    key: "deadline"
                },
                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                },
                {
                    label: "Length (m)",
                    key: "length_m"
                },
                {
                    label: "Width (m)",
                    key: "width_m"
                },
                {
                    label: "Height (m)",
                    key: "height_m"
                },
                {
                    label: "Max Weight (kg)",
                    key: "max_weight_kg"
                }


            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
