@extends('backend.admin.layouts.master', ['page_slug' => 'pro_info_cat_tf'])
@section('title', 'Edit Product Information Category Type Feature')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Product Information Category Type Feature') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.pro-info-cat-tf.index',
                        'label' => 'Back',
                        'permissions' => ['product_info_category_type_features-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.pro-info-cat-tf.update', encrypt($feature->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                     <div class="form-group">
                        <label>{{ __('Product Info Category') }} <span class="text-danger">*</span></label>
                        <select name="product_info_cat_id" class="form-control" id="product_info_cat_id">
                            <option value="" selected hidden>{{__('Select Product Info Category')}}</option>
                            @foreach ($pro_info_cat_types as $pro_info_cat_type)
                                <option value="{{$pro_info_cat_type->id}}" {{ $feature->pro_info_cat_type_id == $pro_info_cat_type->id ? 'selected' : ''}}>{{ $pro_info_cat_type->name }}</option>
                            @endforeach
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_id']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Product Info Category Type') }} <span class="text-danger">*</span></label>
                        <select name="product_info_cat_type_id" class="form-control" id="product_info_cat_type_id" disabled>
                            <option value="" selected hidden>{{__('Select Product Info Category Type')}}</option>
                        </select>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_info_cat_type_id']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $feature->name) }}" id="title" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug', $feature->slug) }}" id="slug" name="slug" class="form-control" placeholder="Enter slug">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                    </div>

                    <div class="form-group float-end mt-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
        $(document).ready(function() {

            let route = "{{ route('axios.get-info-cat-types') }}";
             $('#product_info_cat_id').on('change', function() {
                getInfoCatTypes($(this).val(), route);
            });
            getInfoCatTypes(`{{$feature->product_info_cat_id}}`, route, `{{$feature->product_info_cat_type_id}}`);
        });
    </script>
{{-- FilePond  --}}
@endpush
