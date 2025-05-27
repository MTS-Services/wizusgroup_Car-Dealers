<footer class="bg-bg-light dark:bg-bg-dark-secondary pt-10 pb-5 ">
    <div class="container">
        <div class="flex flex-wrap space-y-5 xl:space-y-0">
            <div class="basis-full xl:basis-[45%] xl:pr-10">
                <div class="flex flex-wrap space-y-5 lg:space-y-0 xl:space-y-5">
                    <a href="#" class="basis-full lg:basis-[30%] xl:basis-full text-center">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="logo" class="w-48 mx-auto lg:ml-0">
                    </a>
                    <p class="basis-full lg:basis-[70%] xl:basis-full text-center md:text-start">
                        {{ __('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nisi, eveniet saepe delectus iste exercitationem, aspernatur suscipit eligendi iusto earum architecto nam maiores est ad modi quaerat illum rem voluptatibus eum.') }}
                    </p>
                </div>
            </div>
            <div class="basis-full xl:basis-[55%]">
                <div class="flex flex-wrap space-y-5 md:space-y-0">
                    <div class="w-full md:w-4/6">
                        <div class="flex items-start">
                            <div class="basis-1/2">
                                <h4>{{ __('Services') }}</h4>
                                <div class="flex flex-col pl-3 gap-1">
                                    <a href="{{ route('frontend.auctions') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm group/service group/service w-fit">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/service:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="gavel" class="w-4 text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Auctions') }}
                                    </a>
                                    <a href="{{ route('frontend.dropshipping') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm group/service group/service w-fit">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/service:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="handshake" class="w-4 text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Special Deals') }}
                                    </a>
                                    <a href="{{ route('frontend.parts-accessories') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm group/service group/service w-fit">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/service:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="cog" class="w-4 text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Parts & Accessories') }}
                                    </a>
                                    <a href="{{ route('frontend.group_shipping') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm group/service group/service w-fit">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/service:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="truck" class="w-4 text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Shipping') }}
                                    </a>
                                </div>
                            </div>
                            <div class="basis-1/2">
                                <h4>{{ __('Quick Links') }}</h4>
                                <div class="flex flex-col pt-3 pl-3 gap-1">
                                    <a href="{{ url('/') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm w-fit group/link">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/link:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="home" class="w-[14px] text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Home') }}
                                    </a>
                                    <a href="{{ route('frontend.about') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm w-fit group/link">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/link:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="info" class="w-[14px] text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('About Us') }}
                                    </a>
                                    <a href="{{ route('frontend.regions') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm w-fit group/link">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/link:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="earth" class="w-[14px] text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Regions') }}
                                    </a>
                                    <a href="{{ route('frontend.contact') }}"
                                        class="text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear flex items-center justify-start gap-2 text-sm w-fit group/link">
                                        <div>
                                            <span
                                                class="w-6 h-6 flex items-center justify-center bg-bg-primary group-hover/link:bg-bg-tertiary rounded-full transition-all duration-300 ease-linear">
                                                <i data-lucide="square-user-round" class="w-[14px] text-text-white"></i>
                                            </span>
                                        </div>
                                        {{ __('Contact') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-2/6">
                        <div class="basis-full">
                            <h4>{{ __('Contact') }}</h4>
                            <div class="flex flex-col pt-3 pl-3 gap-1">
                                <div class="flex items-start justify-start gap-2 text-sm">
                                    <div>
                                        <span
                                            class="w-6 h-6 flex items-center justify-center bg-bg-primary rounded-full">
                                            <i data-lucide="map-pin" class="w-4 text-text-white"></i>
                                        </span>
                                    </div>
                                    <a href="https://www.google.com/maps" target="_blank"
                                        class="w-auto break-all text-wrap text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary transition-all duration-300 ease-linear">
                                        {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit.') }}
                                    </a>
                                </div>

                                <div class="flex items-start justify-start gap-2 text-sm">
                                    <div>
                                        <span
                                            class="w-6 h-6 flex items-center justify-center bg-bg-primary rounded-full">
                                            <i data-lucide="mail" class="w-4 text-text-white"></i>
                                        </span>
                                    </div>
                                    <a href="mailto:example@example.com" target="_blank"
                                        class="w-auto break-all !text-wrap text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary transition-all duration-300 ease-linear">
                                        {{ __('example@example.com') }}
                                    </a>
                                </div>
                                <div class="flex items-start justify-start gap-2 text-sm">
                                    <div>
                                        <span
                                            class="w-6 h-6 flex items-center justify-center bg-bg-primary rounded-full">
                                            <i data-lucide="phone" class="w-4 text-text-white"></i>
                                        </span>
                                    </div>
                                    <a href="tel:000-000-000" target="_blank"
                                        class="w-auto break-all text-wrap text-text-primary dark:text-text-light hover:text-text-tertiary dark:hover:text-text-tertiary transition-all duration-300 ease-linear">
                                        {{ __('000-000-000') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="basis-full">
                <div class="flex flex-wrap space-y-5 sm:space-y-0 md:space-y-5 justify-center">

                    <div class="basis-full sm:basis-1/2 text-center">
                        <h4>{{ __('Follow Us') }}</h4>
                        <div class="flex items-center justify-center gap-2 pt-3 pl-3">
                            <a href="https://www.facebook.com/" target="_blank" title="Facebook"
                                class="w-8 h-8 flex items-center justify-center bg-bg-primary rounded-full hover:bg-bg-tertiary transition-all duration-300 ease-linear">
                                <i data-lucide="facebook" class="w-4 text-text-white"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" title="Facebook"
                                class="w-8 h-8 flex items-center justify-center bg-bg-primary rounded-full hover:bg-bg-tertiary transition-all duration-300 ease-linear">
                                <i data-lucide="instagram" class="w-4 text-text-white"></i>
                            </a>
                            <a href="https://www.x.com/" target="_blank" title="Facebook"
                                class="w-8 h-8 flex items-center justify-center bg-bg-primary rounded-full hover:bg-bg-tertiary transition-all duration-300 ease-linear">
                                <i data-lucide="twitter" class="w-4 text-text-white"></i>
                            </a>
                            <a href="https://www.youtube.com/" target="_blank" title="Facebook"
                                class="w-8 h-8 flex items-center justify-center bg-bg-primary rounded-full hover:bg-bg-tertiary transition-all duration-300 ease-linear">
                                <i data-lucide="youtube" class="w-4 text-text-white"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="divider mx-5 mt-10"></div>
    <div class="container">
        <div class="flex flex-wrap justify-center">
            <p class="text-sm text-text-primary dark:text-text-light">{{ __('Copyright') }} &copy;
                {{ date('Y') }}
                {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <p class="text-sm text-text-primary dark:text-text-light ml-2">{{ __('Design and Developed by') }}
                <a href="https://maktechsolution.com/" target="_blank"
                    class="text-text-tertiary hover:text-text-tertiary dark:hover:text-text-tertiary transition-all duration-300 ease-linear">{{ __('MTS Solutions') }}</a>
            </p>
        </div>
    </div>

    <div
        class="fixed z-50 bottom-6 right-6 md:bottom-10 md:right-10 shadow-lg rounded-full bg-gradient-primary flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16">
        <a href="#" aria-label="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp text-2xl sm:text-3xl md:text-4xl lg:text-5xl text-text-light"></i>
        </a>
    </div>

</footer>
