@extends('backend.admin.layouts.master', ['page_slug' => 'auction'])
@section('title', 'Auction List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Auction List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'auction-m.auction.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['auction-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'auction-m.auction.create',
                            'label' => 'Add New',
                            'permissions' => ['auction-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Title') }}</th>
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
    {{-- Admin Details Modal  --}}
    <x-backend.admin.details-modal :datas="['modal_title' => 'Auction Details']" />
@endsection
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [

                ['title', true, true],
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
                main_route: "{{ route('auction-m.auction.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5],
                model: 'Auction',
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
            let route = "{{ route('auction-m.auction.show', ['id']) }}";
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
                    label: "Product",
                    key: "product_name"
                },
                {
                    label: "Start Date",
                    key: "start_date_format"
                },
                {
                    label: "End Date",
                    key: "end_date_format"
                },
                {
                    label: "Start Price",
                    key: "start_price"
                },
                {
                    label: "Reserve Price",
                    key: "reserve_price"
                },
                {
                    label: "Buy Price",
                    key: "buy_now_price"
                },
                {
                    label: "Increment Amount",
                    key: "increment_amount"
                },
                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                },
                {
                    label: "Featured",
                    key: "featured_label",
                    color: "featured_color",
                },
                {
                    label: "Description",
                    key: "description",
                },
                {
                    label: "Meta Title",
                    key: "meta_title",
                },
                {
                    label: "Meta Description",
                    key: "meta_description",
                },


            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
