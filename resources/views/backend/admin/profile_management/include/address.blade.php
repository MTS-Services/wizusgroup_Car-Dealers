<div id="address" class="tab-pane ">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h4 class="mb-0 py-2 text-white">{{ __('Profile Address') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.address.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>{{ __('Country') }} <span class="text-danger">*</span></label>
                                <select name="country_id" id="country" class="form-select">
                                    <option value="{{ $address?->country_id }}" selected hidden>
                                        {{ __('Select Country') }}
                                    </option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $address?->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'country_id']" />
                            </div>
                            <div class="col-6 form-group">
                                <label>{{ __('State') }}</label>
                                <select name="state" id="state" class="form-select" disabled>
                                    <option value="" selected hidden>{{ __('Select State') }}
                                    </option>
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'state']" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>{{ __('City') }} <span class="text-danger">*</span></label>
                                <select name="city" id="city" class="form-select" disabled>
                                    <option value="" selected hidden>{{ __('Select City') }}
                                    </option>
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'city']" />
                            </div>
                            {{-- postal code --}}
                            <div class="col-6 mb-3">
                                <div class="form-group">
                                    <label>{{ __('Postal Code') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="postal_code"
                                        value="{{ $address->postal_code ?? old('postal_code') }}"
                                        placeholder="Enter postal code" class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'postal_code']" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>{{ __('Street Address') }} <span class="text-danger">*</span></label>
                        <textarea name="address_line_1" class="form-control no-ckeditor5" id="address_line_1" cols="30"
                            rows="5">{{ $address->address_line_1 ?? old('address_line_1') }}</textarea>
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address_line_1']" />
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-success px-4">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
