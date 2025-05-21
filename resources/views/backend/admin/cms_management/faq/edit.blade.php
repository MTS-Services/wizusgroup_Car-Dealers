@extends('backend.admin.layouts.master', ['page_slug' => 'faq'])
@section('title', 'Edit Faq')
@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit Faq') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.faq.index',
                        'label' => 'Back',
                        'permissions' => ['faq-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('cms.faq.update', encrypt($faq->id)) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Question') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $faq->question }}" id="title" name="question"
                                class="form-control" placeholder="Enter question">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'question']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Answer') }} <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $faq->answer }}" id="title" name="answer"
                                class="form-control" placeholder="Enter answer">
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'answer']" />
                        </div>
                        <div class="form-group">
                            <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                            <select name="type" class="form-control">
                                @foreach (App\Models\Faq::getTypeLabels() as $key => $value)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'type']" />
                        </div>

                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
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
