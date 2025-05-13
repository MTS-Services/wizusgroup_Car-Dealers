<footer>
    <div class="container">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div>
                <a href="{{ url('/') }}" class="w-28 inline-block mb-2">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" class="w-full">
                </a>
                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">Quick Links</h4>
                <ul>
                    <li>
                        <a class="px-3 py-1 rounded-md hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                            href="{{ url('/') }}">{{ __('Home') }}</a>
                    </li>
                    <li>
                        <a class="px-3 py-1 rounded-md hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                            href="{{ url('/') }}">{{ __('About Us') }}</a>
                    </li>
                    <li>
                        <a class="px-3 py-1 rounded-md hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                            href="{{ url('/') }}">{{ __('Products') }}</a>
                    </li>
                    <li>
                        <a class="px-3 py-1 rounded-md hover:text-text-tertiary dark:hover:text-text-tertiary font-medium capitalize transition-all duration-300 ease-linear"
                            href="{{ url('/') }}">{{ __('Auctions') }}</a>
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">About Us</h4>
                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">About Us</h4>
                <p class="text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quidem.</p>
            </div>
        </div>
    </div>
    <div class="py-3 bg-bg-primary text-text-light">
        <p class="text-center">All rights reserved| &copy; {{ date('Y') }}</p>
    </div>
</footer>
