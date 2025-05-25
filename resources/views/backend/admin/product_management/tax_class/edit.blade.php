@extends('backend.admin.layouts.master', ['page_slug' => 'tax_class'])
@section('title', 'Tax Class Edit')

@section('content')
<div class="row">
     <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Edit Tax Class') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'pm.tax-class.index',
                        'label' => 'Back',
                        'permissions' => ['tax-class-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('pm.tax-class.update', encrypt($tax_class->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $tax_class->name) }}" name="name" class="form-control" placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label>{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" placeholder="Enter description">{{ old('description', $tax_class->description) }}</textarea>
                    </div>
                    {{-- Submit --}}
                    <div class="form-group float-end mt-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-backend.admin.documentation :document="$document" />
</div>
@endsection
@push('js')
<script src="{{ asset('ckEditor5/main.js') }}"></script>
@endpush
