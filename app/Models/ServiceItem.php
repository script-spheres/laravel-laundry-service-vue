<?php

namespace App\Models;

use Database\Factories\ServiceItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceItem extends Model
{
    /** @use HasFactory<ServiceItemFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'image' => 'json',
        ];
    }

    /**
     * Get the related service prices for this service item.
     */
    public function serviceDetails(): HasMany
    {
        return $this->hasMany(ServiceDetail::class, 'service_id');
    }
}
