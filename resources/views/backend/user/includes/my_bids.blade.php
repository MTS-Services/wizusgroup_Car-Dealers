<h2 class="font-semibold text-xl lg:text-2xl">{{ __('Auction Running List') }}</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    {{-- @dd($user->auctionBids) --}}
    @foreach ($auctions as $auction)
        <div class="flex flex-col">
            <div class="flex flex-col bg-bg-white dark:bg-bg-dark-tertiary rounded-md shadow overflow-hidden min-h-96">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold mb-0">{{ $auction?->title }}</h3>
                        <span
                            class="px-2 py-1 text-text-white bg-bg-{{ $auction?->status == '2' ? 'wiz_green' : 'wiz_orange' }} rounded-full text-sm font-medium">
                            {{ $auction?->status_label }}
                        </span>
                    </div>
                </div>
                <div class="p-4 space-y-3 flex-grow flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center text-text-gray dark:text-text-light">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span class="text-base">{{ __('Start Date: ') }}{{ $auction?->start_date_format }}</span>
                        </div>
                        <div class="flex items-center text-text-gray dark:text-text-light">
                            <i class="far fa-calendar-check mr-2"></i>
                            <span class="text-base">{{ __('End Date:') }} {{ $auction?->end_date_format }}</span>
                        </div>
                        <div class="flex items-center text-text-gray dark:text-text-light">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="text-base">{{ __('Location:') }} {{ $auction?->location }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <p class="m-0 text-base">
                                <span class="font-medium">{{ __('Category:') }}</span>
                                <span
                                    class="text-text-gray dark:text-text-light">{{ $auction?->product?->category?->name }}</span>
                            </p>
                        </div>

                        <div class="flex justify-between items-center mt-3 text-base">
                            <p class="m-0">
                                <span class="font-medium">{{ __('Bid Price:') }}</span>
                                <span
                                    class="text-text-wiz_orange font-medium">${{ number_format($auction?->start_price) }}</span>
                            </p>
                            <span class="bg-bg-wiz_green text-white rounded-full px-3 py-1 text-sm">
                                <i class="far fa-user mr-1"></i>
                                {{ number_format($auction?->auction_bids_count) }} bid
                            </span>
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-base">{{ __('My Bid:') }}</span>
                                <p class="text-text-wiz_orange font-medium text-base m-0">
                                    ${{ number_format($auction?->auctionBids?->last()?->bid_amount) }}</p>
                            </div>
                            <a href="{{ route('user.auction.details', $auction?->slug) }}"
                                class="text-text-wiz_green text-base font-medium underline">
                                {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="btn-primary w-full rounded-md py-2">
                            <i class="far fa-clock mr-2"></i>
                            <span class="text-lg">10d : 08h : 30m : 20s</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@if ($auctions->count() == 0)
    <div class="mt-5">
        <h2 class="text-xl font-semibold text-text-primary dark:text-text-light text-center uppercase bg-bg-white rounded-lg p-5 shadow-card">{{ __('No Data Found') }}</h2>
    </div>
@endif
