@extends('backend.admin.layouts.master', ['page_slug' => 'tax_rate'])
@section('title', 'Tax Rate Edit')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Tax Rate ') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.tax-rate.index',
                        'label' => 'Back',
                        'permissions' => ['tax-rate-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.tax-rate.update', encrypt($tax_rate->id)) }}') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $tax_rate->name }}" id="title" name="name"
                                class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Rate') }}<span class="text-danger">*</span></label>
                            <input type="number" value="{{ $tax_rate->rate }}" id="rate" name="rate"
                                class="form-control" placeholder="Enter rate">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'rate']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Tax class') }} <span class="text-danger">*</span></label>
                            <select name="tax_class" id="tax_class" class="form-control">
                                <option value="" selected hidden>{{ __('Select Tax Class') }}</option>
                                @foreach ($tax_classes as $tax_class)
                                    <option value="{{ $tax_class->id }}"
                                        {{ $tax_rate->tax_class_id == $tax_class->id ? 'selected' : '' }}>
                                        {{ $tax_class->name }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'country']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                            <select name="country" id="country" class="form-control">
                                <option value="" selected hidden>{{ __('Select Country') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $tax_rate->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'country']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('City') }} <span class="text-danger">*</span></label>
                            <select name="city" id="city" class="form-control" disabled>
                                <option value="" selected hidden>{{ __('Select City') }}</option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'city']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('State') }}</label>
                            <select name="state" id="state" class="form-control" disabled>
                                <option value="" selected hidden>{{ __('Select State') }}</option>
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'state']" />
                        </div>


                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('ckEditor5/main.js') }}"></script>

    <script>
        // Get Country States By Axios
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });
            let route3 = "{{ route('axios.get-operation-areas') }}";
            $('#city').on('change', function() {
                getOperationAreas($(this).val(), route3);
            });


            let data_id = `{{ $tax_rate->state_id ? $tax_rate->state_id : $tax_rate->city_id }}`;
            if(data_id){
                getStatesOrCity($('#country').val(), route1, data_id);
            }
            if (`{{ $tax_rate->state_id }}`) {
                getCities(`{{ $tax_rate->state_id }}`, route2, `{{ $tax_rate->city_id }}`);
            }
            if(`{{ $tax_rate->city_id }}`){
                getOperationAreas(`{{ $tax_rate->city_id }}`, route3, `{{ $tax_rate->operation_area_id }}`);
            }
        });
    </script>
@endpush
