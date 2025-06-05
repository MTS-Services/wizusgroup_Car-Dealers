@props(['auction'])

{{-- {{$auction->product->subCategory->name}}
@dd($auction->product->subCategory->name) --}}

<div class="product-card bg-bg-light dark:bg-bg-dark-tertiary  w-full hover:translate-y-[-8px] hover:shadow-lg dark:hover:shadow-dark-card transition-all duration-300 ease-in-out group shadow-card rounded-lg overflow-hidden flex flex-col"
    data-product="1">
    <!-- Car Image -->
    <div class="relative">
        <a href="{{ route('frontend.auction-details', $auction->slug) }}" class="w-full block h-60 overflow-hidden">
            <img src="{{ storage_url($auction->product?->primaryImage->first()?->image) }}"
                alt="{{ $auction->product?->primaryImage->first()?->alt ?? ($auction->product?->name ?? $auction->title) }}"
                class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">
        </a>
        <!-- Timer Badge -->
        <div class="absolute z-50 bottom-[-10px] left-3 bg-bg-orange text-text-white px-3 py-1 rounded-md text-sm font-medium"
            id="timer-{{ $auction->id }}" data-endDate="{{ $auction->end_date }}"></div>
    </div>

    <!-- Card Content -->
    <div class="p-4 relative @auth('web') min-h-60 @else min-h-52 @endauth flex-grow flex flex-col justify-between">
        <a href="{{ route('frontend.auction-details', $auction->slug) }}"
            class="text-base lg:text-lg font-semibold text-text-primary dark:text-text-light">
            {{ $auction->title }}</a>
        <div>
            @auth('web')
                <p class="text-text-danger text-base lg:text-lg font-bold mt-1">{{ __("$") }}
                    {{ $auction->start_price }}
                </p>
            @endauth
            <div class="flex items-center mt-3 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
                {{ $auction->product?->subCategory?->name ?? __('No Category') }}
            </div>
            <div class="flex items-center mt-2 text-text-dark dark:text-text-light text-opacity-50 text-sm">
                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg> --}}
                <i data-lucide="map-pin" class="w-4 h-4 mr-1"></i>
                {{ $auction->location }}
            </div>
            
            <!-- Bid Button -->
            @auth('web')
            <button onclick="document.getElementById('{{ $auction->id }}-modal').showModal()"
                class="w-full btn-primary rounded-md border border-border-tertiary bg-bg-tertiary text-text-white hover:text-text-tertiary hover:bg-transparent px-4  mt-4">
                {{ __('Place a Bid') }}
            </button>
            @else
            <a href="{{ route('frontend.auction-details', $auction->slug) }}" class="w-full btn-primary rounded-md border border-border-tertiary bg-bg-tertiary text-text-white dark:text-text-light hover:text-text-tertiary hover:bg-transparent px-4  mt-4">
                {{ __('Ask for price') }}
            </a>
            @endauth
        </div>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            document.getElementById('{{ $auction->id }}-modal').showModal();
        @endif
    });
</script> --}}

<dialog id="{{ $auction->id }}-modal" class="modal">
    <div class="modal-box bg-bg-light dark:bg-bg-dark-tertiary p-6 rounded-lg w-full max-w-sm shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">{{ __('Place Your Bid') }}</h2>
            <form method="dialog">
                <button onclick="closeModal()"
                    class="text-text-primary hover:text-text-tertiary text-2xl dark:text-text-light btn btn-sm btn-circle btn-ghost"><i
                        data-lucide="x" class="w-4 h-4"></i></button>
            </form>
        </div>
        <form id="place-bid-form-{{ $auction->id }}" method="post">
            @csrf
            <div class="space-y-2 pb-3">
                <label
                    class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __('Your Whatsapp Number') }}</label>
                <input type="number" name="whatsapp_number"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bg-primary"
                    placeholder="Enter your whatsapp number" />
                <p class="text-red-500 text-sm mt-1" id="whatsapp_number_error_{{ $auction->id }}"></p>
                <label
                    class="block text-sm font-medium text-text-primary dark:text-text-light text-opacity-50">{{ __('Your Bid (USD)') }}</label>
                <input type="number" name="bid_amount"
                    class="w-full mt-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-bg-primary"
                    placeholder="Enter your bid" />
                <p class="text-red-500 text-sm mt-1" id="bid_amount_error_{{ $auction->id }}"></p>
            </div>

            <button class="w-full btn-primary py-2 rounded-md hover:bg-bg-tertiary transition">
                {{ __('Submit Bid') }}
            </button>
        </form>
    </div>
</dialog>

<script>
    (function() {
        const placeBidForm = document.getElementById(`place-bid-form-{{ $auction->id }}`);

        placeBidForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const route = "{{ route('user.auction.bid-place', ['slug']) }}";
            const url = route.replace('slug', "{{ $auction->slug }}");


            axios.post(url, formData)
                .then(response => {
                    // Close Modal
                    const modal = document.getElementById('{{ $auction->id }}-modal');
                    modal.close()

                    // Clear Everything
                    document.getElementById('whatsapp_number_error_{{ $auction->id }}').textContent =
                        '';
                    document.getElementById('bid_amount_error_{{ $auction->id }}').textContent = '';
                    document.getElementById('place-bid-form-{{ $auction->id }}').reset();

                    toastr.success('Bid Placed Successfully');
                    // console.log(response.data);

                })
                .catch(error => {
                    // Clear existing errors
                    document.getElementById('whatsapp_number_error_{{ $auction->id }}').textContent =
                        '';
                    document.getElementById('bid_amount_error_{{ $auction->id }}').textContent = '';

                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;

                        if (errors.whatsapp_number) {
                            document.getElementById('whatsapp_number_error_{{ $auction->id }}')
                                .textContent = errors.whatsapp_number[0];
                        }

                        if (errors.bid_amount) {
                            document.getElementById('bid_amount_error_{{ $auction->id }}')
                                .textContent = errors.bid_amount[0];
                        }
                    } else {
                        toastr.error('Something went wrong');
                        console.error(error);
                    }
                });
        });
    })();
</script>


{{-- Countdown Timer --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timer = document.getElementById('timer-{{ $auction->id }}');
        const endDate = moment(timer.dataset.enddate); // Read from data-enddate

        function updateCountdown() {
            const now = moment();
            const duration = moment.duration(endDate.diff(now));

            if (duration.asSeconds() <= 0) {
                timer.innerText = 'Auction Ended';
                clearInterval(interval);
                return;
            }

            const days = Math.floor(duration.asDays());
            const hours = duration.hours();
            const minutes = duration.minutes();
            const seconds = duration.seconds();

            timer.innerText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown(); // Initial call
        const interval = setInterval(updateCountdown, 1000);
    });
</script>
