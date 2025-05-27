@extends('frontend.layouts.app', ['page_slug' => 'my-bids'])
@section('title', 'My Bids')

@section('content')
    <section class="py-10">
        <div class="container">
            <div class="bg-white dark:bg-bg-dark-tertiary shadow rounded-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-xl font-semibold mb-0">{{ __('Auciton Details')}}</h4>
                    <a href="{{ route('user.profile') }}"
                        class="btn-primary py-2 bg-bg-primary rounded-md hover:bg-bg-tertiary">
                        {{ __('Back') }}
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border dark:border-border-gray dark:border-opacity-20 text-left text-sm">
                        <tbody class="divide-y dark:divide-border-gray dark:divide-opacity-20">
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">{{ __('Title') }}</th>
                                <td class="px-4 py-3">{{ $auction?->title }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">{{ __('Status') }}</th>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-white text-xs font-semibold bg-bg-{{ $auction?->status=='2' ? 'wiz_green' : 'wiz_orange' }} ">
                                        {{ $auction->status_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">Location</th>
                                <td class="px-4 py-3">{{ $auction?->location }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">{{ __('Category') }}</th>
                                <td class="px-4 py-3">{{ $auction?->product?->category?->name}}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">Start Price</th>
                                <td class="px-4 py-3">{{ $auction?->start_price }}</td>
                            </tr>
                            {{-- <tr class="bor border-border-gray dark:border-opacity-20der-b">
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">Reserve Price</th>
                                <td class="px-4 py-3">{{ $auction->reserve_price }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">Buy Now Price</th>
                                <td class="px-4 py-3">{{ $auction->buy_now_price }}</td>
                            </tr> --}}
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">Start Date</th>
                                <td class="px-4 py-3">{{ $auction?->start_date_format }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 bg-bg-gray dark:bg-bg-dark dark:text-text-white text-text-gray font-medium ">End Date</th>
                                <td class="px-4 py-3">{{ $auction?->end_date_format }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
