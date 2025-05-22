<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends BaseModel
{
    use HasFactory;
    // Status labels
    public const STATUS_PENDING = 1;
    public const STATUS_OPEN = 2;
    public const STATUS_CLOSE = 3;

    protected $appends = [


        'status_label',
        'status_color',
        'status_labels',
        'status_btn_label',
        'status_btn_color',

        'creater_name',
        'updater_name',
        'deleter_name',
    ];
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pandding',
            self::STATUS_OPEN => 'Open',
            self::STATUS_CLOSE => 'Close',
        ];
    }

    // Status colors
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_PENDING => 'bg-primary',   // Blue for panding
            self::STATUS_OPEN => 'bg-warning', // Yellow for open
            self::STATUS_CLOSE => 'bg-info',    // Light blue for close
        ];
    }
    public static function geStatusBtnColors(): array
    {
        return [
            self::STATUS_PENDING => 'btn-primary',   // Blue for panding
            self::STATUS_OPEN => 'btn-warning', // Yellow for open
            self::STATUS_CLOSE => 'btn-info',    // Light blue for close
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
    // Accessor for Status Btn label
    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    // Accessor for status btn color
    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn btn-secondary';
    }

    // Active scope
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }
    public function scopeClose($query)
    {
        return $query->where('status', self::STATUS_CLOSE);
    }
}
