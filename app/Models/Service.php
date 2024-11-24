<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_name',
        'description',
        'base_price',
        'type_id',
        'store_id',
        'image',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'type_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function addons()
    {
        return $this->hasMany(ServiceAddon::class);
    }
}
