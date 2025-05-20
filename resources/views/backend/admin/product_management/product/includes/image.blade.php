<form action="" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>{{ __('Primary image') }} <span class="text-danger">*</span></label>
        <input type="file" name="uploadImage" data-actualName="image" class="form-control filepond" id="image"
            accept="image/*">
        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'image']" />
    </div>
    <div class="form-group">
        <label for="images">{{ __('Images') }}</label>
        <input type="file" name="uploadImage[]" data-actualName="images[]" class="form-control filepond" multiple id="images"
            accept="image/*">
        <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'images.*']" />
    </div>

    <div class="form-group float-end">
        <input type="submit" class="btn btn-primary" value="Next">
    </div>
</form>
@push('js')
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            file_upload(["#image"], "uploadImage", "admin", [], false);
            file_upload(["#images"], "uploadImage", "admin", [], true);
        });
    </script>
@endpush
