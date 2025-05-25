<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Backend\Admin\AuditController;
use App\Http\Controllers\Backend\Admin\TempFileController;
use App\Http\Controllers\Backend\Admin\Setup\CityController;
use App\Http\Controllers\Backend\Admin\AdminProfileContoller;
use App\Http\Controllers\Backend\Admin\Setup\StateController;
use App\Http\Controllers\Backend\Admin\SiteSettingController;
use App\Http\Controllers\Backend\Admin\AxiosRequestController;
use App\Http\Controllers\Backend\Admin\DocumentationController;
use App\Http\Controllers\Backend\Admin\Setup\CountryController;
use App\Http\Controllers\Backend\Admin\CMSManagement\FaqController;
use App\Http\Controllers\Backend\Admin\Setup\OperationAreaController;
use App\Http\Controllers\Backend\Admin\UserManagement\UserController;
use App\Http\Controllers\Backend\Admin\AdminManagement\RoleController;
use App\Http\Controllers\Backend\Admin\CMSManagement\BannerController;
use App\Http\Controllers\Backend\Admin\AdminManagement\AdminController;
use App\Http\Controllers\Backend\Admin\Setup\OperationSubAreaController;
use App\Http\Controllers\Backend\Admin\ProductManagement\BrandController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ModelController;
use App\Http\Controllers\Backend\Admin\AuctionManagement\AuctionController;
use App\Http\Controllers\Backend\Admin\CMSManagement\TestimonialController;
use App\Http\Controllers\Backend\Admin\ProductManagement\CompanyController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProductController;
use App\Http\Controllers\Backend\Admin\ProductManagement\TaxRateController;
use App\Http\Controllers\Backend\Admin\AdminManagement\PermissionController;
use App\Http\Controllers\Backend\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Backend\Admin\ProductManagement\TaxClassController;
use App\Http\Controllers\Backend\Admin\SupplierManagement\SuppliersController;
use App\Http\Controllers\Backend\Admin\ProductManagement\SubCategoryController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProductInfoCatController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProInfoCatTypeController;
use App\Http\Controllers\Backend\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProductAttributeController;
use App\Http\Controllers\Backend\Admin\ProductManagement\SubChildCategoryController;
use App\Http\Controllers\Backend\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProductAttributeValueController;
use App\Http\Controllers\Backend\Admin\ProductManagement\ProInfoCatTypeFeatureController;
use App\Http\Controllers\Backend\Admin\Auth\VerificationController as AdminVerificationController;
use App\Http\Controllers\Backend\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Backend\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;

// Admin Auth Routes
Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login'); // Admin Login Form
        Route::post('/login', 'login')->name('login.submit'); // Admin Login Submit (Handled by AuthenticatesUsers)
        Route::post('/logout', 'logout')->middleware('auth:admin')->name('logout'); // Admin Logout
    });

    Route::controller(AdminVerificationController::class)->group(function () {
        Route::get('email/verify',  'show')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}',  'verify')->middleware('signed')->name('verification.verify');
        Route::post('email/resend',  'resend')->middleware('throttle:6,1')->name('verification.resend');
    });


    Route::group(['as' => 'password.', 'prefix' => 'password'], function () {
        // Admin Forgot Password
        Route::controller(AdminForgotPasswordController::class)->group(function () {
            Route::get('/forgot', 'showLinkRequestForm')->name('forgot');
            Route::post('/forgot/request', 'sendResetLinkEmail')->name('forgot.request');
        });
        // Admin Password Reset
        Route::controller(AdminResetPasswordController::class)->group(function () {
            Route::get('/reset/{token}', 'showResetForm')->name('reset');
            Route::post('/reset', 'reset')->name('reset.request');
        });
    });
});

Route::controller(AxiosRequestController::class)->name('axios.')->group(function () {
    Route::get('get-states', 'getStates')->name('get-states');
    Route::get('get-states-or-cities', 'getStatesOrCities')->name('get-states-or-cities');
    Route::get('get-cities', 'getCities')->name('get-cities');
    Route::get('get-operation-areas', 'getOperationAreas')->name('get-operation-areas');
    Route::get('get-sub-areas', 'getSubAreas')->name('get-sub-areas');
    Route::post('get-sub-categories', 'getSubCategories')->name('get-sub-categories');
    Route::post('get-sub-child-categories', 'getSubChildCategories')->name('get-sub-child-categories');
    Route::post('get-brands', 'getBrands')->name('get-brands');
    Route::post('get-models', 'getModels')->name('get-models');
    Route::post('get-tax-rates', 'getTaxRates')->name('get-tax-rates');

    Route::post('get-info-category-types', 'getInfoCatTypes')->name('get-info-cat-types');
    Route::post('get-info-category-type-features', 'getInfoCatTypeFeatures')->name('get-info-cat-type-features');
});

