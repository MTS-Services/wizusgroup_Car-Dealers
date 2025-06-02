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
                        <div class="form-group">
                            <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                            <select name="country" id="country" class="form-control">
                                <option value="" selected hidden>{{__('Select Country')}}</option>
                                @foreach ($countries as $country)
                                    <option value="{{$country->id}}" {{ $shipping_location->country_id == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
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
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>

    <script>
         // Get Country States By Axios
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function () {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function () {
                getCities($(this).val(), route2);
            });
            let data_id = `{{ $shipping_location->state_id ? $shipping_location->state_id : $shipping_location->city_id }}`;
            if(data_id){
                getStatesOrCity($('#country').val(), route1, data_id);
            }
            if(`{{$shipping_location->state_id}}`){
                getCities(`{{$shipping_location->state_id}}`, route2, `{{ $shipping_location->city_id }}`);
            }
        });
    </script>
@endpush