@extends('backend.admin.layouts.master', ['page_slug' => 'state'])
@section('title', 'Create State')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create State') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'setup.state.index',
                        'label' => 'Back',
                        'permissions' => ['state-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('setup.state.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Country') }}  <span class="text-danger">*</span></label>
                            <select name="country_id" class="form-control">
                                <option value="" selected disabled>{{ __('Select Country') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'parent_id']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Slug') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                                placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Code') }}  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('code') }}" id="slug" name="code" class="form-control"
                                placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'code']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" placeholder="Enter description">{{old('description')}}</textarea>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>
@endpush
