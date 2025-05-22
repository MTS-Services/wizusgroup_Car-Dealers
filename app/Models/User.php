<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthBaseModel implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'modified_image',
        ]);
    }

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
    public function personalInformation(): MorphOne
    {
        return $this->morphOne(personalInformation::class, 'profile');
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }
}
