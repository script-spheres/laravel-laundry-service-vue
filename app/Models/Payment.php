<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'payment_status',
        'payment_date',
    ];

    /**
     * Get the order that owns the payment.
     */
    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
