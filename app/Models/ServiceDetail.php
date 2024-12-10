<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceDetail extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'service_id',
        'service_item_id',
        'unit_id',
        'price',
        'quantity',
    ];

    /**
     * Get the service item associated with this price.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Get the service item associated with this price.
     */
    public function serviceItem(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_item_id');
    }

    /**
     * Get the related service prices for this service item.
     */
    public function category(): HasMany
    {
        return $this->hasMany(ServiceDetail::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
