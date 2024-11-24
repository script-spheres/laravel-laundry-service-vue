<?php

namespace App\Models;

use Database\Factories\BannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    /** @use HasFactory<BannerFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'image', 'active_status'];

    protected function casts(): array
    {
        return [
            'image' => 'json',
        ];
    }

}
