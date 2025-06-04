@props(['isLong', 'shortQuote', 'testimonial'])
<div
    class="bg-bg-light dark:bg-bg-dark rounded-xl shadow-card dark:shadow-dark-card overflow-hidden min-h-72 lg:min-h-80 flex flex-col justify-between gap-3">

    <!-- Top Gradient Bar -->
    <div>
        <div
            class="h-1 w-full bg-gradient-to-r from-text-secondary to-text-tertiary dark:from-text-light dark:to-text-light">
        </div>
        <!-- Testimonial Content -->
        <div class="p-6 pb-0 md:p-8 md:pb-0">
            <div class="text-text-secondary dark:text-text-light text-6xl font-serif leading-none">“</div>
            <!-- Message -->
            <p
                class="text-lg md:text-xl font-light leading-relaxed font-montserrat text-text-primary dark:text-text-dark-secondary text-justify">
                <span class="quote-preview">{{ $shortQuote }}</span>
                @if ($isLong)
                    <span class="quote-full hidden">{{ $testimonial->quote }}</span>
                    <span
                        class="text-blue-600 cursor-pointer read-toggle text-sm items-center">{{ __('Read more') }}<i
                            data-lucide="chevrons-right" class="w-4 h-4 inline-block "></i></span>
                @endif
            </p>
        </div>
    </div>

    <!-- Author Info -->
    <div>
        <div
            class="border-t border-border-gray dark:border-border-dark-secondary flex items-center gap-4 p-4  md:p-6">
            <img src="{{ $testimonial->modified_image }}" alt="{{ $testimonial->author_name }}"
                class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover">

            <div>
                <p class="text-text-secondary dark:text-text-light font-bold text-lg uppercase font-playfair">
                    {{ $testimonial->author_name }}
                </p>
                <p class="text-sm uppercase tracking-wide mt-1 text-text-gray dark:text-text-light">
                    {{ __('Country') }}: {{ $testimonial->author_country }}
                </p>
            </div>
        </div>

        <!-- Bottom Gradient Bar -->
        <div
            class="h-1 w-full bg-gradient-to-r from-text-tertiary to-text-secondary dark:from-text-light dark:to-text-light">
        </div>
    </div>
</div>
