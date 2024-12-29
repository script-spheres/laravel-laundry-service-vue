<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_uuid',
        'order_display_id',
        'customer_id',
        'store_id',
        'total_weight_kg',
        'sub_total',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'paid_amount',
        'delivery_date',
        'quick_note',
        'order_label_id',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function orderLabel(): BelongsTo
    {
        return $this->belongsTo(OrderLabel::class, 'order_label_id');
    }
}
