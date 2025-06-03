<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    public const STATUS_PENDING = '0';
    public const STATUS_CONFIRM = '1';
    public const STATUS_SHIPPED = '2';
    public const STATUS_DELIVERED = '3';
    public const STATUS_CANCELED = '4';
}
