<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class User extends AuthBaseModel implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sort_order',
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone',
        'status',
        'image',
        'email_verified_at',
        'whatsapp',

        'company_name',
        'business_type',
        'business_name',
        'business_information',
        'business_line',
        'trade_term',
        'id_registration_info',
        'dealer_registration_permit',
        'how_know',
        'how_know_detail',
        'receive_promotions',
        'accept_terms',

        'creater_id',
        'updater_id',
        'deleter_id',
        'creater_type',
        'updater_type',
        'deleter_type',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'creater_id' => 'integer',
        'updater_id' => 'integer',
        'deleter_id' => 'integer',
        'status' => 'integer',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function containerReservations(): HasMany
    {
        return $this->hasMany(ContainerReservation::class);
    }
    public function productReserves(): HasMany
    {
        return $this->hasMany(ProductReserve::class);
    }

    public function productInquiries(): HasMany
    {
        return $this->hasMany(ProductInquiry::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'profile');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function personalInformation(): MorphOne
    {
        return $this->morphOne(PersonalInformation::class, 'profile');
    }

    public function auctionBids()
    {
        return $this->hasMany(AuctionBid::class);
    }
    public function auctionWatched()
    {
        return $this->hasMany(AuctionWatcher::class);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            // 'business_type',
            // 'business_name',
            // 'business_line',

            // 'know_label',
            // 'receive_promotion_email',
            // 'accept_term'
            'modified_image',
        ]);
    }


    public const BUSINESS_TYPE_CORPORATE = 1;
    public const BUSINESS_TYPE_INDIVIDUAL = 2;

    public static function getBusinessTypes(): array
    {
        return [
            self::BUSINESS_TYPE_CORPORATE => 'Corporate',
            self::BUSINESS_TYPE_INDIVIDUAL => 'Individual',
        ];
    }

    public const BUSINESS_NAME_SHEET_METAL = 1;
    public const BUSINESS_NAME_DEMOLITION_PARTS = 2;
    public const BUSINESS_NAME_BROKERS = 3;
    public const BUSINESS_NAME_USED_CAR_EXPORT = 4;
    public const BUSINESS_NAME_USED_CAR_IMPORT = 5;
    public const BUSINESS_NAME_USED_CAR_DEALER = 6;
    public const BUSINESS_NAME_AUCTION_BUSINESS = 7;
    public const BUSINESS_NAME_SIDE_JOB = 8;
    public const BUSINESS_NAME_OTHER = 9;

    public static function getBusinessNames(): array
    {
        return [
            self::BUSINESS_NAME_SHEET_METAL => 'Sheet Metal . Repair',
            self::BUSINESS_NAME_DEMOLITION_PARTS => 'Demolition & Parts',
            self::BUSINESS_NAME_BROKERS => 'Brokers',
            self::BUSINESS_NAME_USED_CAR_EXPORT => 'Second-hand Car Export',
            self::BUSINESS_NAME_USED_CAR_IMPORT => 'Second-hand Car Import',
            self::BUSINESS_NAME_USED_CAR_DEALER => 'Second-hand Car Dealer',
            self::BUSINESS_NAME_AUCTION_BUSINESS => 'Auction Business',
            self::BUSINESS_NAME_SIDE_JOB => 'Side Job',
            self::BUSINESS_NAME_OTHER => 'Other',
        ];
    }

    public const BUSINESS_LINE_DAMAGED_CAR = 1;
    public const BUSINESS_LINE_USED_CAR = 2;
    public const BUSINESS_LINE_TRUCK_BUS = 3;
    public const BUSINESS_LINE_CONSTRUCTION = 4;
    public const BUSINESS_LINE_FORKLIFT = 5;
    public const BUSINESS_LINE_FARM_MACHINE = 6;
    public const BUSINESS_LINE_AUTO_PART = 7;

    public static function getBusinessLines(): array
    {
        return [
            self::BUSINESS_LINE_DAMAGED_CAR => 'Damaged Car',
            self::BUSINESS_LINE_USED_CAR => 'Used Car',
            self::BUSINESS_LINE_TRUCK_BUS => 'Truck, Bus',
            self::BUSINESS_LINE_CONSTRUCTION => 'Construction Machinery',
            self::BUSINESS_LINE_FORKLIFT => 'Forklifts',
            self::BUSINESS_LINE_FARM_MACHINE => 'Farm Machine',
            self::BUSINESS_LINE_AUTO_PART => 'Auto Parts',
        ];
    }

    public const KNOW_FACEBOOK = 1;
    public const KNOW_INSTAGRAM = 2;
    public const KNOW_TWITTER = 3;
    public const KNOW_LINKEDIN = 4;
    public const KNOW_YOUTUBE = 5;
    public const KNOW_SEARCH = 6;
    public const KNOW_FRIEND = 7;
    public const KNOW_STAFF = 8;
    public const KNOW_AGENT = 9;
    public const KNOW_OTHER = 10;

    public static function getKnows(): array
    {
        return [
            self::KNOW_FACEBOOK => 'Facebook',
            self::KNOW_INSTAGRAM => 'Instagram',
            self::KNOW_TWITTER => 'Twitter',
            self::KNOW_LINKEDIN => 'Linkedin',
            self::KNOW_YOUTUBE => 'Youtube',
            self::KNOW_SEARCH => 'Search Engine',
            self::KNOW_FRIEND => 'Friend',
            self::KNOW_STAFF => 'Staff',
            self::KNOW_AGENT => 'Agent (Representative)',
            self::KNOW_OTHER => 'Other',
        ];
    }

    public const RECEIVE_PROMOTION_EMAIL = 1;
    public const NOT_RECEIVE_PROMOTION_EMAIL = 0;

    public static function getReceivePromotionEmails(): array
    {
        return [
            self::RECEIVE_PROMOTION_EMAIL => 'Recieve',
            self::NOT_RECEIVE_PROMOTION_EMAIL => 'Cannot Recieve',
        ];
    }

    public const ACCEPT_TERMS = 1;
    public const NOT_ACCEPT_TERMS = 0;

    public static function getTerms(): array
    {
        return [
            self::ACCEPT_TERMS => 'Accept',
            self::NOT_ACCEPT_TERMS => 'Not Accept',
        ];
    }
}
