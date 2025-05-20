<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalInformation extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'profile_id',
        'profile_type',
        'dob',
        'gender',
        'emergency_phone',
        'father_name',
        'mother_name',
        'nationality',
        'bio',
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(
            parent::getAppends(),
            [
                'gender_label',
                'gender_color',
                'gender_labels',
            ]
        );
    }

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHERS = 3;

    // =======================================================================

    // Gender labels
    public static function getGenderLabels(): array
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
            self::GENDER_OTHERS => 'Others',
        ];
    }

    // Gender colors
    public static function getGenderColors(): array
    {
        return [
            self::GENDER_MALE => 'badge bg-primary',   // Blue for male
            self::GENDER_FEMALE => 'badge bg-warning', // Yellow for female
            self::GENDER_OTHERS => 'badge bg-info',    // Light blue for others
        ];
    }

    // Accessor for gender labels

    public function getGenderLabelsAttribute(): array
    {
        return self::getGenderLabels();
    }


    // Accessor for gender label
    public function getGenderLabelAttribute(): string
    {
        return self::getGenderLabels()[$this->gender] ?? 'Unknown';
    }

    // Accessor for gender color
    public function getGenderColorAttribute(): string
    {
        return self::getGenderColors()[$this->gender] ?? 'bg-secondary';
    }

    public function profile()
    {
        return $this->morphTo();
    }

    //Admin scope
    public function scopeUserProfile($query)
    {
        return $query->where('profile_id', user()->id)->where('profile_type', get_class(user()));
    }
}
