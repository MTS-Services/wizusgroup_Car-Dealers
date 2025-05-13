<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends BaseModel
{

    protected $fillable = [
        'sort_order',
        'profile_id',
        'profile_type',
        'type',
        'name',
        'email',
        'phone',
        'country_id',
        'state_id',
        'city_id',
        'operation_area_id',
        'operation_sub_area_id',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'latitude',
        'longitude',
        'is_default_shipping',
        'is_default_billing',
        'status',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    // Relations
    public function profile(): MorphTo
    {
        return $this->morphTo();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    
    
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function operationArea(): BelongsTo
    {
        return $this->belongsTo(OperationArea::class, 'operation_area_id');
    }

    public function operationSubArea(): BelongsTo
    {
        return $this->belongsTo(OperationSubArea::class, 'operation_sub_area_id');
    }

    // End Relations

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',
            'status_labels',

            'type_label',
            'default_label',
        ]);
    }


    // ================= Status Functionality Start Here =================
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



    // Status colors
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'bg-success', // Green for active
            self::STATUS_DEACTIVE => 'bg-warning', // Red for deactive
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

    // Status btn colors
    public static function getStatusBtnColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'btn btn-warning', // Green for active
            self::STATUS_DEACTIVE => 'btn btn-success', // Red for deactive
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
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    // Accessor for status label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for status btn color
    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn btn-secondary';
    }

    // ================= Status Functionality End Here =================

    // ================= Type Functionality End Here =================

    public const TYPE_PERSONAL = 1;
    public const TYPE_BILLING = 2;
    public const TYPE_SHIPPING = 3;
    public const TYPE_OTHER = 4;
    // Type labels
    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_PERSONAL => 'Personal',
            self::TYPE_BILLING => 'Billing',
            self::TYPE_SHIPPING => 'Shipping',
            self::TYPE_OTHER => 'Other',
        ];
    }
    // Assessor for type labels
    public function getTypeLabelsAttribute(): array
    {
        return self::getTypeLabels();
    }

    // Accessor for type label
    public function getTypeLabelAttribute(): string
    {
        return self::getTypeLabels()[$this->type] ?? 'Unknown';
    }

    // ================= Type Functionality End Here =================

    // ================= Default Functionality End Here =================

    public const DEFAULT = 1;
    public const NOT_DEFAULT = 0;
    // Default labels
    public static function getDefaultLabels(): array
    {
        return [
            self::DEFAULT => 'Default',
            self::NOT_DEFAULT => 'Not Default',
        ];
    }
    // Assessor for default labels
    public function getDefaultLabelsAttribute(): array
    {
        return self::getDefaultLabels();
    }

    // Accessor for default label
    public function getDefaultLabelAttribute(): string
    {
        return self::getDefaultLabels()[$this->is_default] ?? 'Unknown';
    }

    public function scopeAdminAddresses($query)
    {
        return $query->where('profile_id', admin()->id)->where('profile_type', get_class(admin()));
    }
    public function scopeUserAddresses($query)
    {
        return $query->where('profile_id', user()->id)->where('profile_type', get_class(user()));
    }
    // public function scopeStaffAddresses($query)
    // {
    //     return $query->where('profile_id', staff()->id)->where('profile_type', get_class(staff()));
    // }

    public function scopePersonal(){
        return $this->where('type', self::TYPE_PERSONAL);
    }

    public function scopeBilling(){
        return $this->where('type', self::TYPE_BILLING);
    }

    public function scopeShipping(){
        return $this->where('type', self::TYPE_SHIPPING);
    }
}
