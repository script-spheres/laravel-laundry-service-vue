<?php

namespace App\Models;

use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    /** @use HasFactory<StoreFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'financial_year_id',
        'name',
        'address',
        'address_lat',
        'address_long',
        'email',
        'phone_number',
        'manager_name',
        'manager_email',
        'manager_phone_number',
        'additional_info',
        'store_code',
        'active_status',
    ];

    protected $casts = [
        'address_lat' => 'decimal:7',
        'address_long' => 'decimal:7',
    ];

    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class);
    }
}
