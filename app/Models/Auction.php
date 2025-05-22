<?php

namespace App\Models;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'product_id',
        'title',
        'slug',
        'description',
        'start_price',
        'reserve_price',
        'buy_now_price',
        'increment_amount',
        'location',
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
            'status_labels',

            'featured_labels',
            'featured_label',
            'featured_color',
            'featured_btn_label',
            'featured_btn_color',

            'start_date_format',
            'end_date_format',
        ]);
    }
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getStartDateFormatAttribute(): string
    {
        return $this->start_date ? Carbon::parse($this->start_date)->format('d M Y') : '';
    }

    public function getEndDateFormatAttribute(): string
    {
        return $this->end_date ? Carbon::parse($this->end_date)->format('d M Y') : '';
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
    public const STATUS_OPEN = 2;
    public const STATUS_CLOSED = 3;
    public const STATUS_CANCELLED = 4;

    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_OPEN => 'Open',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    // Status colors
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_SCHEDULED => 'bg-info',
            self::STATUS_OPEN => 'bg-primary',
            self::STATUS_CLOSED => 'bg-success',
            self::STATUS_CANCELLED => 'bg-danger',
        ];
    }

    // Accessor for Status labels

    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }


    // Accessor for Status label
    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for Status color
    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    // Featured labels

    public const FEATURED_YES = 1;
    public const FEATURED_NO = 0;

    public static function getFeaturedLabels(): array
    {
        return [
            self::FEATURED_NO => 'No',
            self::FEATURED_YES => 'Yes',
        ];
    }



    // Featured colors
    public static function getFeaturedColors(): array
    {
        return [
            self::FEATURED_NO => 'bg-warning',
            self::FEATURED_YES => 'bg-info',
        ];
    }

    // Featured btn labels
    public static function getFeaturedBtnLabels(): array
    {
        return [
            self::FEATURED_NO => 'Make Featured',
            self::FEATURED_YES => 'Remove From Featured',
        ];
    }

    // Featured btn colors
    public static function getFeaturedBtnColors(): array
    {
        return [
            self::FEATURED_NO => 'btn btn-info',
            self::FEATURED_YES => 'btn btn-warning',
        ];
    }

    // Accessor for featured labels
    public function getFeaturedLabelsAttribute(): array
    {
        return self::getFeaturedLabels();
    }

    // Accessor for featured label
    public function getFeaturedLabelAttribute(): string
    {
        return self::getFeaturedLabels()[$this->is_featured] ?? 'Unknown';
    }
    // Accessor for featured color
    public function getFeaturedColorAttribute(): string
    {
        return self::getFeaturedColors()[$this->is_featured] ?? 'bg-secondary';
    }

    // Accessor for featured label
    public function getFeaturedBtnLabelAttribute(): string
    {
        return self::getFeaturedBtnLabels()[$this->is_featured] ?? 'Unknown';
    }

    // Accessor for featured btn color
    public function getFeaturedBtnColorAttribute(): string
    {
        return self::getFeaturedBtnColors()[$this->is_featured] ?? 'btn btn-secondary';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', self::FEATURED_YES);
    }
}
