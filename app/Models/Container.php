<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Container extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'title',
        'slug',
        'image',
        'deadline',
        'length_m',
        'width_m',
        'height_m',
        'max_weight_kg',
        'base_cost',
        'per_kg_cost',
        'per_cbm_cost',
        'shipping_port',
        'destination_port',
        'status',
        'departure_date',
        'estimated_delivery_days',


        'created_by',
        'updated_by',
        'deleted_by',
    ];



    public function shippingPort()
    {
        return $this->belongsTo(ShippingLocation::class, 'shipping_port', 'id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(ShippingLocation::class, 'destination_port', 'id');
    }


    public function getModifiedImageAttribute(): string
    {
        return storage_url($this->image);
    }

    public function containerProducts()
    {
        return $this->hasMany(ContainerProduct::class, 'container_id', 'id');
    }

    public function containerReservations()
    {
        return $this->hasMany(ContainerReservation::class, 'container_id', 'id');
    }

    public function getReservedDimensions()
    {
        // Cache on the instance to prevent re-querying
        if (!isset($this->reservedDimensions)) {
            $this->reservedDimensions = $this->containerReservations()
                ->whereNot('status', ContainerReservation::STATUS_DECLINE)
                ->selectRaw('SUM(length_m) as length, SUM(width_m) as width, SUM(height_m) as height')
                ->whereNull('deleted_at') // optional if soft deletes used
                ->first();
        }

        return $this->reservedDimensions;
    }

    public function calculateFreeSpacePercentage()
    {
        $reserved = $this->getReservedDimensions();

        $reservedVolume = (float) $reserved->length * (float) $reserved->width * (float) $reserved->height;
        $totalSpace = (float) $this->length_m * (float) $this->width_m * (float) $this->height_m;

        if ($totalSpace == 0) {
            return 0;
        }

        $freeSpacePercentage = ($totalSpace - $reservedVolume) / $totalSpace * 100;
        return round($freeSpacePercentage, 2);
    }
    public function getFilledPercentageAttribute()
    {
        $reserved = $this->getReservedDimensions();

        $reservedVolume = (float) $reserved->length * (float) $reserved->width * (float) $reserved->height;
        $totalSpace = (float) $this->length_m * (float) $this->width_m * (float) $this->height_m;

        if ($totalSpace == 0) {
            return 0;
        }

        $filledPercentage = $reservedVolume / $totalSpace * 100;
        return round($filledPercentage, 2);
    }

    public function getContainerFreeSpaceCbmAttribute()
    {
        $reserved = $this->getReservedDimensions();
        $freeSpace = $this->length_m * $this->width_m * $this->height_m - $reserved->length * $reserved->width * $reserved->height;
        return round($freeSpace, 2);
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

            'modified_image',
            'filled_percentage',
            'container_free_space_cbm',
            'reserve_status_label',
        ]);
    }


    // ================= Status Functionality Start Here =================

    // Status constants
    public const STATUS_ACTIVE = 1;
    public const STATUS_PENDING = 2;
    public const STATUS_DELIVERED = 3;
    public const STATUS_SHIPPED = 4;

    // Status labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_SHIPPED => 'Shipped',
        ];
    }

    // Status button labels
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_SHIPPED => 'Shipped',
        ];
    }

    // Status colors for labels (you can expand this)
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_PENDING => 'bg-primary',
            self::STATUS_DELIVERED => 'bg-warning',
            self::STATUS_SHIPPED => 'bg-info',
        ];
    }

    // Button colors for status buttons (bootstrap btn classes)
    public static function getStatusBtnColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'btn btn-warning',
            self::STATUS_PENDING => 'btn btn-success',
            self::STATUS_DELIVERED => 'btn btn-primary',
            self::STATUS_SHIPPED => 'btn btn-info',
        ];
    }

    // Accessor for all status labels
    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }

    // Accessor for current status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for current status color
    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    // Accessor for current status button label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for current status button color
    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn btn-secondary';
    }

    // Query scopes for each status
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)->where('full_container_reserved', self::NOT_FULL_RESERVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function getUsedLengthAttribute()
    {
        return $this->containerReservations()->sum('length_m');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'container_id', 'id');
    }


    public const NOT_FULL_RESERVED = 1;
    public const FULL_RESERVED = 2;

    // Status labels
    public static function getReserveStatusLabels(): array
    {
        return [
            self::NOT_FULL_RESERVED => 'Not Full Reserved',
            self::FULL_RESERVED => 'Full Reserved',
        ];
    }

    // Status button labels
    public function getReserveStatusLabelAttribute(): string
    {
        return self::getReserveStatusLabels()[$this->full_container_reserved] ?? 'Unknown';
    }
}
