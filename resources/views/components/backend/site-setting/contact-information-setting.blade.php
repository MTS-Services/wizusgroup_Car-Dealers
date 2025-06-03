<div class="row">
    <div class="col-md-12">
        <div class="card mb-0">
            <div class="card-header">
                <h5 class="title">{{ __('Contact Information Settings') }}</h5>
            </div>
            <form method="POST" action="{{ route('site_setting.update') }}" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label>{{ __('Email') }}</label>
                                <input type="email" name="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Email') }}"
                                    value="{{ $contact_info_settings['email'] ?? '' }}">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'email']" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <label>{{ __('Phone') }}</label>
                                <input type="text" name="phone"
                                    class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Phone') }}"
                                    value="{{ $contact_info_settings['phone'] ?? '' }}">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'phone']" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('whatsapp') ? ' has-danger' : '' }}">
                                <label>{{ __('Whatsapp Number') }}</label>
                                <input type="text" name="whatsapp"
                                    class="form-control{{ $errors->has('whatsapp') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('whatsapp') }}"
                                    value="{{ $contact_info_settings['whatsapp'] ?? '' }}">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'whatsapp']" />
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <label>{{ __('Main Location') }}</label>
                                <textarea name="address" id="" cols="30" rows="5"
                                    class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }} no-ckeditor5"
                                    placeholder="{{ __('Location') }}">{{ $contact_info_settings['address'] ?? '' }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'address']" />
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="form-group">
                                <div class="card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>{{ __('Other Offices') }}</h4>
                                        <button type="button"
                                            class="btn btn-primary add_more_office_header btn-header-add-more">
                                            {{ __('Add More') }}
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="office-rows-container">

                                            @forelse (json_decode($contact_info_settings['office_infos'] ?? '[]', true) as $key => $office_info)
                                                <div class="row align-items-center office-row pb-3 mb-3">
                                                    <div class="col-11">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="country_0"
                                                                        class="form-label">{{ __('Country') }} </label>
                                                                    <input type="text"
                                                                        name="office_infos[0][country]" id="country_0"
                                                                        placeholder="Enter country" class="form-control"
                                                                        value="{{ $office_info['country'] ?? '' }}">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.country',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email_0"
                                                                        class="form-label">{{ __('Email') }} </label>
                                                                    <input type="email" name="office_infos[0][email]"
                                                                        id="email_0" placeholder="Enter email"
                                                                        class="form-control" value="{{ $office_info['email'] ?? '' }}">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.email',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="phone_0"
                                                                        class="form-label">{{ __('Phone') }} </label>
                                                                    <input type="text" name="office_infos[0][phone]"
                                                                        id="phone_0" placeholder="Enter phone"
                                                                        class="form-control" value="{{ $office_info['phone'] ?? '' }}">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.phone',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="whatsapp_0"
                                                                        class="form-label">{{ __('Whatsapp Number') }}
                                                                    </label>
                                                                    <input type="text"
                                                                        name="office_infos[0][whatsapp]" id="whatsapp_0"
                                                                        placeholder="Enter whatsapp"
                                                                        class="form-control" value="{{ $office_info['whatsapp'] ?? '' }}">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.whatsapp',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="location_0"
                                                                        class="form-label">{{ __('Location') }}
                                                                    </label>
                                                                    <textarea name="office_infos[0][location]" id="location_0" class="form-control no-ckeditor5" cols="30"
                                                                        rows="2" placeholder="Enter location">{{ $office_info['location'] ?? '' }}</textarea>
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.location',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 d-flex justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove_office_row" disabled
                                                            title="Remove this office">
                                                            {{ __('Remove') }}
                                                        </button>
                                                    </div>
                                                </div>

                                            @empty
                                                <div class="row align-items-center office-row pb-3 mb-3">
                                                    <div class="col-11">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="country_0"
                                                                        class="form-label">{{ __('Country') }}
                                                                    </label>
                                                                    <input type="text"
                                                                        name="office_infos[0][country]" id="country_0"
                                                                        placeholder="Enter country"
                                                                        class="form-control">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.country',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email_0"
                                                                        class="form-label">{{ __('Email') }}
                                                                    </label>
                                                                    <input type="email"
                                                                        name="office_infos[0][email]" id="email_0"
                                                                        placeholder="Enter email"
                                                                        class="form-control">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.email',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="phone_0"
                                                                        class="form-label">{{ __('Phone') }}
                                                                    </label>
                                                                    <input type="text"
                                                                        name="office_infos[0][phone]" id="phone_0"
                                                                        placeholder="Enter phone"
                                                                        class="form-control">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.phone',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="whatsapp_0"
                                                                        class="form-label">{{ __('Whatsapp Number') }}
                                                                    </label>
                                                                    <input type="text"
                                                                        name="office_infos[0][whatsapp]"
                                                                        id="whatsapp_0" placeholder="Enter whatsapp"
                                                                        class="form-control">
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.whatsapp',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="location_0"
                                                                        class="form-label">{{ __('Location') }}
                                                                    </label>
                                                                    <textarea name="office_infos[0][location]" id="location_0" class="form-control no-ckeditor5" cols="30"
                                                                        rows="2" placeholder="Enter location"></textarea>
                                                                    {{-- IMPORTANT CHANGE HERE --}}
                                                                    <x-feed-back-alert :datas="[
                                                                        'errors' => $errors,
                                                                        'field' => 'office_infos.0.location',
                                                                    ]" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-1 d-flex justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove_office_row" disabled
                                                            title="Remove this office">
                                                            {{ __('Remove') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('sort_description') ? ' has-danger' : '' }}">
                                <label>{{ __('Sort Description') }}</label>
                                <textarea name="sort_description" id="" cols="30" rows="2"
                                    class="form-control {{ $errors->has('sort_description') ? ' is-invalid' : '' }} no-ckeditor5"
                                    placeholder="{{ __('Sort Description') }}">{{ $contact_info_settings['sort_description'] ?? '' }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'sort_description']" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                <label>{{ __('Description') }}</label>
                                <textarea name="description" id="" cols="30" rows="5"
                                    class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }} no-ckeditor5"
                                    placeholder="{{ __('Description') }}">{{ $contact_info_settings['description'] ?? '' }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let index = 1; // Start index for new rows

            // Helper function to update the remove button state
            function updateRemoveButtons() {
                const $rows = $('.office-row');
                if ($rows.length === 1) {
                    // If only one row, disable its remove button
                    $rows.find('.remove_office_row').prop('disabled', true);
                } else {
                    // If more than one row, enable all remove buttons
                    $rows.find('.remove_office_row').prop('disabled', false);
                }

                // Add/remove border based on position
                $rows.removeClass('border-bottom pb-3 mb-3'); // Remove all borders first
                $rows.slice(0, -1).addClass('border-bottom pb-3 mb-3'); // Add border to all but the last
            }

            // Initial call to set button state on page load
            updateRemoveButtons();

            // Add More Office Row from header button
            $(document).on('click', '.add_more_office_header', function() {
                const $originalRow = $('.office-row').first();
                const $clone = $originalRow.clone();

                // Update names and IDs with current index
                $clone.find('input, textarea').each(function() {
                    let name = $(this).attr('name');
                    let id = $(this).attr('id');

                    // Replace index in name (e.g., office_infos[0][country] -> office_infos[1][country])
                    if (name) {
                        name = name.replace(/\[\d+\]/, `[${index}]`);
                        $(this).attr('name', name);
                    }

                    // Replace index in ID (e.g., country_0 -> country_1)
                    if (id) {
                        id = id.replace(/_\d+/, `_${index}`);
                        $(this).attr('id', id);
                    }

                    $(this).val(''); // Clear cloned values
                });

                // Update label 'for' attributes
                $clone.find('label').each(function() {
                    let forAttr = $(this).attr('for');
                    if (forAttr) {
                        forAttr = forAttr.replace(/_\d+/, `_${index}`);
                        $(this).attr('for', forAttr);
                    }
                });

                // Update x-feed-back-alert 'field' attributes
                // This is crucial for dynamically updated rows!
                $clone.find('x-feed-back-alert').each(function() {
                    let datas = $(this).attr(':datas'); // Get the datas string
                    if (datas) {
                        // Regex to find and replace the field value (e.g., 'field' => 'office_infos.0.country')
                        datas = datas.replace(/'field'\s*=>\s*'office_infos\.\d+\.([a-z_]+)'/,
                            `'field' => 'office_infos.${index}.$1'`);
                        $(this).attr(':datas', datas);
                    }
                });


                // Ensure the cloned row has a 'Remove' button and is enabled
                $clone.find('.remove_office_row').prop('disabled', false);

                // Append the cloned row
                $('.office-rows-container').append($clone);

                index++; // Increment index for the next row
                updateRemoveButtons(); // Update button states after adding
            });

            // Remove Office Row and Rearrange Indexes
            $(document).on('click', '.remove_office_row', function() {
                $(this).closest('.office-row').remove();
                rearrangeIndexes();
                updateRemoveButtons(); // Update button states after removing
            });

            // Function to rearrange indexes after a row is removed
            function rearrangeIndexes() {
                $('.office-row').each(function(i) {
                    $(this).find('input, textarea').each(function() {
                        let name = $(this).attr('name');
                        let id = $(this).attr('id');

                        if (name) {
                            const newName = name.replace(/\[\d+\]/, `[${i}]`);
                            $(this).attr('name', newName);
                        }
                        if (id) {
                            const newId = id.replace(/_\d+/, `_${i}`);
                            $(this).attr('id', newId);
                            Id('for', newForAttr);
                        }
                    });

                    // Update x-feed-back-alert 'field' attributes after re-indexing
                    $(this).find('x-feed-back-alert').each(function() {
                        let datas = $(this).attr(':datas');
                        if (datas) {
                            datas = datas.replace(/'field'\s*=>\s*'office_infos\.\d+\.([a-z_]+)'/,
                                `'field' => 'office_infos.${i}.$1'`);
                            $(this).attr(':datas', datas);
                        }
                    });
                });

                // Update the global index counter based on the current number of rows
                index = $('.office-row').length;
            }
        });
    </script>
@endpush
