@extends('backend.admin.layouts.master', ['page_slug' => 'shipping_location'])
@section('title', 'Create Shipping Location')
@section('content')
<div class="row">
     <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">{{ __('Create Shipping Location') }}</h4>
                <x-backend.admin.button :datas="[
                        'routeName' => 'gs.shipping-location.index',
                        'label' => 'Back',
                        'permissions' => ['shipping-location-list'],
                    ]" />
            </div>
            <div class="card-body">
                <form action="{{ route('gs.shipping-location.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                     <div class="form-group">
                            <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                            <select name="country" id="country" class="form-control">
                                <option value="" selected hidden>{{__('Select Country')}}</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" {{ old('country') == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'country']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('State') }}</label>
                            <select name="state" id="state" class="form-control" disabled>
                                <option value="" selected hidden>{{__('Select State')}}</option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'state']" />
                        </div>
                         <div class="form-group">
                            <label>{{ __('City') }} <span class="text-danger">*</span></label>
                            <select name="city" id="city" class="form-control" disabled>
                                <option value="" selected hidden>{{__('Select City')}}</option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'city']" />
                        </div>
                    <div class="form-group">
                        <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                            placeholder="Enter name">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                    </div>
                    {{-- Slug --}}
                    <div class="form-group">
                        <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                            placeholder="Enter slug">
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
    <script src="{{ asset('ckEditor5/main.js') }}"></script>

    <script>
         // Get Country States By Axios
        $(document).ready(function() {
            $('#country').on('change', function () {
                let route1 = "{{ route('axios.get-states-or-cities') }}";
                getStatesOrCity($(this).val(), route1);
            });
            $('#state').on('change', function () {
                let route2 = "{{ route('axios.get-cities') }}";
                getCities($(this).val(), route2);
            });
        });
    </script>
@endpush

