<?php

namespace App\Models;

use Database\Factories\ServiceTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    /** @use HasFactory<ServiceTypeFactory> */
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'image' => 'json',
        ];
    }
}
