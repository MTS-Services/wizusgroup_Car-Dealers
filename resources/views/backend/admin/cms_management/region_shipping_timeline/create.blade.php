@extends('backend.admin.layouts.master', ['page_slug' => 'region_shipping_timeline'])
@section('title', 'Region Shipping Timeline create')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Region Shipping Timeline') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.region-shipping-timeline.index',
                        'label' => 'Back',
                        'permissions' => ['region-list', 'region-details', 'region-delete', 'region-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.region-shipping-timeline.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __(' Region Name') }} <span class="text-danger">*</span></label>
                                    <select name="region_id" id="region_id" class="form-control">
                                        <option value="" selected disabled>{{ __('Select Region Name') }}</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}"
                                                {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'region_id']" />
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Ports') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('ports') }}" id="ports" name="ports"
                                        class="form-control" placeholder="Enter ports">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'ports']" />
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Minimum Days') }} <span class="text-danger">*</span></label>
                                            <input type="number" value="{{ old('min_days') }}" id="min_days"
                                                name="min_days" class="form-control" placeholder="Enter minimum days">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'min_days']" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Maximum Days') }} <span class="text-danger">*</span></label>
                                            <input type="number" value="{{ old('max_days') }}" id="max_days"
                                                name="max_days" class="form-control" placeholder="Enter maximum days">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'max_days']" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter Description">{{ old('description') }}</textarea>
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
    {{-- CKEditor5 --}}
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
@endpush
