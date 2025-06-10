<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'container_request',

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
            'status_color',
            'status_tailwind_color',
        ]);
    }

    public const STATUS_INITIATED = '1';
    public const STATUS_PENDING = '2';
    public const STATUS_SUBMITTED = '3';
    public const STATUS_CONFIRM = '4';
    public const STATUS_SHIPPED = '5';
    public const STATUS_DELIVERED = '6';
    public const STATUS_CANCELED = '7';

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
            self::STATUS_SUBMITTED => 'Submitted',
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
            self::STATUS_SUBMITTED => 'Submitted',
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
            self::STATUS_PENDING => 'btn-warning',
            self::STATUS_SUBMITTED => 'btn-info',
            self::STATUS_CONFIRM => 'btn-primary',
            self::STATUS_SHIPPED => 'btn-info',
            self::STATUS_DELIVERED => 'btn-success',
            self::STATUS_CANCELED => 'btn-danger',
        ];
    }
    public function getStatusTailwindColors()
    {
        return [
            self::STATUS_INITIATED => 'bg-gray-800',
            self::STATUS_PENDING => 'bg-yellow-800',
            self::STATUS_SUBMITTED => 'bg-green-800',
            self::STATUS_CONFIRM => 'bg-blue-800',
            self::STATUS_SHIPPED => 'bg-indigo-800',
            self::STATUS_DELIVERED => 'bg-green-800',
            self::STATUS_CANCELED => 'bg-red-800',
        ];
    }

    public function getStatuslabelAttribute(): string
    {
        return $this->getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->getStatusColors()[$this->status] ?? 'btn-secondary';
    }
    public function getStatusTailwindColorAttribute(): string
    {
        return $this->getStatusTailwindColors()[$this->status] ?? 'bg-gray-800';
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


    public const CONTINER_REQUEST_TRUE = 1;
    public const CONTINER_REQUEST_FALSE = 2;


    public static function getContainerRequestLabels()
    {
        return [
            self::CONTINER_REQUEST_TRUE => 'Yes',
            self::CONTINER_REQUEST_FALSE => 'No',
        ];
    }
    public function getContainerRequestLabelAttribute(): string
    {
        return $this->getContainerRequestLabels()[$this->container_request] ?? 'Unknown';
    }

    public function scopeSelf(Builder $query)
    {
        return $query->where('user_id', user()->id);
    }
    public function scopePending(Builder $query)
    {
        return $query->where('status', self::STATUS_PENDING)->orWhere('status', self::STATUS_INITIATED);
    }
    public function scopeSubmitted(Builder $query)
    {
        return $query->where('status', self::STATUS_SUBMITTED);
    }
    public function scopeShipped(Builder $query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }
    public function scopeCompleted(Builder $query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }


    public function containerReservation(): HasOne
    {
        return $this->hasOne(ContainerReservation::class, 'order_id', 'id');
    }
}
