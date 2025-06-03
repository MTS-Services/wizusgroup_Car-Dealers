<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends BaseModel
{
    use HasFactory;

    public const STATUS_PENDING = '0';
    public const STATUS_CONFIRM = '1';
    public const STATUS_SHIPPED = '2';
    public const STATUS_DELIVERED = '3';
    public const STATUS_CANCELED = '4';

    public const STATUS_DROPSHIPPING_PENDING = '0';
    public const STATUS_DROPSHIPPING_CONFIRM = '1';
    public const STATUS_DROPSHIPPING_SHIPPED = '2';
    public const STATUS_DROPSHIPPING_DELIVERED = '3';
    public const STATUS_DROPSHIPPING_CANCELED = '4';

    public const DROPSHIPPING = '1';
    public const NOT_DROPSHIPPING = '0';
}
