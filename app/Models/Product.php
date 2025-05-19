<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


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

        'short_description',
        'description',
        'price',
        'cost_price',
        'sale_price',
        'quantity',
        'allow_backorder',
        'status',
        'is_featured',
        'is_dropshipping',
        'supplier_id',

        'meta_title',
        'meta_description',
        'meta_keywords',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

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

            'dropshipping_label',
            'dropshipping_color',
            'dropshipping_btn_label',
            'dropshipping_btn_color',
            'dropshipping_labels',
        ]);
    }

    public function productInformations(): HasMany
    {
        return $this->hasMany(ProductInformation::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class,'product_id','id');
    }

    public function relation()
    {
        return $this->hasOne(ProductRelation::class);
    }
    // Brand, Company, Model
    public function company()
    {
        return $this->hasOneThrough(Company::class, ProductRelation::class, 'product_id', 'id', 'id', 'company_id');
    }

    public function brand()
    {
        return $this->hasOneThrough(Brand::class, ProductRelation::class, 'product_id', 'id', 'id', 'brand_id');
    }

    public function model()
    {
        return $this->hasOneThrough(Brand::class, ProductRelation::class, 'product_id', 'id', 'id', 'model_id');
    }

    // Tax Class & Rate
    public function taxClass()
    {
        return $this->hasOneThrough(TaxClass::class, ProductRelation::class, 'product_id', 'id', 'id', 'tax_class_id');
    }

    public function taxRate()
    {
        return $this->hasOneThrough(TaxRate::class, ProductRelation::class, 'product_id', 'id', 'id', 'tax_rate_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }


    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
    public function productActiveImages(): HasMany
    {
        return $this->productImages()->active();
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

    // ========================================Dropshipping labels

    public const ALLOW_DROPSHIPPING = 1;
    public const NOTALLOW_DROPSHIPPING = 0;

    // Dropshipping labels
    public static function getDropshippingLabels(): array
    {
        return [
            self::ALLOW_DROPSHIPPING => 'Allow',
            self::NOTALLOW_DROPSHIPPING => 'Not Allow',
        ];
    }

    // Dropshipping btn labels
    public static function getDropshippingBtnLabels(): array
    {
        return [
            self::ALLOW_DROPSHIPPING => 'Remove From Dropshipping',
            self::NOTALLOW_DROPSHIPPING => 'Make Dropshipping',
        ];
    }

    // Accessor for Dropshipping labels
    public function getDropshippingLabelsAttribute(): array
    {
        return self::getDropshippingLabels();
    }

    // Accessor for Dropshipping label
    public function getDropshippingLabelAttribute(): string
    {
        return self::getDropshippingLabels()[$this->is_dropshipping] ?? 'Unknown';
    }
    // Accessor for Dropshipping color
    public function getDropshippingColorAttribute(): string
    {
        return $this->is_dropshipping == self::ALLOW_DROPSHIPPING ? 'bg-primary' : 'bg-info';
    }

    // Accessor for Dropshipping label
    public function getDropshippingBtnLabelAttribute(): string
    {
        return self::getDropshippingBtnLabels()[$this->is_dropshipping] ?? 'Unknown';
    }

    // Accessor for Dropshipping btn color
    public function getDropshippingBtnColorAttribute(): string
    {
        return $this->is_dropshipping == self::ALLOW_DROPSHIPPING ? 'btn btn-info': 'btn btn-primary';
    }

    public function scopeDropshipping($query): mixed
    {
        return $query->where('is_dropshipping', self::ALLOW_DROPSHIPPING);
    }

    public function scopeNotDropshipping($query): mixed
    {
        return $query->where('is_dropshipping', self::NOTALLOW_DROPSHIPPING);
    }





}
