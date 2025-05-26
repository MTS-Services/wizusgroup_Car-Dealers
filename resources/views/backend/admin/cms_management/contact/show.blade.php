@extends('backend.admin.layouts.master', ['page_slug' => 'contact'])
@section('title', 'Contact Details')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __('Contact Details') }}</h4>
                    <x-backend.admin.button :datas="[
                        'routeName' => 'cms.contact.index',
                        'label' => 'Back',
                        'permissions' => ['contact-create'],
                    ]" />
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <td>{{ $contact->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Email') }}</th>
                            <td>{{ $contact->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Status') }}</th>
                            <td>
                                <span class="badge bg-{{ $contact->status_color ?? 'secondary' }}">
                                    {{ $contact->status_label ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('Message') }}</th>
                            <td>{{ $contact->message ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Opened By') }}</th>
                            <td>{{ $contact->open_by ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection