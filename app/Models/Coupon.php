<?php

namespace App\Models;

use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    /** @use HasFactory<CouponFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount_amount',
        'discount_percentage',
        'valid_from',
        'valid_to',
        'usage_limit',
        'used_count',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to' => 'date',
    ];
}
