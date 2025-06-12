<div class="">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 items-center p-10 pt-0">
        <a href="{{ route('user.profile', ['slug' => 'orders']) }}" class="nav_item" data-target="my_orders">
            <div
                class="w-full h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg group hover:bg-bg-light transition-all duration-300">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="shopping-cart"
                            class="w-10 h-10 bg-bg-gray  dark:bg-opacity-20 rounded-md p-1  group-hover:text-text-tertiary transition-all duration-300"></i></span>
                    <span
                        class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('My Orders') }}</span>
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                    {{ number_format($total_orders) }}
                </h3>
            </div>
        </a>
        <a href="{{ route('user.profile', ['slug' => 'containers']) }}" class="nav_item" data-target="my_containers">
            <div
                class="w-full h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg group hover:bg-bg-light transition-all duration-300">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="container"
                            class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1  group-hover:text-text-tertiary transition-all duration-300"></i></span>
                    <span
                        class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('My Containers') }}</span>
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                    {{ number_format($total_containers) }}
                </h3>
            </div>
        </a>
        @if (isset($not_use))
            {{-- <a href="#" class="nav_item" data-target="my_bids">
                <div
                    class="w-full h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg group hover:bg-bg-light transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <span><i data-lucide="dollar-sign"
                                class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1  group-hover:text-text-tertiary transition-all duration-300"></i></span>
                        <span
                            class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('My Bids') }}</span>
                    </div>
                    <h3 class="text-xl md:text-3xl font-semibold mt-3 ms-2">
                        {{ $auctions->count() ?? '0' }}
                    </h3>
                </div>
            </a>
            <a href="#" class="nav_item" data-target="my_inquiries">
                <div
                    class="w-full h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg group hover:bg-bg-light transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <span><i data-lucide="info"
                                class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 group-hover:text-text-tertiary transition-all duration-300"></i></span>
                        <span
                            class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('My Inquiries') }}</span>
                    </div>
                    <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                        {{ __('2') }}
                    </h3>
                </div>
            </a> --}}
        @endif
        <a href="{{ route('user.profile', ['slug' => 'profile']) }}" class="nav_item" data-target="update_profile">
            <div
                class="w-full h-40 lg:max-w-md shadow-card p-5  lg:p-10 bg-bg-white dark:bg-opacity-30  rounded-lg group hover:bg-bg-light transition-all duration-300">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="user"
                            class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 group-hover:text-text-tertiary transition-all duration-300"></i></span>
                    <span
                        class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('Update Profile') }}</span>
                </div>
            </div>
        </a>
        <div
            class="w-full h-40 lg:max-w-md shadow-card p-5  lg:p-10 bg-bg-white dark:bg-opacity-30  rounded-lg group hover:bg-bg-light transition-all duration-300">
            <a href="javascript:void(0)" onclick="document.getElementById('user_logout_form').submit()"
                class="flex items-center gap-2 p-3"><i data-lucide="log-out"
                    class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 group-hover:text-text-tertiary transition-all duration-300"></i><span
                    class="text-xl md:text-2xl font-semibold uppercase text-text-primary dark:text-text-white group-hover:text-text-tertiary transition-all duration-300">{{ __('Logout') }}</span>
            </a>
            <form action="{{ route('logout') }}" id="user_logout_form" method="POST">
                @csrf
            </form>
        </div>
    </div>
</div>
