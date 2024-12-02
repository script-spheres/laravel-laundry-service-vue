<?php

namespace App\Models;

use Database\Factories\OrderDetailsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    /** @use HasFactory<OrderDetailsFactory> */
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'subtotal', 'restaurant_notes', 'request_notes', 'serve_status', 'kitchen_status', 'deleted_at'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
