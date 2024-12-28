<?php

namespace App\Services;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FaqService
{
    /**
     * Get paginated FAQs with filters and sorting.
     */
    public function getFaqs()
    {
        return QueryBuilder::for(Faq::class)
            ->allowedFilters([
                AllowedFilter::exact('question'),
                AllowedFilter::partial('answer'),
            ])
            ->allowedSorts(['created_at'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new FAQ.
     */
    public function create(StoreFaqRequest $request): Faq
    {
        $attributes = $request->validated();

        return Faq::create($attributes);
    }

    /**
     * Update an existing FAQ.
     */
    public function update(Faq $faq, UpdateFaqRequest $request): Faq
    {
        $attributes = $request->validated();

        // Update the FAQ attributes
        $faq->update($attributes);

        return $faq;
    }

    /**
     * Delete an FAQ.
     */
    public function delete(Faq $faq): void
    {
        $faq->delete();
    }
}
