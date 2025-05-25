<div id="change-password" class="tab-pane">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h4 class="mb-0 py-2 text-white">{{ __('Change Password') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>{{ __('Current Password') }} <span class="text-danger">*</span></label>
                        <input type="password" name="old_password" class="form-control">
                        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'old_password']" />
                    </div>


                    <div class="col-md-12 mb-3">
                        <label>{{ __('New Password') }}</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>{{ __('Confirm New Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-success px-4">{{ __('Change Password') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
