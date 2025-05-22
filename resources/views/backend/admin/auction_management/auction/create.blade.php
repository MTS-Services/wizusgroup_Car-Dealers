@extends('backend.admin.layouts.master', ['page_slug' => 'auction'])
@section('title', 'Create Auction')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Auction') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'auction-m.auction.index',
                        'label' => 'Back',
                        'permissions' => ['auction-list'],
                    ]" />
                </div>
                <div class="card-body">
                    <form action="{{ route('auction-m.auction.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('title') }}" id="title" name="title"
                                        class="form-control" placeholder="Enter title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'title']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Slug') }} <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('slug') }}" id="slug" name="slug"
                                        class="form-control" placeholder="Enter slug">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'slug']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Select Product') }} <span class="text-danger">*</span></label>
                                    <select name="product_id" class="form-control">
                                        <option value="" selected hidden disabled>{{ __('Select Product') }}</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'product_id']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Status') }} <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        @foreach (App\Models\Auction::getStatusLabels() as $key => $status)
                                            <option value="{{ $key }}"
                                                {{ $key == App\Models\Auction::STATUS_SCHEDULED ? 'selected' : '' }}>
                                                {{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'status']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Starting Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" value="{{ old('start_price') }}" id="start_price"
                                        name="start_price" class="form-control" placeholder="Enter starting price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'start_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Reserve Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" value="{{ old('reserve_price') }}" id="reserve_price"
                                        name="reserve_price" class="form-control" placeholder="Enter starting price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'reserve_price']" />
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Buy Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" value="{{ old('buy_now_price') }}" id="buy_now_price"
                                        name="buy_now_price" class="form-control" placeholder="Enter starting price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'buy_now_price']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Increment amount') }} <span class="text-danger">*</span></label>
                                    <input type="number" value="{{ old('increment_amount') }}" id="increment_amount"
                                        name="increment_amount" class="form-control" placeholder="Enter starting price">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'increment_amount']" />
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Start Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" value="{{ old('start_date') }}" id="start_date" name="start_date"
                                        class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'start_date']" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('End Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" value="{{ old('end_date') }}" id="end_date" name="end_date"
                                        class="form-control">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'end_date']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'description']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta title') }}</label>
                                    <input type="text" class="form-control" value="{{ old('meta_title') }}"
                                        name="meta_title">
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_title']" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('Meta description') }}</label>
                                    <textarea rows="6" name="meta_description" id="meta_description" class="form-control no-ckeditor5">{{ old('meta_description') }}</textarea>
                                    <x-feed-back-alert :datas="['errors' => $errors, 'field' => 'meta_description']" />
                                </div>
                            </div>
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
@endpush
