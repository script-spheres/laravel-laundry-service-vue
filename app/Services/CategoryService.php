<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RahulHaque\Filepond\Facades\Filepond;
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
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->latest()
            ->paginate()
            ->appends(request()->query());
    }

    /**
     * Store a new category.
     * @throws FileNotFoundException
     */
    public function create(StoreCategoryRequest $request): Category
    {
        // Save the category data first (without the image)
        $attributes = $request->validated();
        $category = Category::create($attributes);

        // Handle the file upload with FilePond after saving the category
        $fileInfo = Filepond::field($request->image)->moveTo('categories/category-' . Str::random(10));

        if ($fileInfo) {
            // Store only the necessary file information in the database
            $category->update([
                'image' => $this->extractFileData($fileInfo)
            ]);
        }

        // Return the updated category
        return $category;
    }

    /**
     * Update an existing category.
     * @throws FileNotFoundException
     */
    public function update(Category $category, UpdateCategoryRequest $request): Category
    {
        // Update the other category attributes (without changing the image)
        $attributes = $request->validated();

        // Handle the new image (if present)
        $fileInfo = Filepond::field($request->new_image)->moveTo('categories/category-' . Str::random(10));

        // Check for new_image and update if necessary
        if ($fileInfo) {
            // Delete the old image from storage if it exists
            if ($category->image) {
                Storage::delete($category->image['location']);
            }

            // Store only the necessary file information in the database
            $attributes['image'] = $this->extractFileData($fileInfo);
        }

        // Update the category with the new image information
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
            Storage::delete($category->image['location']);
        }

        // Delete the category itself
        $category->delete();
    }

    /**
     * Helper function to extract the necessary file data.
     */
    private function extractFileData($fileInfo): array
    {
        return [
            'dirname' => $fileInfo['dirname'],
            'basename' => $fileInfo['basename'],
            'extension' => $fileInfo['extension'],
            'location' => $fileInfo['location'],
            'url' => $fileInfo['url']
        ];
    }
}
