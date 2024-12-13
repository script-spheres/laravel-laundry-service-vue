<?php

namespace App\Models;

use Database\Factories\AddonServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonService extends Model
{
    /** @use HasFactory<AddonServiceFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'price', 'status'];

    protected function casts(): array
    {
        return [
            'image' => 'json',
        ];
    }
}
