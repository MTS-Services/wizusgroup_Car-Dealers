<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'sort_order',
        'name',
        'open_by',
        'email',
        'message',
        'status',

        'creater_id',
        'updater_id',
        'deleter_id',

        'creater_type',
        'updater_type',
        'deleter_type',
    ];

    // Status constants
    public const STATUS_PENDING = 1;
    public const STATUS_OPEN = 2;
    public const STATUS_CLOSE = 3;

    // Append these custom attributes to model's array/json
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

    // Relations
    public function openBy(): BelongsTo
    {
        // Foreign key 'open_by' points to 'id' on Admin
        return $this->belongsTo(Admin::class, 'open_by', 'id');
    }

    // Status Labels
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_OPEN => 'Open',
            self::STATUS_CLOSE => 'Close',
        ];
    }

    // Button Labels for status (adjust according to your logic)
    public static function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Open',
            self::STATUS_OPEN => 'Pending',
            self::STATUS_CLOSE => 'Close',
        ];
    }

    // Status colors for badge
    public static function getStatusColors(): array
    {
        return [
            self::STATUS_PENDING => 'bg-primary',   // Blue
            self::STATUS_OPEN => 'bg-warning',      // Yellow
            self::STATUS_CLOSE => 'bg-info',        // Light blue
        ];
    }

    // Button colors for status action buttons
    public static function getStatusBtnColors(): array
    {
        return [
            self::STATUS_PENDING => 'btn-primary',
            self::STATUS_OPEN => 'btn-warning',
            self::STATUS_CLOSE => 'btn-info',
        ];
    }

    // Accessors for appended attributes

    public function getStatusLabelsAttribute(): array
    {
        return self::getStatusLabels();
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatusLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute(): string
    {
        return self::getStatusColors()[$this->status] ?? 'bg-secondary';
    }

    public function getStatusBtnLabelAttribute(): string
    {
        return self::getStatusBtnLabels()[$this->status] ?? 'Unknown';
    }

    public function getStatusBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->status] ?? 'btn-secondary';
    }

    // Scopes for easy querying
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
