@extends('backend.admin.layouts.master', ['page_slug' => 'region'])
@section('title', 'Region create')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Region') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.region.index',
                        'label' => 'Back',
                        'permissions' => ['region-list', 'region-details', 'region-delete', 'region-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.region.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Region Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('name') }}" id="title" name="name"
                                        class="form-control" placeholder="Enter name">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                        class="form-control" placeholder="Enter slug">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
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
