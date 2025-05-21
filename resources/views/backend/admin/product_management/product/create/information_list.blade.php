<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="cart-title">
            {{ __('Product Information') }}
        </h4>
    </div>
    <div class="card-body">

        <table class="table table-responsive table-striped datatable">
            <thead>
                <tr>
                    <th>{{ __('Info Category') }}</th>
                    <th>{{ __('Info Category Type') }}</th>
                    <th>{{ __('Info Category Type Feature') }}</th>
                    <th>{{ __('Information') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($infos as $info)
                    <tr>
                        <td>{{ $info->infoCategory->name ?? 'N/A' }}</td>
                        <td>{{ $info->infoCategoryType->name ?? 'N/A' }}</td>
                        <td>{{ $info->infoCategoryTypeFeature->name ?? 'N/A' }}</td>
                        <td>{{ $info->description ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <td colspan="4" class="text-center">{{ __('No information found') }}</td>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="cart-title">
            {{ __('Product Remarks') }}
        </h4>
    </div>
    <div class="card-body">

        <table class="table table-responsive table-striped datatable">
            <thead>
                <tr>
                    <th>{{ __('Info Category') }}</th>
                    <th>{{ __('Remarks') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($infos as $info)
                    <tr>
                        <td>{{ $info->infoCategory->name ?? 'N/A' }}</td>
                        <td>{!! $info->remarks ?? 'N/A' !!}</td>
                    </tr>
                @empty
                    <td colspan="4" class="text-center">{{ __('No Remarks found') }}</td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
