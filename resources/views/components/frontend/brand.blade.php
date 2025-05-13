<label for="brand-{{ $datas['brand'] }}">
    <input type="checkbox" id="brand-{{ $datas['brand'] }}" class="brand-checkbox checkbox checkbox-sm dark:border-white"
        name="brand" value="{{ $datas['brand'] }}">
    <span>{{ $datas['brand'] }}</span>
    <span class="text-text-gray">({{ $datas['stock'] }})</span>
</label>
