@extends('backend.admin.layouts.master', ['page_slug' => 'city'])
@section('title', 'Create City')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create City') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'setup.city.index',
                        'label' => 'Back',
                        'permissions' => ['city-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('setup.city.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" id="title" name="name" class="form-control"
                                placeholder="Enter name">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'name']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Slug') }}<span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug" class="form-control"
                                placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea type="text" name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
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

    <script>
         // Get Country States By Axios
        $(document).ready(function() {
            $('#country').on('change', function () {
                let route = "{{ route('axios.get-states') }}";
                getStates($(this).val(), route);
            });
        });
    </script>
@endpush
