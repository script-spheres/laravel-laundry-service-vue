<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'store_id',
        'timeslot_id',
        'coupon_id',
        'status',
        'total_weight_kg',
        'total_price',
        'tax',
        'discount',
        'delivery_date',
        'quick_note',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
