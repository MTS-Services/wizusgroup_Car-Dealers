@extends('backend.admin.layouts.master', ['page_slug' => 'subchildcategory'])
@section('title', 'Sub Child Category List')
@push('css')
    <link rel="stylesheet" href="{{ asset('custom_litebox/litebox.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Sub Child Category List') }}</h4>
                    <div class="buttons">
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.sub-child-category.recycle-bin',
                            'label' => 'Recycle Bin',
                            'className' => 'btn-danger',
                            'permissions' => ['sub-child-category-restore'],
                        ]" />
                        <x-backend.admin.button :datas="[
                            'routeName' => 'pm.sub-child-category.create',
                            'label' => 'Add New',
                            'permissions' => ['sub-child-category-create'],
                        ]" />
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-responsive table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Main Category') }}</th>
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
    {{-- Details Modal  --}}
    <x-backend.admin.details-modal :datas="['modal_title' => 'Sub Child Category Details']" />
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
                ['parent_id', true, true],
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
                main_route: "{{ route('pm.sub-child-category.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5, 6],
                model: 'subcategory',
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
            let route = "{{ route('pm.sub-child-category.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [
                {
                    label: "Main Category",
                    key: "parent_name"
                },
                {
                    label: "Sub Category",
                    key: "sub_parent_name"
                },
                {
                    label: "Name",
                    key: "name"
                },

                {
                    label: "Slug",
                    key: "slug"
                },
                {
                    label: "Image",
                    key: "modified_image",
                    type: "image"
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
                    label: "Meta Title",
                    key: "meta_title"
                },
                {
                    label: "Meta Description",
                    key: "meta_description"
                },
                {
                    label: "Description",
                    key: "description"
                },
            ];
            fetchAndShowModal(detailsUrl, headers, "#modal_data", "myModal");
        });
    </script>
@endpush
