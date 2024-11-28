<?php

namespace App\Models;

use Database\Factories\StockFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    /** @use HasFactory<StockFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['stockable_type', 'stockable_id', 'quantity', 'description',];

    public function stockable(): MorphTo
    {
        return $this->morphTo();
    }
}
