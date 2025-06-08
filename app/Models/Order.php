<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'container_id',
        'order_number',
        'status',
        'shipping_id',
        'shipping_cost',
        'sub_total',
        'total',
        'note',

        'shipping_port',
        'destination_port',
        'container_type',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color_label',
        ]);
    }

    public const STATUS_INITIATED = '1';
    public const STATUS_PENDING = '2';
    public const STATUS_CONFIRM = '3';
    public const STATUS_SHIPPED = '4';
    public const STATUS_DELIVERED = '5';
    public const STATUS_CANCELED = '6';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Address::class);
    }
    public function getStatusLabels()
    {
        return [
            self::STATUS_INITIATED => 'Initiated',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRM => 'Confirm',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELED => 'Canceled',
        ];
    }

    public function getStatusBtnLabels()
    {
        return [
            self::STATUS_INITIATED => 'Initiated',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRM => 'Confirm',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELED => 'Canceled',
        ];
    }
    public function getStatusColors()
    {
        return [
            self::STATUS_INITIATED => 'btn-secondary',
            self::STATUS_PENDING => 'btn-primary',
            self::STATUS_CONFIRM => 'btn-warning',
            self::STATUS_SHIPPED => 'btn-info',
            self::STATUS_DELIVERED => 'btn-success',
            self::STATUS_CANCELED => 'btn-danger',
        ];
    }

    public function getStatuslabelAttribute(): string
    {
        return $this->getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorLabelAttribute(): string
    {
        return $this->getStatusColors()[$this->status] ?? 'btn-secondary';
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class, 'container_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public const GROUP_SHIPPING = 1;
    public const FULL_CONTAINER = 2;


    public static function getContainerTypeLabels()
    {
        return [
            self::GROUP_SHIPPING => 'Group Shipping',
            self::FULL_CONTAINER => 'Full Container',
        ];
    }
    public function getContainerTypeLabelAttribute(): string
    {
        return $this->getContainerTypeLabels()[$this->container_type] ?? 'Unknown';
    }

    public function shippingPort()
    {
        return $this->belongsTo(ShippingLocation::class, 'shipping_port', 'id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(ShippingLocation::class, 'destination_port', 'id');
    }
}
