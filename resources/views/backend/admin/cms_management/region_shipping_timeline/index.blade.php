@extends('backend.admin.layouts.master', ['page_slug' => 'region_shipping_timeline'])
@section('title', 'Region Shipping Timeline List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Region Shipping Timeline List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'cms.region-shipping-timeline.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['region-shipping-timeline-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'cms.region-shipping-timeline.create',
                            'label' => 'Add New',
                            'permissions' => ['region-shipping-timeline-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Region Name') }}</th>
                                <th>{{ __('Ports') }}</th>
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
    <x-backend.admin.details-modal :datas="['modal_title' => 'Region Shipping Timeline Details']" />
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable
                ['region_id', true, true],
                ['ports', true, true],
                ['created_by', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('cms.region-shipping-timeline.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4],
                model: 'RegionShippingTimeline',
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
            let route = "{{ route('cms.region-shipping-timeline.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: " Region Name",
                    key: "region_name"
                },
                {
                    label: "Ports",
                    key: "ports"
                },
                {
                    label: "Minimum Days",
                    key: "min_days"
                },
                {
                    label: "Maximum Days",
                    key: "max_days"
                },
                {
                    label:'Description',
                    key: "description"
                }
            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
