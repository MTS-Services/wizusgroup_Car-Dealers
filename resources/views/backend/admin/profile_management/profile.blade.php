@extends('backend.admin.layouts.master', ['page_slug' => 'admin_profile'])

@section('title', 'Admin Profile')

@section('content')
    <div class="container-fluid">
        <div class="row profile_tabs">
            <div class="col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2 active" data-bs-target="profile">profile</p>
                    <p class="btn_item w-100 py-2 " data-bs-target="address">Address</p>
                    <p class="btn_item w-100 py-2" data-bs-target="change-password">Change Password</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    @include('backend.admin.profile_management.include.profile')
                    {{-- Profile Address --}}
                    @include('backend.admin.profile_management.include.address')

                    {{-- Password Change Card --}}
                    @include('backend.admin.profile_management.include.password')

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script src="{{ asset('ckEditor5/main.js') }}"></script>
    <script src="{{ asset('filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function() {
            const existingFiles = {
                "#image": "{{ $admin->modified_image }}",
            }
            file_upload(["#image"], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/svg'],existingFiles);
        });
    </script>
       <script>
        $(document).ready(function() {
            // Handle click on nav items
            $('.btn_item').on('click', function() {
                $('.btn_item').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('.tab-pane').removeClass('active');

                $('#' + target).addClass('active');
            });
        });
        $(document).ready(function() {
            let route1 = "{{ route('axios.get-states-or-cities') }}";
            $('#country').on('change', function() {
                getStatesOrCity($(this).val(), route1);
            });
            let route2 = "{{ route('axios.get-cities') }}";
            $('#state').on('change', function() {
                getCities($(this).val(), route2);
            });

            let data_id =`{{ $address?->state_id ? $address?->state_id : $address?->city_id }}`;
            if (data_id) {
                getStatesOrCity(`{{$address?->country_id}}`, route1, data_id);
            }

            if (`{{ $address?->state_id }}`) {
                getCities(`{{ $address?->state_id }}`, route2, `{{ $address?->city_id }}`);
            }
        });
    </script>
    {{-- FilePond  --}}
@endpush
