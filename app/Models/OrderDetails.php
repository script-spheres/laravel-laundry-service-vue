<?php

namespace App\Models;

use Database\Factories\OrderDetailsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderDetails extends Model
{
    /** @use HasFactory<OrderDetailsFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'serviceable_type',
        'serviceable_id',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order detail.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the related serviceable entity (morph relationship).
     */
    public function serviceable(): MorphTo
    {
        return $this->morphTo();
    }
}
