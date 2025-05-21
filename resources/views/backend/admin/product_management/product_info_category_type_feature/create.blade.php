@extends('backend.admin.layouts.master', ['page_slug' => 'pro_info_cat_tf'])
@section('title', 'Create Product Information Category Type Feature')
@section('content')
    <div class="row">
         <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Product Information Category Type Feature') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.pro-info-cat-tf.index',
                        'label' => 'Back',
                        'permissions' => ['product-info-category-type-feature-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.pro-info-cat-tf.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>{{ __('Product Info Category') }} <span class="text-danger">*</span></label>
                            <select name="product_info_cat_id" class="form-control" id="product_info_cat_id">
                                <option value="" selected hidden>{{ __('Select product_info_cat_id') }}</option>
                                @foreach ($features as $feature)
                                    <option value="{{ $feature->id }}"
                                        {{ old('product_info_cat_id') == $feature->id ? 'selected' : '' }}>
                                        {{ $feature->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Product Info Category Type') }} <span class="text-danger">*</span></label>
                            <select name="product_info_cat_type_id" class="form-control" id="product_info_cat_type_id"
                                disabled>
                                <option value="" selected hidden>{{ __('Select Product Info Category Type') }}
                                </option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_type_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name"
                                class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                class="form-control" placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <x-backend.admin.documentation :document="$document" />
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#product_info_cat_id').on('change', function() {
                let route = "{{ route('axios.get-info-cat-types') }}";
                getInfoCatTypes($(this).val(), route);
            });
        });
    </script>
    {{-- FilePond  --}}
@endpush
