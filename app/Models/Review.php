<?php

namespace App\Models;

use Database\Factories\ReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    /** @use HasFactory<ReviewFactory> */
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'author_type',
        'author_id',
        'title',
        'review',
        'rating',
        'in_testimonial',
    ];

    /**
     * Get the model that the review belongs to.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the author of the review.
     */
    public function author(): MorphTo
    {
        return $this->morphTo();
    }
}
