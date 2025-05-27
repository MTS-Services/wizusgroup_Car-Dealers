@extends('backend.admin.layouts.master', ['page_slug' => 'auction'])

@section('title', $auction->title)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="product_tabs col-lg-12">
                <div class="d-flex justify-content-around align-items-center gap-5 py-5 text-center">
                    <p class="btn_item w-100 py-2 m-0 active" data-bs-target="auctions">{{ __('Auctions Details') }}</p>
                    <p class="btn_item w-100 py-2 m-0" data-bs-target="auction_bits">{{ __('Auction Bids History') }}</p>
                    <p class="btn_item w-100 py-2 m-0" data-bs-target="auctions_watchers">{{ __('Auctions Watchers') }}</p>
                    <div class="ms-5">
                        <a href="{{ route('auction-m.auction.index') }}" class="btn_item p-2">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div id="auctions" class="tab-pane active">
                            <div class="mb-5">
                                <div class="card shadow rounded-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h4 class="card-title mb-0">{{ $auction->title }}</h4>
                                            <a href="{{ route('pm.product.show', encrypt($auction->product_id)) }}"
                                                class="btn btn-primary">{{ __('Product Details') }}</a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th class="w-25">Slug</th>
                                                        <td>{{ $auction->slug }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Start Price</th>
                                                        <td>{{ $auction->start_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>End Price</th>
                                                        <td>{{ $auction->end_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Reserve Price</th>
                                                        <td>{{ $auction->reserve_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Buy Now Price</th>
                                                        <td>{{ $auction->buy_now_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Start Date</th>
                                                        <td>{{ $auction->start_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>End Date</th>
                                                        <td>{{ $auction->end_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Status') }}</th>
                                                        <td><span
                                                                class="badge {{ $auction->status_color }}">{{ $auction->status_label }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Location</th>
                                                        <td>{{ $auction->location }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Meta Title</th>
                                                        <td>{{ $auction->mete_title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td>{!! $auction->description !!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Auction Bids History --}}
                        <div id="auction_bits" class="tab-pane">
                            <div class="mb-5">
                                <div class="card shadow rounded-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">{{ $auction->title }}</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th class="w-25">Bid Amount</th>
                                                        <td>{{ number_format($auction->auctionBids?->last()?->bid_amount, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Winning</th>
                                                        <td>{{ number_format($auction->auctionBids?->last()?->is_winning, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Buy Now</th>
                                                        <td>{{ number_format($auction->auctionBids?->last()?->is_buy_now, 2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- Auctions Watchers --}}
                        <div id="auctions_watchers" class="tab-pane">
                            <div class="mb-5">
                                <div class="card shadow rounded-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">{{ __('Auctions Watchers') }}</h4>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped align-middle">
                                                <tbody>
                                                    <tr>
                                                        <th class="w-25">{{ __('Name') }}</th>
                                                        <td>{{ $auction->auctionWatchers?->last()?->user->full_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Email') }}</th>
                                                        <td>{{ $auction->auctionWatchers?->last()?->user->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{ __('Watcher Date') }}</th>
                                                        <td>{{ $auction->auctionWatchers?->last()?->created_at }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // Handle click on tab items
            $('.btn_item').on('click', function() {
                $('.btn_item').removeClass('active');
                $(this).addClass('active');
                const target = $(this).data('bs-target');
                $('.tab-pane').removeClass('active');

                $('#' + target).addClass('active');
            });
        });
    </script>
@endpush
