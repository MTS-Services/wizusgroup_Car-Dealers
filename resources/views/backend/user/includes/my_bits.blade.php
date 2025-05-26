<section>
    <h2 class="fw-semibold py-3">{{ __('My Bits List') }}</h2>
    <div class="row row-gap-5">
        @foreach ($user as $user_bid)
            <div class="col-md-4">
            <div class="bg-white rounded shadow overflow-hidden">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h4 fw-semibold mb-0">{{ $user_bid->auctions?->title }}</h3>
                        <span class="px-2 py-1 {{ $user_bid->status_color }} text-white rounded-pill small fw-medium">
                            {{ $user_bid->status_label }}
                        </span>
                    </div>
                </div>
                <div class="p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="far fa-calendar-alt text-muted me-2"></i>
                        <span class="lead text-muted">Start Date: {{ $user_bid->start_date_format }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="far fa-calendar-check text-muted me-2"></i>
                        <span class="lead text-muted">End Date: {{ $user_bid->end_date_format }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        <span class="lead text-muted">Location: {{ $user_bid->location }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="m-0"><span class="fw-medium">{{ __('Category:') }}</span> <span
                                class="text-muted">{{ $user_bid->product?->category?->name }}</span></p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 lead">
                        <p class="m-0"><span class="fw-medium">{{ __('Bid Price:') }}</span> <span
                                class="text-wiz_red fw-medium">${{ number_format($user_bid->start_price) }}</span></p>
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="far fa-user me-1"></i>
                            {{ number_format($user_bid->user_bid_bids_count) }} bid
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="lead fw-medium">{{ __('My Bit:') }}</span>
                            <p class="text-wiz_red lead fw-medium m-0">${{ number_format($user_bid->user_bidBids?->last()?->bid_amount ,2) ?? 0.00 }}</p>
                        </div>
                        <a href="{{ route('user_bid-m.user_bid.show', encrypt($user_bid->id)) }}" class="text-success fs-5 fw-medium text-decoration-underline">
                            {{ __('View Details') }}
                        </a>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-center align-items-center bg-wiz_orange text-white rounded py-2">
                            <i class="far fa-clock me-2"></i>
                            <span class="fs-5">10d : 08h : 30m : 20s</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>