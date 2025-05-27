<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


class Product extends BaseModel
{
    protected $fillable = [
        'sort_order',
        'name',
        'slug',
        'sku',

        'stock_no',
        'grade',
        'body',
        'first_registration',
        'type',
        'displacement',
        'specification_no',
        'classification_no',
        'chassis_no',
        'serial_no',
        'capacity',
        'remarks',
        'engine_type',
        'fuel_type',
        'color',
        'mileage',
        'odometer_replacement',
        'steering_wheel',
        'transmission',
        'drive_system',
        'entry_status',
        'year',

        'short_description',
        'description',

        'price',
        'cost_price',
        'sale_price',
        'quantity',
        'status',
        'is_featured',
        'supplier_id',
        'product_type',

        'source_url',

        'length_cm',
        'width_cm',
        'height_cm',
        'weight_kg',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function productVolume()
    {
        return $this->length_cm * $this->width_cm;
    }

    public function productReserves(): HasMany
    {
        return $this->hasMany(ProductReserve::class);
    }

    public function productInquiries(): HasMany
    {
        return $this->hasMany(ProductInquiry::class);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [

            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',
            'status_labels',

            'featured_label',
            'featured_color',
            'featured_btn_label',
            'featured_btn_color',
            'featured_labels',
        ]);
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function productInformations(): HasMany
    {
        return $this->hasMany(ProductInformation::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id', 'id');
    }

    public function relation(): HasOne
    {
        return $this->hasOne(ProductRelation::class);
    }

    // Brand, Company, Model
    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(Company::class, ProductRelation::class, 'product_id', 'id', 'id', 'company_id');
    }

    public function brand(): HasOneThrough
    {
        return $this->hasOneThrough(Brand::class, ProductRelation::class, 'product_id', 'id', 'id', 'brand_id');
    }

    public function model(): HasOneThrough
    {
        return $this->hasOneThrough(Model::class, ProductRelation::class, 'product_id', 'id', 'id', 'model_id');
    }

    // Tax Class & Rate
    public function taxClass(): HasOneThrough
    {
        return $this->hasOneThrough(TaxClass::class, ProductRelation::class, 'product_id', 'id', 'id', 'tax_class_id');
    }

    public function taxRate(): HasOneThrough
    {
        return $this->hasOneThrough(TaxRate::class, ProductRelation::class, 'product_id', 'id', 'id', 'tax_rate_id');
    }

    public function category(): HasOneThrough
    {
        return $this->hasOneThrough(Category::class, ProductRelation::class, 'product_id', 'id', 'id', 'category_id');
    }


    public function subCategory(): HasOneThrough
    {
        return $this->hasOneThrough(Category::class, ProductRelation::class, 'product_id', 'id', 'id', 'sub_category_id');
    }

    public function subChildCategory(): HasOneThrough
    {
        return $this->hasOneThrough(Category::class, ProductRelation::class, 'product_id', 'id', 'id', 'sub_child_category_id');
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }


    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function primaryImage(): HasMany
    {
        return $this->images()->primary();
    }
    public function nonPrimayImages(): HasMany
    {
        return $this->images()->notPrimary();
    }
    public function activeImages(): HasMany
    {
        return $this->images()->active();
    }



    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;
    // Status labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'Deactive',
        ];
    }

    // Status btn labels
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Deactive',
            self::STATUS_DEACTIVE => 'Active',
        ];
    }

    // Accessor for status labels
    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }

    // Accessor for status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }
    // Accessor for status color
    public function getStatusColorAttribute(): string
    {
        return $this->status == self::STATUS_ACTIVE ? 'bg-success' : 'bg-warning';
    }

    // Accessor for status label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for status btn color
    public function getStatusBtnColorAttribute(): string
    {
        return $this->status == self::STATUS_ACTIVE ? 'btn btn-warning' : 'btn btn-success';
    }

    public function scopeActive($query): mixed
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeDeactive($query): mixed
    {
        return $query->where('status', self::STATUS_DEACTIVE);
    }


    // ========================================Featured labels

    public const FEATURED = 1;
    public const NOT_FEATURED = 0;
    // Featured labels
    public static function getFeaturedLabels(): array
    {
        return [
            self::FEATURED => 'Featured',
            self::NOT_FEATURED => 'Not Featured',
        ];
    }
    // Featured btn labels
    public static function getFeaturedBtnLabels(): array
    {
        return [
            self::FEATURED => 'Remove From Featured',
            self::NOT_FEATURED => 'Make Featured',
        ];
    }
    // Accessor for Featured labels
    public function getFeaturedLabelsAttribute(): array
    {
        return self::getFeaturedLabels();
    }

    // Accessor for Featured label
    public function getFeaturedLabelAttribute(): string
    {
        return self::getFeaturedLabels()[$this->is_featured] ?? 'Unknown';
    }
    // Accessor for Featured color
    public function getFeaturedColorAttribute(): string
    {
        return $this->is_featured == self::FEATURED ? 'bg-primary' : 'bg-info';
    }

    // Accessor for Featured label
    public function getFeaturedBtnLabelAttribute(): string
    {
        return self::getFeaturedBtnLabels()[$this->is_featured] ?? 'Unknown';
    }

    // Accessor for Featured btn color
    public function getFeaturedBtnColorAttribute(): string
    {
        return $this->is_featured == self::FEATURED ? 'btn btn-info' : 'btn btn-primary';
    }

    public function scopeFeatured($query): mixed
    {
        return $query->where('is_featured', self::FEATURED);
    }

    public function scopeNotFeatured($query): mixed
    {
        return $query->where('is_featured', self::NOT_FEATURED);
    }

    // Entry Status labels
    public const ENTRY_STATUS_BASIC = 0;
    public const ENTRY_STATUS_RELATION = 1;
    public const ENTRY_STATUS_IMAGE = 2;
    public const ENTRY_STATUS_INFORMATION = 3;
    public const ENTRY_STATUS_COMPLETE = 4;

    public function scopeBasic($query): mixed
    {
        return $query->where('entry_status', self::ENTRY_STATUS_BASIC);
    }
    public function scopeRelation($query): mixed
    {
        return $query->where('entry_status', self::ENTRY_STATUS_RELATION);
    }
    public function scopeImage($query): mixed
    {
        return $query->where('entry_status', self::ENTRY_STATUS_IMAGE);
    }
    public function scopeInformation($query): mixed
    {
        return $query->where('entry_status', self::ENTRY_STATUS_INFORMATION);
    }
    public function scopeComplete($query): mixed
    {
        return $query->where('entry_status', self::ENTRY_STATUS_COMPLETE);
    }

    // Product Types
    public const PRODUCT_TYPE_PARTS = 1;
    public const PRODUCT_TYPE_NORMAL = 2;
    public const PRODUCT_TYPE_DROPSHIPPING = 3;

    public function scopeParts($query): mixed
    {
        return $query->where('product_type', self::PRODUCT_TYPE_PARTS);
    }
    public function scopeNormal($query): mixed
    {
        return $query->where('product_type', self::PRODUCT_TYPE_NORMAL);
    }
    public function scopeDropshipping($query): mixed
    {
        return $query->where('product_type', self::PRODUCT_TYPE_DROPSHIPPING);
    }

    public static function getProductTypes(): array
    {
        return [
            self::PRODUCT_TYPE_NORMAL => 'Normal',
            self::PRODUCT_TYPE_PARTS => 'Parts & Accessories',
            self::PRODUCT_TYPE_DROPSHIPPING => 'Dropshipping',
        ];
    }

    public function getProductTypeLabelAttribute(): string
    {
        return self::getProductTypes()[$this->product_type] ?? 'Unknown';
    }
}
