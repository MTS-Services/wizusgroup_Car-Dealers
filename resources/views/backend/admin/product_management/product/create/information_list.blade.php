<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">
                    {{ __('Product Information') }}
                </h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table  table-striped datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Info Category') }}</th>
                            <th>{{ __('Category Type') }}</th>
                            <th>{{ __('Type Feature') }}</th>
                            <th>{{ __('Information') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($infos as $info)
                            <tr>
                                <td>{{ $info->infoCategory?->name ?? 'N/A' }}</td>
                                <td>{{ $info->infoCategoryType?->name ?? 'N/A' }}</td>
                                <td>{{ $info->infoCategoryTypeFeature?->name ?? 'N/A' }}</td>
                                <td>{{ $info->description ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('pm.product.delete_info', encrypt($info->id)) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">{{ __('No information found') }}</td>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="cart-title">
                    {{ __('Product Information Category Remarks') }}
                </h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Info Category') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($info_remarks as $info_remark)
                            <tr>
                                <td>{{ $info_remark->infoCategory?->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="javascript:void(0)" data-id="{{ encrypt($info_remark->id) }}" class="btn btn-dark btn-sm remark_view"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('pm.product.delete_info', encrypt($info_remark->id)) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center">{{ __('No information found') }}</td>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Remark View Modal  --}}
<x-backend.admin.details-modal :datas="['modal_title' => 'Product Info Category Remark']" />
@push('js')
    <script>
        $(document).ready(function() {
            $('.remark_view').on('click', function() {
                let route = `{{ route('pm.product.view_remarks',['product_info_id'=>':id']) }}`
                route = route.replace(':id', $(this).data('id'));
                axios.get(route).then(res => {
                   let view_table = `
                                    <table class="table table-responsive table-striped datatable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Info Category') }}</th>
                                                    <th>{{ __('Remarks') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>${res.data.info_category.name}</td>
                                                    <td>${res.data.remarks}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    `;
                    $('#modal_data').html(view_table);
                    showModal('myModal');
                })
            });
        });
    </script>
@endpush
