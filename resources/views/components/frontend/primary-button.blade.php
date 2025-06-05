@props(['href' => 'javascript:void(0)', 'bg' => false, 'icon' => null, 'data_id' => null])

<a href="{{ $href }}" data-id="{{ $data_id }}"
    {{ $attributes->merge([
        'title' => '',
        'target' => '_self',
        'class' =>
            'inline-flex gap-2 items-center btn-secondary rounded-md  hover:border-opacity-100 px-0 py-2 w-full' .
            ($bg
                ? ' bg-bg-tertiary hover:bg-transparent text-text-light hover:text-text-tertiary dark:hover:text-text-white border-opacity-0'
                : ' hover:bg-bg-tertiary text-text-tertiary
                                                        hover:text-text-white hover:bg-tertiary border-opacity-100'),
    ]) }}>
    @if ($icon)
        <span><i data-lucide="{{ $icon }}" class="w-4 h-4"></i></span>
    @endif
    {{ $slot }}
</a>