Route::group(['middleware' => ['auth:admin', 'verified'], 'prefix' => 'admin'], function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Admin Profile
    Route::controller(AdminProfileContoller::class)->name('admin.')->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile/update', 'profileUpdate')->name('profile.update');
        Route::put('/address/update', 'addressUpdate')->name('address.update');
        Route::put('/password/update', 'passwordUpdate')->name('password.update');
    });

    //Developer Routes
    Route::get('/export-permissions', function () {
        $filename = 'permissions.csv';
        $filePath = createCSV($filename);
        return Response::download($filePath, $filename);
    })->name('permissions.export');




    // Admin Management
    Route::group(['as' => 'am.', 'prefix' => 'admin-management'], function () {
        Route::resource('admin', AdminController::class);
        Route::get('admin/status/{admin}', [AdminController::class, 'status'])->name('admin.status');
        Route::get('admin/recycle/bin', [AdminController::class, 'recycleBin'])->name('admin.recycle-bin');
        Route::get('admin/restore/{admin}', [AdminController::class, 'restore'])->name('admin.restore');
        Route::delete('admin/permanent-delete/{admin}', [AdminController::class, 'permanentDelete'])->name('admin.permanent-delete');


        // Role Management
        Route::resource('role', RoleController::class);
        Route::get('role/status/{role}', [RoleController::class, 'status'])->name('role.status');
        Route::get('role/recycle/bin', [RoleController::class, 'recycleBin'])->name('role.recycle-bin');
        Route::get('role/restore/{role}', [RoleController::class, 'restore'])->name('role.restore');
        Route::delete('role/permanent-delete/{role}', [RoleController::class, 'permanentDelete'])->name('role.permanent-delete');

        Route::resource('role', RoleController::class);
        Route::get('role/status/{role}', [RoleController::class, 'status'])->name('role.status');
        Route::resource('permission', PermissionController::class);
        Route::get('permission/status/{permission}', [PermissionController::class, 'status'])->name('permission.status');

        // permission Management
        Route::resource('permission', PermissionController::class);
        Route::get('permission/status/{permission}', [PermissionController::class, 'status'])->name('permission.status');
        Route::get('permission/recycle/bin', [PermissionController::class, 'recycleBin'])->name('permission.recycle-bin');
        Route::get('permission/restore/{permission}', [PermissionController::class, 'restore'])->name('permission.restore');
        Route::delete('permission/permanent-delete/{permission}', [PermissionController::class, 'permanentDelete'])->name('permission.permanent-delete');
    });

    // User Management
    Route::group(['as' => 'um.', 'prefix' => 'user-management'], function () {
        Route::resource('user', UserController::class);
        Route::get('user/status/{user}', [UserController::class, 'status'])->name('user.status');
        Route::get('user/recycle/bin', [UserController::class, 'recycleBin'])->name('user.recycle-bin');
        Route::get('user/restore/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('user/permanent-delete/{user}', [UserController::class, 'permanentDelete'])->name('user.permanent-delete');
    });



    // Setup Routes
    Route::group(['as' => 'setup.', 'prefix' => 'setup-management'], function () {
        // Route::controller(AxiosRequestController::class)->name('axios.')->group(function () {
        //     Route::get('get-states', 'getStates')->name('get-states');
        //     Route::get('get-states-or-cities', 'getStatesOrCities')->name('get-states-or-cities');
        //     Route::get('get-cities', 'getCities')->name('get-cities');
        //     Route::get('get-operation-areas', 'getOperationAreas')->name('get-operation-areas');
        //     Route::get('get-sub-areas', 'getSubAreas')->name('get-sub-areas');
        // });

        // Country Routes
        Route::resource('country', CountryController::class);
        Route::get('country/status/{country}', [CountryController::class, 'status'])->name('country.status');
        Route::get('country/recycle/bin', [CountryController::class, 'recycleBin'])->name('country.recycle-bin');
        Route::get('country/restore/{country}', [CountryController::class, 'restore'])->name('country.restore');
        Route::delete('country/permanent-delete/{country}', [CountryController::class, 'permanentDelete'])->name('country.permanent-delete');


        // State Routes
        Route::resource('state', StateController::class);
        Route::get('state/status/{state}', [StateController::class, 'status'])->name('state.status');
        Route::get('state/recycle/bin', [StateController::class, 'recycleBin'])->name('state.recycle-bin');
        Route::get('state/restore/{state}', [StateController::class, 'restore'])->name('state.restore');
        Route::delete('state/permanent-delete/{state}', [StateController::class, 'permanentDelete'])->name('state.permanent-delete');

        // City Routes
        Route::resource('city', CityController::class);
        Route::get('city/status/{state}', [CityController::class, 'status'])->name('city.status');
        Route::get('city/recycle/bin', [CityController::class, 'recycleBin'])->name('city.recycle-bin');
        Route::get('city/restore/{city}', [CityController::class, 'restore'])->name('city.restore');
        Route::delete('city/permanent-delete/{city}', [CityController::class, 'permanentDelete'])->name('city.permanent-delete');

        // Operation Area Routes
        Route::resource('operation-area', OperationAreaController::class);
        Route::get('operation-area/status/{operation_area}', [OperationAreaController::class, 'status'])->name('operation-area.status');
        Route::get('operation-area/recycle/bin', [OperationAreaController::class, 'recycleBin'])->name('operation-area.recycle-bin');
        Route::get('operation-area/restore/{operation_area}', [OperationAreaController::class, 'restore'])->name('operation-area.restore');
        Route::delete('operation-area/permanent-delete/{operation_area}', [OperationAreaController::class, 'permanentDelete'])->name('operation-area.permanent-delete');

        // Operation Sub Area Routes
        Route::resource('operation-sub-area', OperationSubAreaController::class);
        Route::get('operation-sub-area/status/{operation_sub_area}', [OperationSubAreaController::class, 'status'])->name('operation-sub-area.status');
        Route::get('operation-sub-area/recycle/bin', [OperationSubAreaController::class, 'recycleBin'])->name('operation-sub-area.recycle-bin');
        Route::get('operation-sub-area/restore/{operation_sub_area}', [OperationSubAreaController::class, 'restore'])->name('operation-sub-area.restore');
        Route::delete('operation-sub-area/permanent-delete/{operation_sub_area}', [OperationSubAreaController::class, 'permanentDelete'])->name('operation-sub-area.permanent-delete');
    });

    // Documentation
    Route::resource('documentation', DocumentationController::class);

    // Audit Management
    Route::controller(AuditController::class)->prefix('audits')->name('audit.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('details/{id}', 'details')->name('details');
    });
    // Temp File
    Route::controller(TempFileController::class)->prefix('temp-files')->name('temp.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('download/{path}', 'download')->name('download');
        Route::delete('delete/{id}', 'destroy')->name('destroy');
    });

    // Site Settings
    Route::controller(SiteSettingController::class)->prefix('site-settings')->name('site_setting.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('update', 'update')->name('update');
        Route::get('email-template/edit/{id}', 'et_edit')->name('email_template');
        Route::put('email-template/edit/{id}', 'et_update')->name('email_template');
        Route::post('notification/update', 'notification')->name('notification');
    });
    // CMS Management
    Route::group(['as' => 'cms.', 'prefix' => 'cms-management'], function () {

        // Banner Routes
        Route::resource('banner', BannerController::class);
        Route::get('banner/status/{banner}', [BannerController::class, 'status'])->name('banner.status');
        Route::get('banner/recycle/bin', [BannerController::class, 'recycleBin'])->name('banner.recycle-bin');
        Route::get('banner/restore/{banner}', [BannerController::class, 'restore'])->name('banner.restore');
        Route::delete('banner/permanent-delete/{banner}', [BannerController::class, 'permanentDelete'])->name('banner.permanent-delete');

        // FAQ Routes
        Route::resource('faq', FaqController::class);
        Route::get('faq/status/{faq}', [FaqController::class, 'status'])->name('faq.status');
        Route::get('faq/recycle/bin', [FaqController::class, 'recycleBin'])->name('faq.recycle-bin');
        Route::get('faq/restore/{faq}', [FaqController::class, 'restore'])->name('faq.restore');
        Route::delete('faq/permanent-delete/{faq}', [FaqController::class, 'permanentDelete'])->name('faq.permanent-delete');

        // Testimonial Routes
        Route::resource('testimonial', TestimonialController::class);

        Route::get('testimonial/status/{testimonial}', [TestimonialController::class, 'status'])->name('testimonial.status');
        Route::get('testimonial/recycle/bin', [TestimonialController::class, 'recycleBin'])->name('testimonial.recycle-bin');
        Route::get('testimonial/restore/{testimonial}', [TestimonialController::class, 'restore'])->name('testimonial.restore');
        Route::delete('testimonial/permanent-delete/{testimonial}', [TestimonialController::class, 'permanentDelete'])->name('testimonial.permanent-delete');
    });

    // Product Management
    Route::group(['as' => 'pm.', 'prefix' => 'product-management'], function () {
        // Product Attribute Routes
        Route::resource('product-attribute', ProductAttributeController::class);
        Route::get('product-attribute/status/{product_attribute}', [ProductAttributeController::class, 'status'])->name('product-attribute.status');
        Route::get('product-attribute/feature/{product_attribute}', [ProductAttributeController::class, 'feature'])->name('product-attribute.feature');
        Route::get('product-attribute/recycle/bin', [ProductAttributeController::class, 'recycleBin'])->name('product-attribute.recycle-bin');
        Route::get('product-attribute/restore/{product_attribute}', [ProductAttributeController::class, 'restore'])->name('product-attribute.restore');
        Route::delete('product-attribute/permanent-delete/{product_attribute}', [ProductAttributeController::class, 'permanentDelete'])->name('product-attribute.permanent-delete');

        // Product Attribute Value Routes
        Route::resource('product-attr-value', ProductAttributeValueController::class);
        Route::get('product-attr-value/status/{product_attr_value}', [ProductAttributeValueController::class, 'status'])->name('product-attr-value.status');
        Route::get('product-attr-value/feature/{product_attr_value}', [ProductAttributeValueController::class, 'feature'])->name('product-attr-value.feature');
        Route::get('product-attr-value/recycle/bin', [ProductAttributeValueController::class, 'recycleBin'])->name('product-attr-value.recycle-bin');
        Route::get('product-attr-value/restore/{product_attr_value}', [ProductAttributeValueController::class, 'restore'])->name('product-attr-value.restore');
        Route::delete('product-attr-value/permanent-delete/{product_attr_value}', [ProductAttributeValueController::class, 'permanentDelete'])->name('product-attr-value.permanent-delete');

        // Category Routes
        Route::resource('category', CategoryController::class);
        Route::get('category/status/{category}', [CategoryController::class, 'status'])->name('category.status');
        Route::get('category/feature/{category}', [CategoryController::class, 'feature'])->name('category.feature');
        Route::get('category/recycle/bin', [CategoryController::class, 'recycleBin'])->name('category.recycle-bin');
        Route::get('category/restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::delete('category/permanent-delete/{category}', [CategoryController::class, 'permanentDelete'])->name('category.permanent-delete');

        // Sub Category Routes
        Route::resource('sub-category', SubCategoryController::class);
        Route::get('sub-category/status/{sub_category}', [SubCategoryController::class, 'status'])->name('sub-category.status');
        Route::get('sub-category/feature/{sub_category}', [SubCategoryController::class, 'feature'])->name('sub-category.feature');
        Route::get('sub-category/recycle/bin', [SubCategoryController::class, 'recycleBin'])->name('sub-category.recycle-bin');
        Route::get('sub-category/restore/{sub_category}', [SubCategoryController::class, 'restore'])->name('sub-category.restore');
        Route::delete('sub-category/permanent-delete/{sub_category}', [SubCategoryController::class, 'permanentDelete'])->name('sub-category.permanent-delete');

        // Sub Child Category Routes
        Route::resource('sub-child-category', SubChildCategoryController::class);
        Route::get('sub-child-category/status/{sub_child_category}', [SubChildCategoryController::class, 'status'])->name('sub-child-category.status');
        Route::get('sub-child-category/feature/{sub_child_category}', [SubChildCategoryController::class, 'feature'])->name('sub-child-category.feature');
        Route::get('sub-child-category/recycle/bin', [SubChildCategoryController::class, 'recycleBin'])->name('sub-child-category.recycle-bin');
        Route::get('sub-child-category/restore/{sub_child_category}', [SubChildCategoryController::class, 'restore'])->name('sub-child-category.restore');
        Route::delete('sub-child-category/permanent-delete/{sub_child_category}', [SubChildCategoryController::class, 'permanentDelete'])->name('sub-child-category.permanent-delete');

        // Product Routes
        Route::resource('product', ProductController::class);
        Route::controller(ProductController::class)->name('product.')->prefix('product')->group(function () {
            Route::get('relation/{product}', 'relation')->name('relation');
            Route::get('images/{product}', 'images')->name('image');
            Route::get('information/{product}', 'info')->name('info');
            Route::get('status/{product}', 'status')->name('status');
            Route::get('feature/{product}', 'feature')->name('feature');
            Route::get('backorder/{product}',  'backorder')->name('backorder');
            Route::get('dropshipping/{product}', 'dropshipping')->name('dropshipping');
            Route::get('recycle/bin', 'recycleBin')->name('recycle-bin');
            Route::get('restore/{product}', 'restore')->name('restore');
            Route::delete('permanent-delete/{product}', 'permanentDelete')->name('permanent-delete');
            Route::post('relation/{product}', 'relationStore')->name('relation.store');
            Route::post('images/{product}', 'imageStore')->name('image.store');
            Route::post('information/{product}', 'infoStore')->name('info.store');
            Route::post('information/remarks/{product}', 'infoRemarkStore')->name('info.remarks.store');

            Route::get('view-remarks/{product_info_id}', 'viewRemarks')->name('view_remarks');
            Route::get('delete-info/{product_info_id}', 'deleteInfo')->name('delete_info');
            Route::get('entry-complete/{product}', 'entryComplete')->name('entry_complete');

            //Edit
            Route::get('edit-relation/{product}', 'editRelation')->name('relation.edit');
            Route::get('edit-image/{product}', 'editImage')->name('image.edit');
            Route::get('edit-info/{product}', 'editInfo')->name('info.edit');

            // update 
            Route::put('update-relation/{product}', 'updateRelation')->name('relation.update');
            Route::put('update-image/{product}', 'updateImage')->name('image.update');
            Route::put('update-info/{product}', 'updateInfo')->name('info.update');
        });

        // Company Routes
        Route::resource('company', CompanyController::class);
        Route::get('company/status/{company}', [CompanyController::class, 'status'])->name('company.status');
        Route::get('company/feature/{company}', [CompanyController::class, 'feature'])->name('company.feature');

        Route::get('company/recycle/bin', [CompanyController::class, 'recycleBin'])->name('company.recycle-bin');
        Route::get('company/restore/{company}', [CompanyController::class, 'restore'])->name('company.restore');
        Route::delete('company/permanent-delete/{company}', [CompanyController::class, 'permanentDelete'])->name('company.permanent-delete');

        // Brand Routes
        Route::resource('brand', BrandController::class);
        Route::get('brand/status/{brand}', [BrandController::class, 'status'])->name('brand.status');
        Route::get('brand/feature/{brand}', [BrandController::class, 'feature'])->name('brand.feature');

        Route::get('brand/recycle/bin', [BrandController::class, 'recycleBin'])->name('brand.recycle-bin');
        Route::get('brand/restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
        Route::delete('brand/permanent-delete/{brand}', [BrandController::class, 'permanentDelete'])->name('brand.permanent-delete');

        // Model Routes
        Route::resource('model', ModelController::class);
        Route::get('model/status/{model}', [ModelController::class, 'status'])->name('model.status');
        Route::get('model/feature/{model}', [ModelController::class, 'feature'])->name('model.feature');

        Route::get('model/recycle/bin', [ModelController::class, 'recycleBin'])->name('model.recycle-bin');
        Route::get('model/restore/{model}', [ModelController::class, 'restore'])->name('model.restore');
        Route::delete('model/permanent-delete/{model}', [ModelController::class, 'permanentDelete'])->name('model.permanent-delete');

        // Product Info Cat Routes
        Route::resource('product-info-category', ProductInfoCatController::class);
        Route::get('product-info-category/status/{product_info_category}', [ProductInfoCatController::class, 'status'])->name('product-info-category.status');

        Route::get('product-info-category/recycle/bin', [ProductInfoCatController::class, 'recycleBin'])->name('product-info-category.recycle-bin');
        Route::get('product-info-category/restore/{product_info_category}', [ProductInfoCatController::class, 'restore'])->name('product-info-category.restore');
        Route::delete('product-info-category/permanent-delete/{product_info_category}', [ProductInfoCatController::class, 'permanentDelete'])->name('product-info-category.permanent-delete');

        // Product Info Cat Type Routes
        Route::resource('product-info-category-type', ProInfoCatTypeController::class);
        Route::get('product-info-category-type/status/{product_info_category_type}', [ProInfoCatTypeController::class, 'status'])->name('product-info-category-type.status');

        Route::get('product-info-category-type/recycle/bin', [ProInfoCatTypeController::class, 'recycleBin'])->name('product-info-category-type.recycle-bin');
        Route::get('product-info-category-type/restore/{product_info_category_type}', [ProInfoCatTypeController::class, 'restore'])->name('product-info-category-type.restore');
        Route::delete('product-info-category-type/permanent-delete/{product_info_category_type}', [ProInfoCatTypeController::class, 'permanentDelete'])->name('product-info-category-type.permanent-delete');

        // Product Info Cat Type Feature Routes
        Route::resource('product-info-category-type-feature', ProInfoCatTypeFeatureController::class)
            ->parameters([
                'product-info-category-type-feature' => 'pro_info_cat_tf', // use shorter name
            ])->names('pro-info-cat-tf');
        Route::get('product-info-category-type-feature/status/{pro_info_cat_tf}', [ProInfoCatTypeFeatureController::class, 'status'])->name('pro-info-cat-tf.status');

        Route::get('product-info-category-type-feature/recycle/bin', [ProInfoCatTypeFeatureController::class, 'recycleBin'])->name('pro-info-cat-tf.recycle-bin');
        Route::get('product-info-category-type-feature/restore/{pro_info_cat_tf}', [ProInfoCatTypeFeatureController::class, 'restore'])->name('pro-info-cat-tf.restore');
        Route::delete('product-info-category-type-feature/permanent-delete/{pro_info_cat_tf}', [ProInfoCatTypeFeatureController::class, 'permanentDelete'])->name('pro-info-cat-tf.permanent-delete');
        // Tax Class Routes
        Route::resource('tax-class', TaxClassController::class);
        Route::get('tax-class/status/{tax_class}', [TaxClassController::class, 'status'])->name('tax-class.status');
        Route::get('tax-class/feature/{tax_class}', [TaxClassController::class, 'feature'])->name('tax-class.feature');

        Route::get('tax-class/recycle/bin', [TaxClassController::class, 'recycleBin'])->name('tax-class.recycle-bin');
        Route::get('tax-class/restore/{tax_class}', [TaxClassController::class, 'restore'])->name('tax-class.restore');
        Route::delete('tax-class/permanent-delete/{tax_class}', [TaxClassController::class, 'permanentDelete'])->name('tax-class.permanent-delete');

        // Tax Rate Routes
        Route::resource('tax-rate', TaxRateController::class);
        Route::get('tax-rate/status/{tax_rate}', [TaxRateController::class, 'status'])->name('tax-rate.status');
        Route::get('tax-rate/feature/{tax_rate}', [TaxRateController::class, 'feature'])->name('tax-rate.feature');

        Route::get('tax-rate/recycle/bin', [TaxRateController::class, 'recycleBin'])->name('tax-rate.recycle-bin');
        Route::get('tax-rate/restore/{tax_rate}', [TaxRateController::class, 'restore'])->name('tax-rate.restore');
        Route::delete('tax-rate/permanent-delete/{tax_rate}', [TaxRateController::class, 'permanentDelete'])->name('tax-rate.permanent-delete');
    });

    // Auction Management
    Route::group(['as' => 'auction-m.', 'prefix' => 'auction-management'], function () {
        // Auction Routes 
        Route::resource('auction', AuctionController::class);
        Route::controller(AuctionController::class)->name('auction.')->prefix('auction')->group(function () {
            Route::get('feature/{auction}', 'feature')->name('feature');
            Route::get('recycle/bin', 'recycleBin')->name('recycle-bin');
            Route::get('restore/{auction}', 'restore')->name('restore');
            Route::delete('permanent-delete/{auction}', 'permanentDelete')->name('permanent-delete');
            Route::post('relation/{auction}', 'relationStore')->name('relation.store');
        });
    });

    // Supplier Management
    Route::group(['as' => 'sm.', 'prefix' => 'supplier-management'], function () {
        Route::resource('supplier', SuppliersController::class);
        Route::get('supplier/status/{supplier}', [SuppliersController::class, 'status'])->name('supplier.status');
        Route::get('supplier/recycle/bin', [SuppliersController::class, 'recycleBin'])->name('supplier.recycle-bin');
        Route::get('supplier/restore/{supplier}', [SuppliersController::class, 'restore'])->name('supplier.restore');
        Route::delete('supplier/permanent-delete/{supplier}', [SuppliersController::class, 'permanentDelete'])->name('supplier.permanent-delete');
    });
});
