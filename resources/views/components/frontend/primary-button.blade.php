@props(['href' => 'javascript:void(0)', 'secondary' => false, 'icon' => null])

<a href="{{ $href }}"
    {{ $attributes->merge(['title' => '', 'target' => '_self', 'class' => ($secondary ? 'inline-flex gap-2 items-center btn-secondary rounded-md bg-bg-tertiary hover:bg-transparent text-text-light hover:text-text-tertiary dark:hover:text-text-white border-opacity-0 hover:border-opacity-100 px-0 py-2' : 'inline-flex gap-2 items-center btn-secondary rounded-md hover:bg-bg-tertiary text-text-tertiary hover:text-text-white hover:bg-tertiary hover:border-opacity-0 px-0 py-2')]) }}>
    @if($icon) <span><i data-lucide="{{ $icon }}" class="w-4 h-4"></i></span>@endif{{ $slot }}
</a>
