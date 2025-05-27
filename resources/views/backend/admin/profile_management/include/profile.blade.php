<div id="profile" class="tab-pane active">
    {{-- Profile Edit Card --}}
    <div class="col-lg-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h4 class="mb-0 py-2 text-white">Profile</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Profile Details --}}
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="file" name="image"
                                            class="filepond" id="image" accept="image/jpg, image/jpeg, image/png, image/webp, image/svg">
                                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label>{{ __('First Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="first_name"
                                                value="{{ $admin?->first_name }}" class="form-control"
                                                placeholder="Enter your first name">
                                            <x-feed-back-alert :datas="[
                                                'errors' => $errors,
                                                'field' => 'first_name',
                                            ]" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label>{{ __('Last Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="last_name"
                                                value="{{ $admin?->last_name }}" class="form-control"
                                                placeholder="Enter your last name">
                                            <x-feed-back-alert :datas="[
                                                'errors' => $errors,
                                                'field' => 'last_name',
                                            ]" />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label>{{ __('Username') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="username"
                                                value="{{ $admin?->username }}" class="form-control"
                                                placeholder="Enter your username">
                                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'username']" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ $admin?->email }}"
                                    class="form-control" placeholder="Enter your email">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'email']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Phone') }}</label>
                                <input type="text" name="phone" value="{{ $admin?->phone }}"
                                    class="form-control" placeholder="Enter your phone">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'phone']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Date of Birth') }}</label>
                                <input type="date" name="dob" value="{{ $admin?->personalInformation?->dob }}"
                                    class="form-control">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'dob']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="gender"
                                        class="form-label">{{ __('Gender') }}</label>
                                    <select name="gender" id="gender" class="form-select">
                                        @foreach (App\Models\PersonalInformation::getGenderLabels() as $key => $gender)
                                            <option value="{{ $key }}"
                                                {{ $admin?->personalInformation?->gender == $key ? 'selected' : '' }}>
                                                {{ $gender }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'gender']" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Fathers Name') }}</label>
                                <input type="text" name="father_name"
                                    value="{{ $admin?->personalInformation?->father_name }}"
                                    class="form-control" placeholder="Enter your fathers name">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'father_name']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Mothers Name') }}</label>
                                <input type="text" name="mother_name"
                                    value="{{ $admin?->personalInformation?->mother_name }}"
                                    class="form-control" placeholder="Enter your mothers name">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'mother_name']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Emergency Phone') }}</label>
                                <input type="text" name="emergency_phone"
                                    value="{{ $admin?->personalInformation?->emergency_phone }}"
                                    class="form-control" placeholder="Enter your emergency phone">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'bio']" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label>{{ __('Nationality') }}</label>
                                <input type="text" name="nationality"
                                    value="{{ $admin?->personalInformation?->nationality }}"
                                    class="form-control" placeholder="Enter name">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'nationality']" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label>{{ __('Bio') }}</label>
                                <textarea name="bio" class="form-control p-3" rows="5" placeholder="Enter your bio">{{ $admin?->personalInformation?->bio }}</textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'bio']" />
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <button class="btn btn-primary px-4">{{ __('Update Profile') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image": "{{ $admin->modified_image }}",
            }
            file_upload(["#image"], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'],existingFiles);
        });
    </script>
@endpush
