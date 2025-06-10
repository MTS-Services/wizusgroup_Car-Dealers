<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <div class="title_" style="line-height: 1; color: #fff;">
                    {{ __('Wiz Global') }}
                </div>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                <li class="nav-item  @if ($page_slug == 'dashboard') active @endif">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-chart"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                {{-- Admin Management Routes  --}}
                @canany(['admin-list', 'role-list', 'permission-list'])
                    <li class="nav-item  @if ($page_slug == 'admin' || $page_slug == 'role' || $page_slug == 'permission') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#admin_management"
                            @if ($page_slug == 'admin') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('Admin Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if ($page_slug == 'admin' || $page_slug == 'role' || $page_slug == 'permission') show @endif" id="admin_management">
                            <ul class="nav nav-collapse">
                                @can('admin-list')
                                    <li class="@if ($page_slug == 'admin') active @endif">
                                        <a href="{{ route('am.admin.index') }}">
                                            <span class="sub-item">{{ __('Admin') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('role-list')
                                    <li class="@if ($page_slug == 'role') active @endif">
                                        <a href="{{ route('am.role.index') }}">
                                            <span class="sub-item">{{ __('Role') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('permission-list')
                                    <li class="@if ($page_slug == 'permission') active @endif">
                                        <a href="{{ route('am.permission.index') }}">
                                            <span class="sub-item">{{ __('Permission') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                {{-- User Management  --}}
                @canany(['user-list'])
                    <li class="nav-item  @if ($page_slug == 'user') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#user_management"
                            @if ($page_slug == 'user') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('User Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if ($page_slug == 'user') show @endif" id="user_management">
                            <ul class="nav nav-collapse">
                                @can('user-list')
                                    <li class="@if ($page_slug == 'user') active @endif">
                                        <a href="{{ route('um.user.index') }}">
                                            <span class="sub-item">{{ __('User') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Supplier Management  --}}
                @canany(['supplier-list'])
                    <li class="nav-item  @if ($page_slug == 'supplier') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#supplier_management"
                            @if ($page_slug == 'supplier') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('Supplier Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if ($page_slug == 'supplier') show @endif" id="supplier_management">
                            <ul class="nav nav-collapse">
                                @can('supplier-list')
                                    <li class="@if ($page_slug == 'supplier') active @endif">
                                        <a href="{{ route('sm.supplier.index') }}">
                                            <span class="sub-item">{{ __('Supplier') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                {{-- Shipping Location Management  --}}
                @canany(['shipping-location-list', 'container-list', 'container-reserve-list'])
                    <li class="nav-item  @if ($page_slug == 'shipping_location' || $page_slug == 'container' || $page_slug == 'container_reservation') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#shipping_location_management"
                            @if ($page_slug == 'shipping_location' || $page_slug == 'container' || $page_slug == 'container_reservation') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('GS Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if ($page_slug == 'shipping_location' || $page_slug == 'container' || $page_slug == 'container_reservation') show @endif"
                            id="shipping_location_management">
                            <ul class="nav nav-collapse">
                                @can('shipping-location-list')
                                    <li class="@if ($page_slug == 'shipping_location') active @endif">
                                        <a href="{{ route('gs.shipping-location.index') }}">
                                            <span class="sub-item">{{ __('Shipping Location') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('container-list')
                                    <li class="@if ($page_slug == 'container') active @endif">
                                        <a href="{{ route('gs.container.index') }}">
                                            <span class="sub-item">{{ __('Container') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('container-reserve-list')
                                    <li class="@if ($page_slug == 'container_reservation') active @endif">
                                        <a href="{{ route('gs.container-reserve.index') }}">
                                            <span class="sub-item">{{ __('Container Reservation') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Initiated
                Pending
                Submitted
                Confirm
                Shipped
                Delivered
                Canceled --}}
                {{-- Order Management  --}}
                @canany(['order-list'])
                    <li class="nav-item  @if (
                        $page_slug == 'order_pending' ||
                            $page_slug == 'order_submitted' ||
                            $page_slug == 'order_confirm' ||
                            $page_slug == 'order_shipped' ||
                            $page_slug == 'order_delivered' ||
                            $page_slug == 'order_canceled') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#order_management"
                            @if (
                                $page_slug == 'order_pending' ||
                                    $page_slug == 'order_submitted' ||
                                    $page_slug == 'order_confirm' ||
                                    $page_slug == 'order_shipped' ||
                                    $page_slug == 'order_delivered' ||
                                    $page_slug == 'order_canceled') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('Order Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if (
                            $page_slug == 'order_pending' ||
                                $page_slug == 'order_submitted' ||
                                $page_slug == 'order_confirm' ||
                                $page_slug == 'order_shipped' ||
                                $page_slug == 'order_delivered' ||
                                $page_slug == 'order_canceled') show @endif" id="order_management">
                            <ul class="nav nav-collapse">
                                @can('order-list')
                                    <li class="@if ($page_slug == 'order_submitted') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'submitted']) }}">
                                            <span class="sub-item">{{ __('Submitted Orders') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if ($page_slug == 'order_confirm') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'confirm']) }}">
                                            <span class="sub-item">{{ __('Confirm Orders') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if ($page_slug == 'order_shipped') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'shipped']) }}">
                                            <span class="sub-item">{{ __('Shipped Orders') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if ($page_slug == 'order_delivered') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'delivered']) }}">
                                            <span class="sub-item">{{ __('Delivered Orders') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if ($page_slug == 'order_pending') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'pending']) }}">
                                            <span class="sub-item">{{ __('Pending Orders') }}</span>
                                        </a>
                                    </li>
                                    <li class="@if ($page_slug == 'order_canceled') active @endif">
                                        <a href="{{ route('om.order.index', ['status' => 'canceled']) }}">
                                            <span class="sub-item">{{ __('Canceled Orders') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Setup Management  --}}
                @canany(['country-list', 'state-list', 'city-list', 'operation-area-list', 'operation-sub-area-list'])
                    <li class="nav-item  @if (
                        $page_slug == 'country' ||
                            $page_slug == 'state' ||
                            $page_slug == 'city' ||
                            $page_slug == 'operation_area' ||
                            $page_slug == 'operation_sub_area') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#setup_management"
                            @if (
                                $page_slug == 'country' ||
                                    $page_slug == 'state' ||
                                    $page_slug == 'city' ||
                                    $page_slug == 'operation_area' ||
                                    $page_slug == 'operation_sub_area') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('Setup') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if (
                            $page_slug == 'country' ||
                                $page_slug == 'state' ||
                                $page_slug == 'city' ||
                                $page_slug == 'operation_area' ||
                                $page_slug == 'operation_sub_area') show @endif" id="setup_management">
                            <ul class="nav nav-collapse">
                                {{-- @can('country-list') --}}
                                <li class="@if ($page_slug == 'country') active @endif">
                                    <a href="{{ route('setup.country.index') }}">
                                        <span class="sub-item">{{ __('Country') }}</span>
                                    </a>
                                </li>
                                {{-- @endcan --}}
                                @can('state-list')
                                    <li class="@if ($page_slug == 'state') active @endif">
                                        <a href="{{ route('setup.state.index') }}">
                                            <span class="sub-item">{{ __('State') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('city-list')
                                    <li class="@if ($page_slug == 'city') active @endif">
                                        <a href="{{ route('setup.city.index') }}">
                                            <span class="sub-item">{{ __('City') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @if (isset($not_used))
                                    {{-- @can('operation-area-list')
                                         <li class="@if ($page_slug == 'operation_area') active @endif">
                                        <a href="{{ route('setup.operation-area.index') }}">
                                            <span class="sub-item">{{ __('Operation Area') }}</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('operation-sub-area-list')
                                    <li class="@if ($page_slug == 'operation_sub_area') active @endif">
                                        <a href="{{ route('setup.operation-sub-area.index') }}">
                                            <span class="sub-item">{{ __('Operation Sub Area') }}</span>
                                        </a>
                                    </li>
                                    @endcan --}}
                                @endif
                            </ul>
                        </div>

                    </li>
                @endcanany

                {{-- Product Management --}}
                @canany(['product-attribute-list', 'product-attribute-value-list', 'tax-class-list', 'tax-rate-list',
                    'company-list', 'brand-list', 'model-list', 'category-list', 'sub-category-list',
                    'sub-child-category-list', 'product-info-category-list', 'product-info-category-type-list',
                    'product-info-category-type-feature-list', 'product-list', 'product-create'])
                    <li class="nav-item
                    @if (
                        $page_slug == 'category' ||
                            $page_slug == 'subcategory' ||
                            $page_slug == 'subchildcategory' ||
                            $page_slug == 'product_attribute' ||
                            $page_slug == 'product_attribute_value' ||
                            $page_slug == 'company' ||
                            $page_slug == 'brand' ||
                            $page_slug == 'model' ||
                            $page_slug == 'tax_class' ||
                            $page_slug == 'tax_rate' ||
                            $page_slug == 'product_info_cat' ||
                            $page_slug == 'product_info_cat_type' ||
                            $page_slug == 'pro_info_cat_tf' ||
                            $page_slug == 'product') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#product_management"
                            @if (
                                $page_slug == 'category' ||
                                    $page_slug == 'subcategory' ||
                                    $page_slug == 'subchildcategory' ||
                                    $page_slug == 'product_attribute' ||
                                    $page_slug == 'product_attribute_value' ||
                                    $page_slug == 'company' ||
                                    $page_slug == 'brand' ||
                                    $page_slug == 'model' ||
                                    $page_slug == 'tax_class' ||
                                    $page_slug == 'tax_rate' ||
                                    $page_slug == 'product_info_cat' ||
                                    $page_slug == 'product_info_cat_type' ||
                                    $page_slug == 'pro_info_cat_tf' ||
                                    $page_slug == 'product') aria-expanded="true" @endif>

                            <i class="icon-people"></i>
                            <p>{{ __('Product Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse
                        @if (
                            $page_slug == 'category' ||
                                $page_slug == 'subcategory' ||
                                $page_slug == 'subchildcategory' ||
                                $page_slug == 'product_attribute' ||
                                $page_slug == 'product_attribute_value' ||
                                $page_slug == 'company' ||
                                $page_slug == 'brand' ||
                                $page_slug == 'model' ||
                                $page_slug == 'tax_class' ||
                                $page_slug == 'tax_rate' ||
                                $page_slug == 'product_info_cat' ||
                                $page_slug == 'product_info_cat_type' ||
                                $page_slug == 'pro_info_cat_tf' ||
                                $page_slug == 'product') show @endif"
                            id="product_management">
                            <ul class="nav nav-collapse">

                                @canany(['product-attribute-list', 'product-attribute-value-list', 'tax-class-list',
                                    'tax-rate-list', 'company-list', 'brand-list', 'model-list'])
                                    <li
                                        class="
                                    @if (
                                        $page_slug == 'product_attribute' ||
                                            $page_slug == 'product_attribute_value' ||
                                            $page_slug == 'company' ||
                                            $page_slug == 'brand' ||
                                            $page_slug == 'model' ||
                                            $page_slug == 'tax_class' ||
                                            $page_slug == 'tax_rate') active @endif">
                                        <a data-bs-toggle="collapse" href="#product_setups"
                                            aria-expanded="
                                    @if (
                                        $page_slug == 'product_attribute' ||
                                            $page_slug == 'product_attribute_value' ||
                                            $page_slug == 'company' ||
                                            $page_slug == 'brand' ||
                                            $page_slug == 'model' ||
                                            $page_slug == 'tax_class' ||
                                            $page_slug == 'tax_rate') true @endif">
                                            <span class="sub-item">{{ __('Setups') }}</span>
                                            <span class="caret"></span>
                                        </a>
                                        <div class="collapse
                                    @if (
                                        $page_slug == 'product_attribute' ||
                                            $page_slug == 'product_attribute_value' ||
                                            $page_slug == 'company' ||
                                            $page_slug == 'brand' ||
                                            $page_slug == 'model' ||
                                            $page_slug == 'tax_class' ||
                                            $page_slug == 'tax_rate') show @endif"
                                            id="product_setups">
                                            <ul class="nav nav-collapse subnav">
                                                @if (isset($not_used))
                                                    {{-- @can('product-attribute-list')
                                                <li class="@if ($page_slug == 'product_attribute') active @endif">
                                                    <a href="{{ route('pm.product-attribute.index') }}">
                                                        <span class="sub-item">{{ __('Product Attribute') }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('product-attribute-value-list')
                                                <li class="@if ($page_slug == 'product_attribute_value') active @endif">
                                                    <a href="{{ route('pm.product-attr-value.index') }}">
                                                        <span class="sub-item">{{ __('Product Attribute Value') }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('tax-class-list')
                                                <li class="@if ($page_slug == 'tax_class') active @endif">
                                                    <a href="{{ route('pm.tax-class.index') }}">
                                                        <span class="sub-item">{{ __('Tax Class') }}</span>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('tax-rate-list')
                                                <li class="@if ($page_slug == 'tax_rate') active @endif">
                                                    <a href="{{ route('pm.tax-rate.index') }}">
                                                        <span class="sub-item">{{ __('Tax Rate') }}</span>
                                                    </a>
                                                </li>
                                            @endcan --}}
                                                @endif

                                                @can('company-list')
                                                    <li class="@if ($page_slug == 'company') active @endif">
                                                        <a href="{{ route('pm.company.index') }}">
                                                            <span class="sub-item">{{ __('Company') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('brand-list')
                                                    <li class="@if ($page_slug == 'brand') active @endif">
                                                        <a href="{{ route('pm.brand.index') }}">
                                                            <span class="sub-item">{{ __('Brand') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('model-list')
                                                    <li class="@if ($page_slug == 'model') active @endif">
                                                        <a href="{{ route('pm.model.index') }}">
                                                            <span class="sub-item">{{ __('Model') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>

                                    </li>
                                @endcanany

                                @canany(['category-list', 'sub-category-list', 'sub-child-category-list',
                                    'product-info-category-list', 'product-info-category-type-list',
                                    'product-info-category-type-feature-list'])
                                    <li
                                        class="
                                    @if (
                                        $page_slug == 'category' ||
                                            $page_slug == 'subcategory' ||
                                            $page_slug == 'subchildcategory' ||
                                            $page_slug == 'product_info_cat' ||
                                            $page_slug == 'product_info_cat_type' ||
                                            $page_slug == 'pro_info_cat_tf') active @endif">
                                        <a data-bs-toggle="collapse" href="#product_categories"
                                            aria-expanded="
                                    @if (
                                        $page_slug == 'category' ||
                                            $page_slug == 'subcategory' ||
                                            $page_slug == 'subchildcategory' ||
                                            $page_slug == 'product_info_cat' ||
                                            $page_slug == 'product_info_cat_type' ||
                                            $page_slug == 'pro_info_cat_tf') true @endif">
                                            <span class="sub-item">{{ __('Categories') }}</span>
                                            <span class="caret"></span>
                                        </a>
                                        <div class="collapse
                                    @if (
                                        $page_slug == 'category' ||
                                            $page_slug == 'subcategory' ||
                                            $page_slug == 'subchildcategory' ||
                                            $page_slug == 'product_info_cat' ||
                                            $page_slug == 'product_info_cat_type' ||
                                            $page_slug == 'pro_info_cat_tf') show @endif"
                                            id="product_categories">
                                            <ul class="nav nav-collapse subnav">
                                                @can('category-list')
                                                    <li class="@if ($page_slug == 'category') active @endif">
                                                        <a href="{{ route('pm.category.index') }}">
                                                            <span class="sub-item">{{ __('Category') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('sub-category-list')
                                                    <li class="@if ($page_slug == 'subcategory') active @endif">
                                                        <a href="{{ route('pm.sub-category.index') }}">
                                                            <span class="sub-item">{{ __('Sub Category') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan

                                                @if (isset($not_used))
                                                    {{-- @can('sub-child-category-list')
                                                <li class="@if ($page_slug == 'subchildcategory') active @endif">
                                                    <a href="{{ route('pm.sub-child-category.index') }}">
                                                        <span class="sub-item">{{ __('Sub Child Category') }}</span>
                                                    </a>
                                                </li>
                                            @endcan --}}
                                                @endif
                                                @can('product-info-category-list')
                                                    <li class="@if ($page_slug == 'product_info_cat') active @endif">
                                                        <a href="{{ route('pm.product-info-category.index') }}">
                                                            <span class="sub-item">{{ __('Product Info Category') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('product-info-category-type-list')
                                                    <li class="@if ($page_slug == 'product_info_cat_type') active @endif">
                                                        <a href="{{ route('pm.product-info-category-type.index') }}">
                                                            <span class="sub-item">{{ __('Product Info Category Type') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('product-info-category-type-feature-list')
                                                    <li class="@if ($page_slug == 'pro_info_cat_tf') active @endif">
                                                        <a href="{{ route('pm.pro-info-cat-tf.index') }}">
                                                            <span
                                                                class="sub-item">{{ __('Product Info Category Type Feature') }}</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>
                                @endcanany

                                @can('product-create')
                                    <li class="@if ($page_slug == 'product' && isset($product_type) && $product_type == App\Models\Product::PRODUCT_TYPE_NORMAL) active @endif">
                                        <a
                                            href="{{ route('pm.product.create', ['product_type' => App\Models\Product::PRODUCT_TYPE_NORMAL]) }}">
                                            <span class="sub-item">{{ __('Add Product') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-create')
                                    <li class="@if ($page_slug == 'product' && isset($product_type) && $product_type == App\Models\Product::PRODUCT_TYPE_PARTS) active @endif">
                                        <a
                                            href="{{ route('pm.product.create', ['product_type' => App\Models\Product::PRODUCT_TYPE_PARTS]) }}">
                                            <span class="sub-item">{{ __('Add Parts & Accessories') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-create')
                                    <li class="@if ($page_slug == 'product' && isset($product_type) && $product_type == App\Models\Product::PRODUCT_TYPE_DROPSHIPPING) active @endif">
                                        <a
                                            href="{{ route('pm.product.create', ['product_type' => App\Models\Product::PRODUCT_TYPE_DROPSHIPPING]) }}">
                                            <span class="sub-item">{{ __('Add Dropshipping Product') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-list')
                                    <li class="@if ($page_slug == 'product' && (empty($product_type) || !isset($product_type))) active @endif">
                                        <a href="{{ route('pm.product.index') }}">
                                            <span class="sub-item">{{ __('Product') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Auction Management --}}
                @canany(['auction-list', 'auction-running-list'])
                    <li class="nav-item  @if ($page_slug == 'auction' || $page_slug == 'auction_running') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#auction_management"
                            @if ($page_slug == 'auction' || $page_slug == 'auction_running') aria-expanded="true" @endif>
                            <i class="fas fa-gavel"></i>
                            <p>{{ __('Auction Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if ($page_slug == 'auction' || $page_slug == 'auction_running') show @endif" id="auction_management">
                            <ul class="nav nav-collapse">
                                @can('auction-list')
                                    <li class="@if ($page_slug == 'auction') active @endif">
                                        <a href="{{ route('auction-m.auction.index') }}">
                                            <span class="sub-item">{{ __('Auction') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('auction-running-list')
                                    <li class="@if ($page_slug == 'auction_running') active @endif">
                                        <a href="{{ route('auction-m.auction-running') }}">
                                            <span class="sub-item">{{ __('Auction Running') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                {{-- CMS Management  --}}
                @canany(['banner-list', 'faq-list', 'testimonial-list', 'contact-list', 'region-list',
                    'region-shipping-timeline-list'])
                    <li class="nav-item  @if (
                        $page_slug == 'banner' ||
                            $page_slug == 'faq' ||
                            $page_slug == 'testimonial' ||
                            $page_slug == 'contact' ||
                            $page_slug == 'region' ||
                            $page_slug == 'region_shipping_timeline') active submenu @endif">
                        <a data-bs-toggle="collapse" href="#cms_management"
                            @if (
                                $page_slug == 'banner' ||
                                    $page_slug == 'faq' ||
                                    $page_slug == 'testimonial' ||
                                    $page_slug == 'contact' ||
                                    $page_slug == 'region' ||
                                    $page_slug == 'region_shipping_timeline') aria-expanded="true" @endif>
                            <i class="icon-people"></i>
                            <p>{{ __('CMS Management') }}</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse @if (
                            $page_slug == 'banner' ||
                                $page_slug == 'faq' ||
                                $page_slug == 'testimonial' ||
                                $page_slug == 'contact' ||
                                $page_slug == 'region' ||
                                $page_slug == 'region_shipping_timeline') show @endif" id="cms_management">
                            <ul class="nav nav-collapse">
                                @can('banner-list')
                                    <li class="@if ($page_slug == 'banner') active @endif">
                                        <a href="{{ route('cms.banner.index') }}">
                                            <span class="sub-item">{{ __('Banner') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('faq-list')
                                    <li class="@if ($page_slug == 'faq') active @endif">
                                        <a href="{{ route('cms.faq.index') }}">
                                            <span class="sub-item">{{ __('Faq') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('testimonial-list')
                                    <li class="@if ($page_slug == 'testimonial') active @endif">
                                        <a href="{{ route('cms.testimonial.index') }}">
                                            <span class="sub-item">{{ __('Testimonial') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('contact-list')
                                    <li class="@if ($page_slug == 'contact') active @endif">
                                        <a href="{{ route('cms.contact.index') }}">
                                            <span class="sub-item">{{ __('Contact') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('region-list')
                                    <li class="@if ($page_slug == 'region') active @endif">
                                        <a href="{{ route('cms.region.index') }}">
                                            <span class="sub-item">{{ __('Region') }}</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('region-shipping-timeline-list')
                                    <li class="@if ($page_slug == 'region_shipping_timeline') active @endif">
                                        <a href="{{ route('cms.region-shipping-timeline.index') }}">
                                            <span class="sub-item">{{ __('Region Shipping Timeline') }}</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @can('audit-list')
                    <li class="nav-item  @if ($page_slug == 'audits') active @endif">
                        <a href="{{ route('audit.index') }}">
                            <i class="icon-ban"></i>
                            <p>{{ __('Audits') }}</p>
                        </a>
                    </li>
                @endcan
                @can('documentation-list')
                    <li class="nav-item  @if ($page_slug == 'documentation') active @endif">
                        <a href="{{ route('documentation.index') }}">
                            <i class="icon-docs"></i>
                            <p>{{ __('Documentation') }}</p>
                        </a>
                    </li>
                @endcan
                {{-- @can('temp-list')
                    <li class="nav-item  @if ($page_slug == 'temp_file') active @endif">
                        <a href="{{ route('temp.index') }}">
                            <i class="icon-trash"></i>
                            <p>{{ __('Temporary Files') }}</p>
                        </a>
                    </li>
                @endcan --}}

                @can('application-settings')
                    <li class="nav-item  @if ($page_slug == 'site_setting') active @endif">
                        <a href="{{ route('site_setting.index') }}">
                            <i class="icon-settings"></i>
                            <p>{{ __('Application Settings') }}</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
