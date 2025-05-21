@extends('backend.admin.layouts.master', ['page_slug' => 'tax_rate'])
@section('title', 'Tax Rate Create')
@section('content')
    <div class="row">
         <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Tax Rate') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'pm.tax-rate.index',
                        'label' => 'Back',
                        'permissions' => ['tax-rate-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('pm.tax-rate.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name"
                                class="form-control" placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Rate') }} <span class="text-danger">*</span></label>
                            <input type="number" value="{{ old('rate') }}" id="rate" name="rate"
                                class="form-control" placeholder="Enter rate">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'rate']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Tax class') }} <span class="text-danger">*</span></label>
                            <select name="tax_class" id="tax_class" class="form-control">
                                <option value="" selected hidden>{{ __('Select Tax Class') }}</option>
                                @foreach ($tax_classes as $tax_class)
                                    <option value="{{ $tax_class->id }}"
                                        {{ old('tax_class') == $tax_class->id ? 'selected' : '' }}>{{ $tax_class->name }}
                                    </option>
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
                                        {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}
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

                        <div class="form-group">
                            <label>{{ __('Priority') }} <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control">
                                @foreach (App\Models\TaxRate::getPriorityLabels() as $key => $value)
                                    <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'priority']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Compound') }} <span class="text-danger">*</span></label>
                            <select name="compound" id="compound" class="form-control">
                                @foreach (App\Models\TaxRate::getCompoundBtnLabels() as $key => $value)
                                    <option value="{{ $key }}" {{ old('compound') == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'compound']" />
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
            $('#country').on('change', function() {
                let route1 = "{{ route('axios.get-states-or-cities') }}";
                getStatesOrCity($(this).val(), route1);
            });
            $('#state').on('change', function() {
                let route2 = "{{ route('axios.get-cities') }}";
                getCities($(this).val(), route2);
            });
            $('#city').on('change', function() {
                let route3 = "{{ route('axios.get-operation-areas') }}";
                getOperationAreas($(this).val(), route3);
            });
        });
    </script>
@endpush
