<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'additional_info',
        'status',
    ];
}
