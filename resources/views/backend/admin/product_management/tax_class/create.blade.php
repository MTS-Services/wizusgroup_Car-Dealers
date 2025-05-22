@extends('backend.admin.layouts.master', ['page_slug' => 'tax_class'])
@section('title', 'Tax Class Create')
@section('content')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Create Tax Class') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.tax-class.index',
                        'label' => 'Back',
                        'permissions' => ['tax-class-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.tax-class.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                            placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    {{-- Description --}}
                    <div class="form-group">
                        <label>{{__('Description')}}</label>
                        <textarea name="description" class="form-control" id="description" placeholder="Enter description">{{old('description')}}</textarea>
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
