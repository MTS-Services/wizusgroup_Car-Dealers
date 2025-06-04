<div class="row">
    <div class="col-12">
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
                                <th>{{ __('File') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th>{{ __('Created By') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($infos) }} --}}
                            @forelse ($infos as $info)
                                <tr>
                                    <td>{{ $info->infoCategory?->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($info->file)
                                            <a href="{{ route('pm.product.info.file.download', encrypt($info->id)) }}"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-download"></i></a>
                                        @else
                                            {{ __('N/A') }}
                                        @endif

                                    </td>
                                    <td>{{ $info->created_at_formatted }}</td>
                                    <td>{{ $info->creater_name }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{ encrypt($info->id) }}"
                                            class="btn btn-dark btn-sm view"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('pm.product.delete_info', encrypt($info->id)) }}"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
<x-backend.admin.details-modal :datas="['modal_title' => 'Product Info Details']" />
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let route = `{{ route('pm.product.view_info', ['product_info_id' => ':id']) }}`
                route = route.replace(':id', $(this).data('id'));
                axios.get(route).then(res => {

                    let route = `{{ route('pm.product.view_info', ['product_info_id' => ':id']) }}`
                    route = route.replace(':id', res.data.encryptedID);
                    let view_table = `
                                    <table class="table table-responsive table-striped datatable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Info Category') }}</th>
                                                    <th>{{ __('File') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Created Date') }}</th>
                                                    <th>{{ __('Created By') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>${res.data.info_category.name}</td>
                                                    <td>`;
                    if (res.data.file) {
                        view_table += `<a href="${route}"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-download"></i></a>`;
                    } else {
                        view_table += `N/A`;
                    }




                    view_table += `</td>
                                    <td>${res.data.description}</td>
                                    <td>${res.data.created_at_formatted}</td>
                                    <td>${res.data.creater_name}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    `;
                    $('#modal_data').html(view_table);
                    showModal('myModal');
                });
            })
        });
    </script>
@endpush
