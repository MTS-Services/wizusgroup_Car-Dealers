@extends('frontend.layouts.app', ['page_slug' => 'group_shipping'])

@section('title', 'Group Shipping')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    {{-- Group Shipping steps start --}}
    <section class="py-24 bg-bg-primary/20 dark:bg-bg-dark">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="header text-center pb-8 md:pb-12">
                <h1
                    class="text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl font-semibold text-text-black/70 dark:text-text-light">
                    {{ __('Simple, Fast, and Secure Process') }}
                </h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6">
                <!-- Step 1 -->
                <div
                    class="Step bg-white dark:bg-gray-800 p-2 sm:p-3 lg:p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="icons flex gap-3 items-center pb-3">
                        <div class="icon-container flex-shrink-0">
                            <i data-lucide="search"
                                class="w-12 h-12 sm:w-16 sm:h-16 border-2 text-text-black/50 dark:text-text-light border-text-black/50 dark:border-text-light p-3 sm:p-2 lg:p-4 rounded-full"></i>
                        </div>
                        <div class="step xl:pr-4 pr-3">
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Step 1</h3>
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Browse and
                                Reserve</h3>
                        </div>
                    </div>
                    <div class="descriptions">
                        <p class="text-sm sm:text-base text-text-black/50 leading-relaxed dark:text-text-light">
                            Search our inventory or browse by category: Choose your machine and pay a reservation deposit to
                            secure your order.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="Step bg-white dark:bg-gray-800 p-2 sm:p-2 lg:p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="icons flex gap-3 items-center pb-3">
                        <div class="icon-container flex-shrink-0">
                            <i data-lucide="ship"
                                class="w-12 h-12 sm:w-16 sm:h-16 border-2 text-text-black/50 dark:text-text-light border-text-black/50 dark:border-text-light p-3 sm:p-2 lg:p-4 rounded-full"></i>
                        </div>
                        <div class="step xl:pr-4 pr-3">
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Step 2</h3>
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Group Container
                                or Direct Shipping</h3>
                        </div>
                    </div>
                    <div class="descriptions">
                        <p class="text-sm sm:text-base text-text-black/50 leading-relaxed dark:text-text-light">
                            Join a group container for lower shipping costs, or request immediate shipping for a full
                            container.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="Step bg-white dark:bg-gray-800 p-2 sm:p-2 lg:p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="icons flex gap-3 items-center pb-3">
                        <div class="icon-container flex-shrink-0">
                            <i data-lucide="credit-card"
                                class="w-12 h-12 sm:w-16 sm:h-16 border-2 text-text-black/50 dark:text-text-light border-text-black/50 dark:border-text-light p-3 sm:p-2 lg:p-4 rounded-full"></i>
                        </div>
                        <div class="step xl:pr-4 pr-3">
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Step 3</h3>
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Payment and
                                Shipping</h3>
                        </div>
                    </div>
                    <div class="descriptions">
                        <p class="text-sm sm:text-base text-text-black/50 leading-relaxed dark:text-text-light">
                            Pay your final invoice, confirming the shipment. Your machine is shipped to the port, and
                            tracking information is provided.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div
                    class="Step bg-white dark:bg-gray-800 p-2 sm:p-2 lg:p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="icons flex gap-3 items-center pb-3">
                        <div class="icon-container flex-shrink-0">
                            <i data-lucide="map-pin"
                                class="w-12 h-12 sm:w-16 sm:h-16 border-2 text-text-black/50 dark:text-text-light border-text-black/50 dark:border-text-light p-3 sm:p-2 lg:p-4 rounded-full"></i>
                        </div>
                        <div class="step xl:pr-4 pr-3">
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Step 4</h3>
                            <h3
                                class="text-lg sm:text-xl md:text-2xl font-semibold text-text-secondary dark:text-text-white/80">
                                Receive at
                                African Port</h3>
                        </div>
                    </div>
                    <div class="descriptions">
                        <p class="text-sm sm:text-base text-text-black/50 leading-relaxed dark:text-text-light">
                            Pick up your machine at the port with all necessary customs documents prepared.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Group Shipping steps end --}}
    {{-- Faq section start --}}
    <section class="faq-section">
        <div class="container mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h4 class="text-text-secondary dark:text-text-white text-xl mb-4 uppercase tracking-wider">
                    {{ __('Navigate Your Queries') }}</h4>
                <h2
                    class="text-text-secondary dark:text-text-white font-black font-Jakarta text-3xl md:text-4xl xl:text-5xl">
                    {{ __('Explore Answers to Common Questions') }}
                </h2>
            </div>

            <div class="space-y-3  mx-auto" id="faq-container">
                <!-- FAQ Item 1 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('What Shipping Options Do You Offer?') }}
                        </h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('We offer standard, expedited, and next-day shipping through trusted carriers like FedEx, UPS, and USPS. During checkout, you\'ll be able to choose the option that best fits your timeline and budget.') }}
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('Do You Ship Internationally?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('Yes, we ship to most countries worldwide. International shipping rates and delivery times vary depending on your location and the shipping method selected at checkout.') }}
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('How Long Will My Order Take to Arrive?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('Domestic orders typically arrive within 3–7 business days, while international deliveries can take 7–21 business days depending on customs and local postal services. We’ll provide a tracking number once your order ships.') }}
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('How Can I Track My Order?') }}
                        </h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('Once your order ships, you\'ll receive an email with a tracking link. You can also log in to your account on our website and view your tracking details in the Order History section.') }}
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('What Happens If My Package Is Lost or Delayed?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('If your package is delayed or appears lost, please contact our support team. We’ll work with the shipping carrier to locate your package or arrange a replacement or refund, depending on the situation.') }}
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div
                    class="faq-item bg-bg-light dark:bg-bg-tertiary/30 p-6 rounded-xl shadow-md transition-all duration-300 border border-border-gray">
                    <div class="faq-question flex justify-between items-center cursor-pointer" onclick="toggleFaq(this)">
                        <h3 class="text-lg md:text-xl font-bold text-text-secondary dark:text-text-white">
                            {{ __('Do You Offer Free Shipping?') }}</h3>
                        <i
                            class="fa-solid fa-plus text-text-secondary dark:text-text-black transition-transform duration-300"></i>
                    </div>
                    <div
                        class="faq-answer max-h-0 overflow-hidden transition-all duration-500 text-text-primary dark:text-text-white text-sm md:text-base mt-4 text-opacity-80">
                        {{ __('Yes, we offer free standard shipping on all domestic orders over $100. Promotions and free shipping thresholds may vary during special sales events.') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- end faq --}}
@endsection
@push('js')
    <script>
        function toggleFaq(element) {
            const parent = element.closest('.faq-item');
            const answer = parent.querySelector('.faq-answer');
            const icon = element.querySelector('i');

            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            // Close all answers
            document.querySelectorAll('.faq-answer').forEach(a => {
                a.style.maxHeight = '0px';
            });

            // Reset all icons to plus
            document.querySelectorAll('.faq-question i').forEach(i => {
                i.classList.remove('fa-minus');
                i.classList.add('fa-plus');
            });

            // If not already open, open this one and switch icon
            if (!isOpen) {
                answer.style.maxHeight = answer.scrollHeight + "px";
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        }
    </script>
    {{-- <script>
        $(document).ready(function() {
            const $faqItems = $('.faq-item');

            $faqItems.each(function(index) {
                const $item = $(this);
                const $button = $item.find('.faq-question');
                const $answer = $item.find('.faq-answer');
                const $faqIcon = $item.find('.faq-icon');

                $button.on('click', function() {
                    $faqItems.each(function(otherIndex) {
                        const $otherItem = $(this);
                        const $otherAnswer = $otherItem.find('.faq-answer');
                        const $otherFaqIcon = $otherItem.find('.faq-icon');

                        if (otherIndex !== index) {
                            $otherAnswer.css('max-height', '');
                            $otherItem.removeClass('pb-5');
                            $otherFaqIcon.removeClass('fa-minus text-t-primary').addClass(
                                'fa-plus');
                        }
                    });

                    if ($answer.css('max-height') !== '0px' && $answer.css('max-height') !==
                        'none') {
                        // Collapse
                        $answer.css('max-height', '');
                        $item.removeClass('pb-5');
                        $faqIcon.removeClass('fa-minus text-t-primary').addClass('fa-plus');
                    } else {
                        // Expand
                        $answer.css('max-height', $answer.prop('scrollHeight') + 20 + 'px');
                        $item.addClass('pb-5');
                        $faqIcon.removeClass('fa-plus').addClass('fa-minus text-t-primary');
                    }
                });
            });

            // Expand the first FAQ item on load
            const $firstItem = $faqItems.first();
            const $firstAnswer = $firstItem.find('.faq-answer');
            const $firstFaqIcon = $firstItem.find('.faq-icon');

            $firstAnswer.css('max-height', $firstAnswer.prop('scrollHeight') + 20 + 'px');
            $firstItem.addClass('pb-5');
            $firstFaqIcon.removeClass('fa-plus').addClass('fa-minus text-t-primary');
        });
    </script> --}}
@endpush
