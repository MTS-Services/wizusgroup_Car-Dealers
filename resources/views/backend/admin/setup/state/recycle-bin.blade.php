@extends('backend.admin.layouts.master', ['page_slug' => 'state'])
@section('title', 'State List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('State Recycle Bin') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'setup.state.index',
                            'label' => 'Back',
                            'permissions' => ['country-list'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('code') }}</th>
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
                ['name', true, true],
                ['country_id', true, true],
                ['status', true, true],
                ['code', true, true],
                ['deleted_by', true, true],
                ['deleted_at', true, true],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('setup.state.recycle-bin') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3,4,5,6],
                model: 'State',
            };
            // initializeDataTable(details);

            initializeDataTable(details);
        })
    </script>
@endpush

