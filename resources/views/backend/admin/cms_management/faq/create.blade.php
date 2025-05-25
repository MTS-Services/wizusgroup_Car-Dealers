@extends('backend.admin.layouts.master', ['page_slug' => 'faq'])
@section('title', 'Create Faq')
@section('content')
    <div class="row">
         <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Faq') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.faq.index',
                        'label' => 'Back',
                        'permissions' => ['faq-list', 'faq-details', 'faq-delete', 'faq-status'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.faq.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label>{{ __('Question') }} <span class="text-danger">*</span></label>
                                <input type="text" value="{{ old('question') }}" name="question"
                                    class="form-control" placeholder="Enter Question">
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'question']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Answer') }} <span class="text-danger">*</span></label>
                                <textarea name="answer" class="form-control" id=""></textarea>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'answer']" />
                            </div>
                            <div class="form-group">
                                <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                                <select name="type" class="form-control">
                                    @foreach (App\Models\Faq::getTypeLabels() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}
                                        </option>

                                    @endforeach
                                </select>
                                <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'type']" />
                            </div>
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
@endpush
