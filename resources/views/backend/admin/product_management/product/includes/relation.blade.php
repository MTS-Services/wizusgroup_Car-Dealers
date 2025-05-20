<form action="{{ route('pm.product.relation.store', encrypt(1)) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ __('Company') }}</label>
                <select name="company_id" id="company_id" class="form-control">
                    <option value="" selected disabled>{{ __('Select Company') }}</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Brand') }}</label>
                <select name="brand_id" id="brand_id" class="form-control" disabled>
                    <option value="" selected disabled>{{ __('Select Brand') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Model') }}</label>
                <select name="model_id" class="form-control" id="model_id" disabled>
                    <option value="" selected disabled>{{ __('Select Model') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Tax Class') }}</label>
                <select name="tax_class_id" id="tax_class_id" class="form-control">
                    <option value="" selected disabled>{{ __('Select Tax Class') }}</option>
                    @foreach ($tax_classes as $tax_class)
                        <option value="{{ $tax_class->id }}">{{ $tax_class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Tax Rate') }}</label>
                <select name="tax_rate_id" class="form-control" id="tax_rate_id" disabled>
                    <option value="" selected disabled>{{ __('Select Tax Rate') }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Category') }}</label>
                <select name="category_id" class="form-control" id="category_id">
                    <option value="" selected disabled>{{ __('Select Category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Sub Category') }}</label>
                <select name="sub_category_id" id="childrens" class="form-control" disabled>
                    <option value="" selected>{{ __('Select Sub Category') }}</option>
                </select>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Sub Child Category') }}</label>
                <select name="sub_child_category_id" class="form-control" disabled id="sub_childrens">
                    <option value="" selected>{{ __('Select Sub Child Category') }}</option>                    
                </select>
            </div>
        </div> --}}
    </div>

    <div class="form-group float-end">
        <input type="submit" class="btn btn-primary" value="Next">
    </div>
</form>

@push('js')
    <script>
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                let route = "{{ route('axios.get-sub-categories') }}";
                getSubCategories($(this).val(), route);
            })

            // Sub Child Category
            // $('#childrens').on('change', function() {
            //     let route = "{{ route('axios.get-sub-child-categories') }}";
            //     getSubChildCategories($(this).val(), route);
            // })

            $('#company_id').on('change', function() {
                let route = "{{ route('axios.get-brands') }}";
                getBrands($(this).val(), route);
            });

            $('#tax_class_id').on('change', function() {
                let route = "{{ route('axios.get-tax-rates') }}";
                getTaxRates($(this).val(), route);
            });

            $('#brand_id').on('change', function() {
                let route = "{{ route('axios.get-models') }}";
                getModels({
                    brandId: $(this).val(),
                    route: route
                });
            });
        });
    </script>
@endpush
