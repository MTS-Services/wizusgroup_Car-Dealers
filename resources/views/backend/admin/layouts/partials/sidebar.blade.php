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
                <li class="nav-item  @if ($page_slug == 'admin' || $page_slug == 'role' || $page_slug == 'permission') active submenu @endif">
                    <a data-bs-toggle="collapse" href="#admin_management"
                        @if ($page_slug == 'admin') aria-expanded="true" @endif>
                        <i class="icon-people"></i>
                        <p>{{ __('Admin Management') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if ($page_slug == 'admin' || $page_slug == 'role' || $page_slug == 'permission') show @endif" id="admin_management">
                        <ul class="nav nav-collapse">
                            <li class="@if ($page_slug == 'admin') active @endif">
                                <a href="{{ route('am.admin.index') }}">
                                    <span class="sub-item">{{ __('Admin') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'role') active @endif">
                                <a href="{{ route('am.role.index') }}">
                                    <span class="sub-item">{{ __('Role') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'permission') active @endif">
                                <a href="{{ route('am.permission.index') }}">
                                    <span class="sub-item">{{ __('Permission') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- User Management  --}}
                <li class="nav-item  @if ($page_slug == 'user') active submenu @endif">
                    <a data-bs-toggle="collapse" href="#user_management"
                        @if ($page_slug == 'user') aria-expanded="true" @endif>
                        <i class="icon-people"></i>
                        <p>{{ __('User Management') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if ($page_slug == 'user') show @endif" id="user_management">
                        <ul class="nav nav-collapse">
                            <li class="@if ($page_slug == 'user') active @endif">
                                <a href="{{ route('um.user.index') }}">
                                    <span class="sub-item">{{ __('User') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- Supplier Management  --}}
                <li class="nav-item  @if ($page_slug == 'supplier') active submenu @endif">
                    <a data-bs-toggle="collapse" href="#supplier_management"
                        @if ($page_slug == 'supplier') aria-expanded="true" @endif>
                        <i class="icon-people"></i>
                        <p>{{ __('Supplier Management') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if ($page_slug == 'supplier') show @endif" id="supplier_management">
                        <ul class="nav nav-collapse">
                            <li class="@if ($page_slug == 'supplier') active @endif">
                                <a href="{{ route('sm.supplier.index') }}">
                                    <span class="sub-item">{{ __('Supplier') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Setup Management  --}}
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
                            <li class="@if ($page_slug == 'country') active @endif">
                                <a href="{{ route('setup.country.index') }}">
                                    <span class="sub-item">{{ __('Country') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'state') active @endif">
                                <a href="{{ route('setup.state.index') }}">
                                    <span class="sub-item">{{ __('State') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'city') active @endif">
                                <a href="{{ route('setup.city.index') }}">
                                    <span class="sub-item">{{ __('City') }}</span>
                                </a>
                            </li>
                            @if (isset($not_used))
                                {{-- <li class="@if ($page_slug == 'operation_area') active @endif">
                                    <a href="{{ route('setup.operation-area.index') }}">
                                        <span class="sub-item">{{ __('Operation Area') }}</span>
                                    </a>
                                </li>
                                <li class="@if ($page_slug == 'operation_sub_area') active @endif">
                                    <a href="{{ route('setup.operation-sub-area.index') }}">
                                        <span class="sub-item">{{ __('Operation Sub Area') }}</span>
                                    </a>
                                </li> --}}
                            @endif
                        </ul>
                    </div>

                </li>

                {{-- Product Management --}}
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
                                            {{-- <li class="@if ($page_slug == 'product_attribute') active @endif">
                                                <a href="{{ route('pm.product-attribute.index') }}">
                                                    <span class="sub-item">{{ __('Product Attribute') }}</span>
                                                </a>
                                            </li>
                                            <li class="@if ($page_slug == 'product_attribute_value') active @endif">
                                                <a href="{{ route('pm.product-attr-value.index') }}">
                                                    <span class="sub-item">{{ __('Product Attribute Value') }}</span>
                                                </a>
                                            </li> --}}
                                            {{-- <li class="@if ($page_slug == 'tax_class') active @endif">
                                                <a href="{{ route('pm.tax-class.index') }}">
                                                    <span class="sub-item">{{ __('Tax Class') }}</span>
                                                </a>
                                            </li>
                                            <li class="@if ($page_slug == 'tax_rate') active @endif">
                                                <a href="{{ route('pm.tax-rate.index') }}">
                                                    <span class="sub-item">{{ __('Tax Rate') }}</span>
                                                </a>
                                            </li> --}}
                                        @endif

                                        <li class="@if ($page_slug == 'company') active @endif">
                                            <a href="{{ route('pm.company.index') }}">
                                                <span class="sub-item">{{ __('Company') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if ($page_slug == 'brand') active @endif">
                                            <a href="{{ route('pm.brand.index') }}">
                                                <span class="sub-item">{{ __('Brand') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if ($page_slug == 'model') active @endif">
                                            <a href="{{ route('pm.model.index') }}">
                                                <span class="sub-item">{{ __('Model') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
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
                                        <li class="@if ($page_slug == 'category') active @endif">
                                            <a href="{{ route('pm.category.index') }}">
                                                <span class="sub-item">{{ __('Category') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if ($page_slug == 'subcategory') active @endif">
                                            <a href="{{ route('pm.sub-category.index') }}">
                                                <span class="sub-item">{{ __('Sub Category') }}</span>
                                            </a>
                                        </li>
                                        @if (isset($not_used))
                                            <li class="@if ($page_slug == 'subchildcategory') active @endif">
                                                <a href="{{ route('pm.sub-child-category.index') }}">
                                                    <span class="sub-item">{{ __('Sub Child Category') }}</span>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="@if ($page_slug == 'product_info_cat') active @endif">
                                            <a href="{{ route('pm.product-info-category.index') }}">
                                                <span class="sub-item">{{ __('Product Info Category') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if ($page_slug == 'product_info_cat_type') active @endif">
                                            <a href="{{ route('pm.product-info-category-type.index') }}">
                                                <span class="sub-item">{{ __('Product Info Category Type') }}</span>
                                            </a>
                                        </li>
                                        <li class="@if ($page_slug == 'pro_info_cat_tf') active @endif">
                                            <a href="{{ route('pm.pro-info-cat-tf.index') }}">
                                                <span
                                                    class="sub-item">{{ __('Product Info Category Type Feature') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="@if ($page_slug == 'product') active @endif">
                                <a href="{{ route('pm.product.index') }}">
                                    <span class="sub-item">{{ __('Product') }}</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                {{-- Auction Management --}}
                <li class="nav-item  @if ($page_slug == 'auction') active submenu @endif">
                    <a data-bs-toggle="collapse" href="#auction_management"
                        @if ($page_slug == 'auction') aria-expanded="true" @endif>
                        <i class="fas fa-gavel"></i>
                        <p>{{ __('Auction Management') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if ($page_slug == 'auction') show @endif" id="auction_management">
                        <ul class="nav nav-collapse">
                            <li class="@if ($page_slug == 'auction') active @endif">
                                <a href="{{ route('auction-m.auction.index') }}">
                                    <span class="sub-item">{{ __('Auction') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- CMS Management  --}}
                <li class="nav-item  @if ($page_slug == 'banner' || $page_slug == 'faq'|| $page_slug == 'testimonial'|| $page_slug == 'contact') active submenu @endif">
                    <a data-bs-toggle="collapse" href="#cms_management"
                        @if ($page_slug == 'banner' || $page_slug == 'faq'|| $page_slug == 'testimonial'|| $page_slug == 'contact') aria-expanded="true" @endif>
                        <i class="icon-people"></i>
                        <p>{{ __('CMS Management') }}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if ($page_slug == 'banner' || $page_slug == 'faq'|| $page_slug == 'testimonial'|| $page_slug == 'contact') show @endif" id="cms_management">
                        <ul class="nav nav-collapse">
                            <li class="@if ($page_slug == 'banner') active @endif">
                                <a href="{{ route('cms.banner.index') }}">
                                    <span class="sub-item">{{ __('Banner') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'faq') active @endif">
                                <a href="{{ route('cms.faq.index') }}">
                                    <span class="sub-item">{{ __('Faq') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'testimonial') active @endif">
                                <a href="{{ route('cms.testimonial.index') }}">
                                    <span class="sub-item">{{ __('Testimonial') }}</span>
                                </a>
                            </li>
                            <li class="@if ($page_slug == 'contact') active @endif">
                                <a href="{{ route('cms.contact.index') }}">
                                    <span class="sub-item">{{ __('Contact') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item  @if ($page_slug == 'audits') active @endif">
                    <a href="{{ route('audit.index') }}">
                        <i class="icon-ban"></i>
                        <p>{{ __('Audits') }}</p>
                    </a>
                </li>
                <li class="nav-item  @if ($page_slug == 'documentation') active @endif">
                    <a href="{{ route('documentation.index') }}">
                        <i class="icon-docs"></i>
                        <p>{{ __('Documentation') }}</p>
                    </a>
                </li>
                {{-- <li class="nav-item  @if ($page_slug == 'temp_file') active @endif">
                    <a href="{{ route('temp.index') }}">
                        <i class="icon-trash"></i>
                        <p>{{ __('Temporary Files') }}</p>
                    </a>
                </li> --}}
                <li class="nav-item  @if ($page_slug == 'site_setting') active @endif">
                    <a href="{{ route('site_setting.index') }}">
                        <i class="icon-settings"></i>
                        <p>{{ __('Application Settings') }}</p>
                    </a>
                </li>



                {{-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Menu Levels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav1">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav2">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Level 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> --}}
            </ul>
        </div>
    </div>
</div>
