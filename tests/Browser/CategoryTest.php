<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\CategoryFormComponent;
use Tests\Browser\Pages\Admin\Category\CategoryCreatePage;
use Tests\Browser\Pages\Admin\Category\CategoryEditPage;
use Tests\Browser\Pages\Admin\Category\CategoryIndexPage;

it('filters items from an array', function () {
    $items = [
        ['name' => 'Fruits', 'category' => 'Food'],
        ['name' => 'Electronics', 'category' => 'Technology'],
        ['name' => 'Vegetables', 'category' => 'Food'],
    ];

    // Filter items by category 'Food'
    $foodCategories = array_filter($items, fn($item) => $item['category'] === 'Food');

    // Assert that the filtered array has 2 items
    expect($foodCategories)->toHaveCount(2)
        ->and($foodCategories[0]['name'])->toBe('Fruits');
});

it('filters categories by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryIndexPage())
            ->filter('@categoryList')
            ->filter('[data-name="Fruits"]') // Filter categories by name
            ->assertSee('Fruits');
    });
});

it('filters and lists categories by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryIndexPage())
            ->within('@categoryList', function ($browser) {
                // List all categories
                $categories = $browser->elements('.category');

                // Filter categories that contain 'Fruits' in their name
                $filteredCategories = array_filter($categories, fn($category) => str_contains($category->getText(), 'Fruits'));

                // Assert that the filtered categories list contains only one item
                expect($filteredCategories)->toHaveCount(1)
                    ->and($filteredCategories[0]->getText())->toContain('Fruits');
            });
    });
});

it('lists all categories', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryIndexPage())
            ->within('@categoryList', function ($browser) {
                // List all categories
                $categories = $browser->elements('.category');

                // Assert that there is at least one category in the list
                expect($categories)->toHaveCountGreaterThan(0)
                    ->and($categories[0]->getText())->toContain('Fruits');
            });
    });
});

it('creates a category', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryCreatePage())
            ->click('@createButton')
            ->within(new CategoryFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Fruits',
                    'description' => 'This category contains fruits.',
                    'image' => __DIR__ . '/images/category-fruits.jpg',
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Category created successfully');
    });
});

it('edits a category', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryEditPage())
            ->click('@editButton')
            ->within(new CategoryFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated Fruits',
                    'description' => 'This category has been updated.',
                ])->press('Save');
            })
            ->assertSee('Category updated successfully');
    });
});

it('deletes a category', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CategoryIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this category?')
            ->acceptDialog()
            ->assertSee('Category deleted successfully');
    });
});
