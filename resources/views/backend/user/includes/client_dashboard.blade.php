<div class="bg-bg-gray dark:bg-opacity-20">
    <div class="flex flex-wrap gap-10 items-center p-10 pt-0">
        {{-- <div class="w-96 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
            <div class="flex items-center gap-3">
                <span><i data-lucide="menu" class="w-10 h-10 bg-bg-gray  dark:bg-opacity-20 rounded-md p-1 "></i></span>
                <span
                    class="text-3xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Reserves') }}</span>
            </div>
            <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                {{ __('3') }}
            </h3>
        </div> --}}
        <a href="#" class="nav_item" data-target="my_containers">
            <div class="w-96 h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="container"
                            class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                    <span
                        class="text-3xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Containers') }}</span>
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                    {{ $my_containers->count() }}
                </h3>
            </div>
        </a>
        <a href="#" class="nav_item" data-target="my_bids">
            <div class="w-96 h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="dollar-sign"
                            class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                    <span
                        class="text-3xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Bids') }}</span>
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-text-danger dark:text-text-white mt-3 ms-2">
                    {{ __('$8,200') }}
                </h3>
            </div>
        </a>
        <a href="#" class="nav_item" data-target="my_inquiries">
            <div class="w-96 h-40 lg:max-w-md shadow-card p-5 lg:p-10 bg-bg-white dark:bg-opacity-30 rounded-lg">
                <div class="flex items-center gap-3">
                    <span><i data-lucide="mail"
                            class="w-10 h-10 bg-bg-gray dark:bg-opacity-20 rounded-md p-1 "></i></span>
                    <span
                        class="text-2xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('My Inquiries') }}</span>
                </div>
                <h3 class="text-xl md:text-3xl font-semibold text-text-primary dark:text-text-white mt-3 ms-2">
                    {{ __('2') }}
                </h3>
            </div>
        </a>
        <a href="#" class="nav_item" data-target="update_profile">
            <div class="w-96 h-40 lg:max-w-md shadow-card p-5  lg:p-10 bg-bg-white dark:bg-opacity-30  rounded-lg">
                <div class="flex items-center gap-3">
                    <span
                        class="text-3xl font-semibold uppercase text-text-primary dark:text-text-white">{{ __('Update Profile') }}</span>
                </div>
            </div>
        </a>
    </div>
</div>
