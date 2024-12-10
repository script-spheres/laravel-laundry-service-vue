<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    /** @use HasFactory<ServiceFactory> */
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
