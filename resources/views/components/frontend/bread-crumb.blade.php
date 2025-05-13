<style>
    .bracamb-dot::before {
        content: "";
        height: 6px;
        width: 6px;
        border-radius: 50%;
        background-color: #8752FA;
        display: inline-block;
        margin-right: 3px;
    }
</style>

<div class="bg-bg-lightSecondary dark:bg-bg-darkQuaternary">
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 py-4 text-sm">
        <ul class="flex items-center gap-2 ">
            <li>
                <a href="#" class="text-text-gray hover:text-text-accent">{{ __('Electronics') }}</a>
            </li>
            <li class="relative bracamb-dot">
                <a href="#collections" class="text-text-gray hover:text-text-accent">{{ __('Device') }}</a>
            </li>
            <li class="relative bracamb-dot">
                <span class="font-midium">{{ __('Mobile') }}</span>
            </li>
        </ul>
    </div>
    {{-- Title --}}
    <div class="container mx-auto px-4 py-8 text-center">
        <div class="flex flex-col items-center justify-center">
            <h1 class="text-3xl font-medium mb-3">{{ __('Mobile') }}</h1>
            <p class="text-text-gray mx-auto mb-4">
                {{ __('Discover our carefully curated mobile\'s collection, where timeless elegance meets modern style.') }}
            </p>
        </div>
    </div>
</div>
