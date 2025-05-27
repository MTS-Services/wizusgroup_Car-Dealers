@extends('backend.admin.layouts.master', ['page_slug' => 'container'])
@section('title', 'Create Container')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Container') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'gs.container.index',
                        'label' => 'Back',
                        'permissions' => ['container-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('gs.container.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Shipping Port --}}
                        <div class="form-group">
                            <label>{{ __('Shipping Port') }} <span class="text-danger">*</span></label>
                            <select name="shipping_port" class="form-control" id="shipping_port">
                                <option value="" selected hidden>{{ __('--Select Shipping Port--') }}</option>
                                @foreach ($shippingLocations as $ship_port)
                                    <option value="{{ $ship_port->id }}"
                                        {{ old('shipping_port') == $ship_port->id ? 'selected' : '' }}>{{ $ship_port->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'shipping_port']" />
                        </div>

                        {{-- Destination Port --}}
                        <div class="form-group">
                            <label>{{ __('Destination Port') }} <span class="text-danger">*</span></label>
                            <select name="destination_port" class="form-control" id="destination_port">
                                <option value="" selected hidden>{{ __('--Select Destination Port--') }}</option>
                                @foreach ($shippingLocations as $des_port)
                                    <option value="{{ $des_port->id }}"
                                        {{ old('destination_port') == $des_port->id ? 'selected' : '' }}>{{ $des_port->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'destination_port']" />
                        </div>

                        {{-- Title --}}
                        <div class="form-group">
                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('title') }}" id="title" name="title"
                                class="form-control" placeholder="Enter title">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'title']" />
                        </div>

                        {{-- Slug --}}
                        <div class="form-group">
                            <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                class="form-control" placeholder="Enter slug">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                        </div>

                        {{-- Image --}}
                        <div class="form-group">
                            <label>{{ __('Image') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control filepond" id="image"
                                accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                        </div>

                        {{-- Deadline --}}
                        <div class="form-group">
                            <label>{{ __('Deadline') }} <span class="text-danger">*</span></label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}" class="form-control">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'deadline']" />
                        </div>

                        {{-- Length --}}
                        <div class="form-group">
                            <label>{{ __('Length (cm)') }} <span class="text-danger">*</span></label>
                            <input type="number" name="length_cm" value="{{ old('length_cm') }}" class="form-control"
                                placeholder="Enter length in cm">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'length_cm']" />
                        </div>

                        {{-- Width --}}
                        <div class="form-group">
                            <label>{{ __('Width (cm)') }} <span class="text-danger">*</span></label>
                            <input type="number" name="width_cm" value="{{ old('width_cm') }}" class="form-control"
                                placeholder="Enter width in cm">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'width_cm']" />
                        </div>

                        {{-- Height --}}
                        <div class="form-group">
                            <label>{{ __('Height (cm)') }} <span class="text-danger">*</span></label>
                            <input type="number" name="height_cm" value="{{ old('height_cm') }}" class="form-control"
                                placeholder="Enter height in cm">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'height_cm']" />
                        </div>

                        {{-- Max Weight --}}
                        <div class="form-group">
                            <label>{{ __('Max Weight (kg)') }} <span class="text-danger">*</span></label>
                            <input type="number" name="max_weight_kg" value="{{ old('max_weight_kg') }}"
                                class="form-control" placeholder="Enter max weight in kg">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'max_weight_kg']" />
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
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], ["image/jpg, image/jpeg, image/png, image/webp, image/svg"]);
        });
    </script>
    {{-- FilePond  --}}
@endpush
