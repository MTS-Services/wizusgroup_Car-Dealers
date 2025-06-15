<dialog id="my_modal_1" class="modal backdrop:backdrop-blur-sm">
    <div
        class="modal-box max-w-3xl p-0 overflow-hidden rounded-xl shadow-2xl bg-bg-light dark:bg-bg-dark transition-colors duration-300">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 pb-2">
            <h3 class="text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Welcome Back!') }}
            </h3>
            <form method="dialog">
                <button class="btn btn-ghost btn-circle">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        <div class="divider m-0 mx-5"></div>

        <!-- Content -->
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2 p-6">
            <!-- User Option -->
            <div class="group">
                <a href="{{ route('login') }}"
                    class="w-full h-full p-6 rounded-lg border border-border-black/10 dark:border-border-white/10 shadow-sm bg-bg-secondary/50 dark:bg-bg-dark-tertiary/50 transition-all duration-300 flex flex-col items-center justify-center group-hover:shadow-md">
                    <div
                        class="mb-4 p-3 rounded-full bg-bg-primary/10 dark:bg-bg-dark group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="user-check"
                            class="w-10 h-10 text-text-primary dark:text-text-light group-hover:text-text-tertiary transition-all duration-300 ease-linear"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-light mb-2">
                        {{ __('Continue as Customer') }}
                    </h4>
                    <p class="text-text-primary/70 dark:text-text-light/70 text-sm text-center">
                        {{ __('Access your personal account and dashboard') }}
                    </p>
                </a>
            </div>

            <!-- Admin Option -->
            <div class="group">
                <a href="{{ route('admin.login') }}"
                    class="w-full h-full p-6 rounded-lg border border-border-black/10 dark:border-border-white/10 shadow-sm bg-bg-secondary dark:bg-bg-dark-tertiary transition-all duration-300 flex flex-col items-center justify-center group-hover:shadow-md">
                    <div
                        class="mb-4 p-3 rounded-full bg-bg-primary/10 dark:bg-bg-dark group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="user-cog"
                            class="w-10 h-10 text-text-primary dark:text-text-light group-hover:text-text-tertiary transition-all duration-300 ease-linear"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-light mb-2">
                        {{ __('Continue as Admin') }}
                    </h4>
                    <p class="text-text-primary/70 dark:text-text-light/70 text-sm text-center">
                        {{ __('Access the admin panel and tools') }}
                    </p>
                </a>
            </div>
        </div>

    </div>
</dialog>
