<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'shipping_id',
        'shipping_cost',
        'sub_total',
        'total',
        'note',

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

    public const STATUS_PENDING = '0';
    public const STATUS_CONFIRM = '1';
    public const STATUS_SHIPPED = '2';
    public const STATUS_DELIVERED = '3';
    public const STATUS_CANCELED = '4';

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
}
