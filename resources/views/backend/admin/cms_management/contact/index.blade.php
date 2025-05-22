@extends('backend.admin.layouts.master', ['page_slug' => 'contact'])
@section('title', 'Contact List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Contact List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'cms.contact.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['contact.restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'cms.contact.create',
                            'label' => 'Add New',
                            'permissions' => ['contact-create'],
                        ]" />
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
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
    <x-backend.admin.details-modal :datas="['modal_title' => 'Contact Details']" />
@endsection
@push('js')
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [

                ['name', true, true],
                ['email', true, true],
                ['status', true, true],
                ['creater_id', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('cms.contact.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5],
                model: 'Contact',
            };
            initializeDataTable(details);
        })
    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@push('js')
    <script src="{{ asset('custom_litebox/litebox.js') }}"></script>
    {{-- Show details scripts --}}
    <script src="{{ asset('modal/details_modal.js') }}"></script>
    <script>
        $(document).on("click", ".view", function() {
            let id = $(this).data("id");
            let route = "{{ route('cms.contact.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: "Name",
                    key: "name"
                },
                {
                    label: "Email",
                    key: "email"
                },
                {
                    label: "Status",
                    key: "status_label",
                    color: "status_color",
                },
                {
                    label: "Message",
                    key: "message"
                },
                {
                    lablel: "Opened By",
                    key: "open_by"
                }
            ];

            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
