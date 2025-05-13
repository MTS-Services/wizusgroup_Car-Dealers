<label for="size-{{ $datas['size'] }}"
    class="px-3 py-1 shadow-card bg-bg-white dark:bg-bg-darkSecondary rounded text-sm">{{ $datas['size'] }}
    ({{ $datas['stock'] }})
    <input type="hidden" name="{{ $datas['size'] }}" id="size-{{ $datas['size'] }}" value="{{ $datas['size'] }}">
</label>
