<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'product_id',
        'title',
        'description',
        'start_price',
        'reserve_price',
        'buy_now_price',
        'increment_amount',

        'start_date',
        'end_date',

        'status',
        'is_featured',

        'meta_title',
        'meta_description',

        'created_by',
        'updated_by',
        'deleted_by',

        'winner_id',
        'winning_bid_id',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'status_label',
            'status_color',

            'featured_label',
            'featured_color',
            'featured_btn_label',
            'featured_btn_color',
            'featured_labels',
        ]);
    }

    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function auctionBids()
    {
        return $this->hasMany(AuctionBid::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public const STATUS_SCHEDULED = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_CLOSED = 3;
    public const STATUS_CANCELLED = 4;

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getStatusLabelAttribute(): array
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColors(): array
    {
        return [
            self::STATUS_SCHEDULED => 'warning',
            self::STATUS_ACTIVE => 'primary',
            self::STATUS_CLOSED => 'success',
            self::STATUS_CANCELLED => 'danger',
        ];
    }

    public function getStatusColorAttribute(): string
    {
        return $this->getStatusColors()[$this->status] ?? 'secondary';
    }

    public const FEATURED_YES = 1;
    public const FEATURED_NO = 0;

    public static function getFeaturedLabels(): array
    {
        return [
            self::FEATURED_YES => 'Yes',
            self::FEATURED_NO => 'No',
        ];
    }

    public static function getFeaturedBtnLabels(): array
    {
        return [
            self::FEATURED_YES => 'Remove From Featured',
            self::FEATURED_NO => 'Make Featured',
        ];
    }

    public function getFeaturedLabelAttribute(): array
    {
        return self::getFeaturedLabels()[$this->is_featured] ?? 'Unknown';
    }

    public function getFeaturedBtnLabelAttribute(): array
    {
        return self::getFeaturedBtnLabels()[$this->is_featured] ?? 'Unknown';
    }

    public function getFeaturedColorAttribute(): string
    {
        return $this->status == self::FEATURED_YES ? 'bg-success' : 'bg-warning';
    }

    public function getFeaturedBtnColorAttribute(): string
    {
        return $this->status == self::FEATURED_YES ? 'bg-primary' : 'bg-info';
    }
}
