<?php

namespace App\Models;

use App\Notifications\AdminPasswordResetNotification;
use App\Notifications\AdminVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;

class Admin extends AuthBaseModel implements Auditable, MustVerifyEmail
{
    use HasFactory, HasRoles, \OwenIt\Auditing\Auditable, Notifiable;
    protected $guard_name = 'admin';
    protected $gurad = 'admin';

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminPasswordResetNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new AdminVerifyEmail);
    }

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'sort_order',
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'image',
        'role_id',
        'status',
        'email_verified_at',
        'password',
        'created_by',
        'updated_by',
        'deleted_by',
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
    protected function casts(): array
    {
        return [
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'integer',
            'username' => 'string',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id')->select(['name', 'id']);
    }
}
