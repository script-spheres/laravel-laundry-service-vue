<?php

namespace App\Models;

use Database\Factories\DeliveryScaleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryScale extends Model
{
    /** @use HasFactory<DeliveryScaleFactory> */
    use HasFactory, SoftDeletes;
}
