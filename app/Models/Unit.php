<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory, SoftDeletes;


    protected $fillable = ['actual_name', 'short_name', 'allow_decimal', 'status'];

    protected function casts(): array
    {
        return [
            'allow_decimal' => 'boolean'
        ];
    }
}
