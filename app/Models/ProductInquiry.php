<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductInquiry extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'status',
        'in_name',
        'in_email',
        'in_whatsapp_number',
        'sort_order',

        'creater_id',
        'updater_id',
        'deleter_id',
        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color_label',
        ]);
    }

    public const STATUS_PENDING = 0;
    public const STATUS_COMPLETE = 1;
    public const STATUS_CANCLED = 2;

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETE => 'Complete',
            self::STATUS_CANCLED => 'Cancled',
        ];
    }

    public function getStatusColors(): array
    {
        return [
           self::STATUS_PENDING => 'btn-primary',
            self::STATUS_COMPLETE => 'btn-success',
            self::STATUS_CANCLED => 'btn-danger',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorLabelAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'btn-secondary';
    }
}
