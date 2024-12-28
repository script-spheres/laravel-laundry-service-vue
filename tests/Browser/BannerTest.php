<?php

use Tests\Browser\Components\Admin\BannerFormComponent;
use Tests\Browser\Pages\Admin\Banner\BannerCreatePage;
use Tests\Browser\Pages\Admin\Banner\BannerEditPage;
use Tests\Browser\Pages\Admin\Banner\BannerIndexPage;

it('filters items from an array', function () {
    $items = [
        ['name' => 'Apple', 'category' => 'Fruit'],
        ['name' => 'Carrot', 'category' => 'Vegetable'],
        ['name' => 'Banana', 'category' => 'Fruit'],
    ];

    // Filter items by category 'Fruit'
    $fruits = array_filter($items, fn($item) => $item['category'] === 'Fruit');

    // Assert that the filtered array has 2 items
    expect($fruits)->toHaveCount(2)
        ->and($fruits[0]['name'])->toBe('Apple');
});

it('filters banners by title', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerIndexPage())
            ->filter('@bannerList')
            ->filter('[data-title="New Banner"]')
            ->assertSee('New Banner');
    });
});

it('filters and lists banners by title', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerIndexPage())
            ->within('@bannerList', function ($browser) {
                // List all banners
                $banners = $browser->elements('.banner');

                // Filter banners that contain 'New Banner' in their title
                $filteredBanners = array_filter($banners, fn($banner) => str_contains($banner->getText(), 'New Banner'));

                // Assert that the filtered banners list contains only one item
                expect($filteredBanners)->toHaveCount(1)
                    ->and($filteredBanners[0]->getText())->toContain('New Banner');
            });
    });
});

it('lists all banners', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerIndexPage())
            ->within('@bannerList', function ($browser) {
                // List all banners
                $banners = $browser->elements('.banner');

                // Assert that there is at least one banner in the list
                expect($banners)->toHaveCountGreaterThan(0)
                    ->and($banners[0]->getText())->toContain('New Banner');

            });
    });
});

it('creates a banner', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerCreatePage())
            ->click('@createButton')
            ->within(new BannerFormComponent(), function ($browser) {
                $browser->fill([
                    'title' => 'New Banner',
                    'description' => 'This is a new banner.',
                    'image' => __DIR__ . '/images/banner.jpg',
                ])->press('Save');
            })
            ->assertSee('Banner created successfully');
    });
});

it('edits a banner', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerEditPage())
            ->click('@editButton')
            ->within(new BannerFormComponent(), function ($browser) {
                $browser->fill([
                    'title' => 'Updated Banner',
                    'description' => 'This banner has been updated.',
                ])->press('Save');
            })
            ->assertSee('Banner updated successfully');
    });
});

it('deletes a banner', function () {
    $this->browse(function ($browser) {
        $browser->visit(new BannerIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this banner?')
            ->acceptDialog()
            ->assertSee('Banner deleted successfully');
    });
});


