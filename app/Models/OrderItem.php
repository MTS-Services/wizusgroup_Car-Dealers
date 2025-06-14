<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends BaseModel
{
    use HasFactory;


    protected $fillable = [
        'sort_order',
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'sub_total',
        'discount',
        'total',
        'is_dropshipping',
        'status',
        'dropshipping_status',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public const STATUS_PENDING = '0';
    public const STATUS_CONFIRM = '1';
    public const STATUS_SHIPPED = '2';
    public const STATUS_DELIVERED = '3';
    public const STATUS_CANCELED = '4';

    public const STATUS_DROPSHIPPING_PENDING = '0';
    public const STATUS_DROPSHIPPING_CONFIRM = '1';
    public const STATUS_DROPSHIPPING_SHIPPED = '2';
    public const STATUS_DROPSHIPPING_DELIVERED = '3';
    public const STATUS_DROPSHIPPING_CANCELED = '4';

    public const DROPSHIPPING = '1';
    public const NOT_DROPSHIPPING = '0';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color_label',
            // 'dropshipping_status_label',
            // 'dropshipping_status_color_label',
            // 'dropshipping_label',
            // 'dropshipping_color_label',

        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // Status labels
    public function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRM => 'Confirm',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELED => 'Canceled',
        ];
    }

    public function getStatusColors(): array
    {
        return [
            self::STATUS_PENDING => 'btn-primary',
            self::STATUS_CONFIRM => 'btn-warning',
            self::STATUS_SHIPPED => 'btn-info',
            self::STATUS_DELIVERED => 'btn-success',
            self::STATUS_CANCELED => 'btn-danger',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->getStatusLabels()[$this->status];
    }

    public function getStatusColorLabelAttribute(): string
    {
        return $this->getStatusColors()[$this->status];
    }

    // Dropshipping Status
    public function getDropshippingStatusLabels(): array
    {
        return [
            self::STATUS_DROPSHIPPING_PENDING => 'Pending',
            self::STATUS_DROPSHIPPING_CONFIRM => 'Confirm',
            self::STATUS_DROPSHIPPING_SHIPPED => 'Shipped',
            self::STATUS_DROPSHIPPING_DELIVERED => 'Delivered',
            self::STATUS_DROPSHIPPING_CANCELED => 'Canceled',
        ];
    }

    public function getDropshippingStatusColors(): array
    {
        return [
            self::STATUS_DROPSHIPPING_PENDING => 'btn-primary',
            self::STATUS_DROPSHIPPING_CONFIRM => 'btn-warning',
            self::STATUS_DROPSHIPPING_SHIPPED => 'btn-info',
            self::STATUS_DROPSHIPPING_DELIVERED => 'btn-success',
            self::STATUS_DROPSHIPPING_CANCELED => 'btn-danger',
        ];
    }

    // public function getDropshippingStatusLabelAttribute(): string
    // {
    //     return $this->getDropshippingStatusLabels()[$this->dropshipping_status];
    // }

    // public function getDropshippingStatusColorLabelAttribute(): string
    // {
    //     return $this->getDropshippingStatusColors()[$this->dropshipping_status];
    // }

    // Dropshipping labels
    public function getDropshippingLabels(): array
    {
        return [
            self::DROPSHIPPING => 'Yes',
            self::NOT_DROPSHIPPING => 'No',
        ];
    }

    public function getDropshippingColors(): array
    {
        return [
            self::DROPSHIPPING => 'btn-success',
            self::NOT_DROPSHIPPING => 'btn-danger',
        ];
    }

    public function getDropshippingLabelAttribute(): string
    {
        return $this->getDropshippingLabels()[$this->dropshipping];
    }

    public function getDropshippingColorLabelAttribute(): string
    {
        return $this->getDropshippingColors()[$this->dropshipping];
    }
}
