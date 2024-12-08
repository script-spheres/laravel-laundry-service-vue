<?php

namespace App\Models;

use Database\Factories\DeliveryScaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryScale extends Model
{
    /** @use HasFactory<DeliveryScaleFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'radius',
        'radius_unit',
        'min_order_amount',
        'delivery_charges',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_order_amount' => 'decimal:2',
        'delivery_charges' => 'decimal:2',
        'status' => 'string',
    ];
}
