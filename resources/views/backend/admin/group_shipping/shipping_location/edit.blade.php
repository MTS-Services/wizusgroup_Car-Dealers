@extends('backend.admin.layouts.master', ['page_slug' => 'shipping-location'])
@section('title', 'Edit Shipping Location')

@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Shipping Location') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'gs.shipping-location.index',
                        'label' => 'Back',
                        'permissions' => ['shipping-location-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('gs.shipping-location.update', encrypt($shipping_location->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Name --}}
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name', $shipping_location->name) }}" id="title"
                                name="name" class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        {{-- Slug --}}
                        <div class="form-group">
                            <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug', $shipping_location->slug) }}" id="slug"
                                name="slug" class="form-control" placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>
                        {{-- Image --}}

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
