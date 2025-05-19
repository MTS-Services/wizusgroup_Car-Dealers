<?php

namespace App\Models;

use App\Models\BaseModel;


class TaxRate extends BaseModel
{
     protected $fillable = [
        'sort_order',
        'name',
        'tax_class_id',
        'country_id',
        'state_id',
        'city_id',
        'status',
        'rate',
        'priority',
        'compound',
        'description',

        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [

            'status_label',
            'status_color',
            'status_btn_label',
            'status_btn_color',
            'status_labels',

            'compound_label',
            'compound_color',
            'compound_labels',



            'priority_label',
            'priority_color',
            'priority_labels',

        ]);
    }
    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;

    public const COMPOUND_TRUE = 1;
    public const COMPOUND_FALSE = 0;



    public const PRIORITY_URGENT = 1;
    public const PRIORITY_HIGH = 2;
    public const PRIORITY_NORMAL = 3;
    public const PRIORITY_LOW = 4;

    // Status labels
    public  function getStatusLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DEACTIVE => 'Deactive',
        ];
    }



    // Status colors
    public  function getStatusColors(): array
    {
        return [
            self::STATUS_ACTIVE => 'bg-success', // Green for active
            self::STATUS_DEACTIVE => 'bg-warning', // Red for deactive
        ];
    }

    // Status btn labels
    public  function getStatusBtnLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Deactive',
            self::STATUS_DEACTIVE => 'Active',
        ];
    }

    // Status btn colors
    public  function getStatusBtnColors(): array
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

    public function scopeActive($query): mixed
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeDeactive($query): mixed
    {
        return $query->where('status', self::STATUS_DEACTIVE);
    }

    // ///////////////////////////Compound Start/////////////////////////////////////////
    public  function getCompoundLabels(): array
    {
        return [
            self::COMPOUND_TRUE => 'True',
            self::COMPOUND_FALSE => 'False',
        ];
    }



    // Compound colors
    public  function getCompoundColors(): array
    {
        return [
            self::COMPOUND_TRUE => 'bg-success', // Green for active
            self::COMPOUND_FALSE => 'bg-warning', // Red for deactive
        ];
    }

    // Compound btn labels
    public Static function getCompoundBtnLabels(): array
    {
        return [
            self::COMPOUND_TRUE => 'False',
            self::COMPOUND_FALSE => 'True',
        ];
    }

    // Compound btn colors
    public Static function getCompoundBtnColors(): array
    {
        return [
            self::COMPOUND_TRUE => 'btn btn-warning', // Green for active
            self::COMPOUND_FALSE => 'btn btn-success', // Red for deactive
        ];
    }

    // Accessor for Compound labels
    public function getCompoundLabelsAttribute(): array
    {
        return self::getCompoundLabels();
    }

    // Accessor for Compound label
    public function getCompoundLabelAttribute(): string
    {
        return self::getCompoundLabels()[$this->compound] ?? 'Unknown';
    }
    // Accessor for Compound color
    public function getCompoundColorAttribute(): string
    {
        return self::getCompoundColors()[$this->compound] ?? 'bg-secondary';
    }

    // Accessor for Compound label
    public function getCompoundBtnLabelAttribute(): string
    {
        return self::getCompoundBtnLabels()[$this->compound] ?? 'Unknown';
    }

    // Accessor for Compound btn color
    public function getCompoundBtnColorAttribute(): string
    {
        return self::getStatusBtnColors()[$this->compound] ?? 'btn btn-secondary';
    }

    public function scopeTrue($query): mixed
    {
        return $query->where('compound', self::COMPOUND_TRUE);
    }

    public function scopeFalse($query): mixed
    {
        return $query->where('compound', self::COMPOUND_FALSE);
    }


    // ///////////////////////////Priority Start/////////////////////////////////////////
    // Priorty labels


    public static function getPriorityLabels(): array
    {
        return [
            self::PRIORITY_URGENT => 'Urgent',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_LOW => 'Low',
        ];
    }

    // Priority colors
    public static function getPriorityColors(): array
    {
        return [
            self::PRIORITY_URGENT => 'badge bg-warning',   // Blue for
            self::PRIORITY_HIGH => 'badge bg-primary', // Yellow for
            self::PRIORITY_NORMAL => 'badge bg-info',
            self::PRIORITY_LOW => 'badge bg-grey',    // Light blue for others
        ];
    }

    // Accessor for Priority labels

    public function getPriorityLabelsAttribute(): array
    {
        return self::getPriorityLabels();
    }


    // Accessor for Priority label
    public function getPriorityLabelAttribute(): string
    {
        return self::getPriorityLabels()[$this->priority] ?? 'Unknown';
    }

    // Accessor for Priority color
    public function getPriorityColorAttribute(): string
    {
        return self::getPriorityColors()[$this->priority] ?? 'bg-secondary';
    }

    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /////////////////////////////////Priority end/////////////////////////

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class, 'tax_class_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
