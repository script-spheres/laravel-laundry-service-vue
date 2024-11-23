<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryService
{
    /**
     * Get paginated categories with filters and sorting.
     */
    public function getCategories()
    {
        return QueryBuilder::for(Category::class)
            ->allowedIncludes(['parent', 'children'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('active_status'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new category.
     */
    public function create(StoreCategoryRequest $request): Category
    {
        // Handle file upload directly
        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('categories');
        }

        return Category::create($request->validated());
    }

    /**
     * Update an existing category.
     */
    public function update(Category $category, UpdateCategoryRequest $request): Category
    {
        $attributes = $request->validated();

        // Check for new_image and update if necessary
        if ($request->hasFile('new_image')) {
            // Delete the old image if it exists
            if ($category->image) {
                Storage::delete($category->image);
            }
            // Store the new image
            $attributes['image'] = $request->file('new_image')->store('categories');
        }

        // Update the category attributes
        $category->update($attributes);

        return $category;
    }

    /**
     * Delete a category.
     */
    public function delete(Category $category): void
    {
        // Delete the image from storage if it exists
        if ($category->image) {
            Storage::delete($category->image);
        }

        $category->delete();
    }
}
