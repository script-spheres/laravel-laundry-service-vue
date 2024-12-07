<?php

namespace App\Models;

use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    /** @use HasFactory<ExpenseFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'expense_type_id',
        'store_id',
        'date',
        'amount',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the expense type associated with the expense.
     */
    public function expenseType(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class);
    }

    /**
     * Get the store associated with the expense.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
