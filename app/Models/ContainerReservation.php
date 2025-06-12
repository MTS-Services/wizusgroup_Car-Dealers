<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContainerReservation extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'sort_order',
        'container_id',
        'user_id',
        'product_id',
        'order_id',
        'email',
        'whatsapp',
        'quantity',
        'length_m',
        'width_m',
        'height_m',
        'weight_kg',
        'price',
        'reserve_price',
        'note',
        'status',


        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    // relationships
    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }
    public function containerProduct(): BelongsTo
    {
        return $this->belongsTo(ContainerProduct::class, 'container_product_id', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // ✅ Status constants
    public const STATUS_PENDING = 1;
    public const STATUS_ACCEPT = 2;
    public const STATUS_DECLINE = 3;

    // ✅ These attributes will be automatically appended to model JSON
    protected $appends = [
        'status_label',
        'status_color',
        'status_labels',
        'status_btn_label',
        'status_btn_color',
    ];


    // ✅ All status display labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_ACCEPT => 'Accepted',
            self::STATUS_DECLINE => 'Declined',
        ];
    }

    // ✅ Labels for status toggle buttons
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Accept',
            self::STATUS_ACCEPT => 'Decline',
            self::STATUS_DECLINE => 'Pending',
        ];
    }

    // ✅ Background color classes for status badges (Bootstrap classes)
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_PENDING => 'bg-warning',   // Orange
            self::STATUS_ACCEPT => 'bg-success',    // Green
            self::STATUS_DECLINE => 'bg-danger',    // Red
        ];
    }

    // ✅ Button color classes for status toggle buttons
    public static function getStatusBtnColors(): array
    {
        return [
            self::STATUS_PENDING => 'btn-warning',
            self::STATUS_ACCEPT => 'btn-success',
            self::STATUS_DECLINE => 'btn-danger',
        ];
    }

    // ✅ Accessors

    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn-secondary';
    }

    // ✅ Scopes for querying by status
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAccept($query)
    {
        return $query->where('status', self::STATUS_ACCEPT);
    }

    public function scopeDecline($query)
    {
        return $query->where('status', self::STATUS_DECLINE);
    }

    public function scopeSelf(Builder $query)
    {
        return $query->where('user_id', user()->id);
    }

}
