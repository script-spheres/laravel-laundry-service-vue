<?php

namespace App\Models;

use Database\Factories\ServiceTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePrice extends Model
{
    /** @use HasFactory<ServiceTypeFactory> */
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'service_type_id',
        'price',
    ];

    /**
     * Get the service item associated with this price.
     */
    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }
}
