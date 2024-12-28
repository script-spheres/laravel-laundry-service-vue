<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\CityFormComponent;
use Tests\Browser\Pages\Admin\City\CityCreatePage;
use Tests\Browser\Pages\Admin\City\CityEditPage;
use Tests\Browser\Pages\Admin\City\CityIndexPage;

it('filters items from an array', function () {
    $items = [
        ['name' => 'New York', 'status' => 'active'],
        ['name' => 'Los Angeles', 'status' => 'inactive'],
        ['name' => 'Chicago', 'status' => 'active'],
    ];

    // Filter items by status 'active'
    $activeCities = array_filter($items, fn($item) => $item['status'] === 'active');

    // Assert that the filtered array has 2 items
    expect($activeCities)->toHaveCount(2)
        ->and($activeCities[0]['name'])->toBe('New York');
});

it('filters cities by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityIndexPage())
            ->filter('@cityList')
            ->filter('[data-name="New York"]') // Filters cities by name 'New York'
            ->assertSee('New York');
    });
});

it('filters and lists cities by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityIndexPage())
            ->within('@cityList', function ($browser) {
                // List all cities
                $cities = $browser->elements('.city');

                // Filter cities that contain 'New York' in their name
                $filteredCities = array_filter($cities, fn($city) => str_contains($city->getText(), 'New York'));

                // Assert that the filtered cities list contains only one item
                expect($filteredCities)->toHaveCount(1)
                    ->and($filteredCities[0]->getText())->toContain('New York');
            });
    });
});

it('lists all cities', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityIndexPage())
            ->within('@cityList', function ($browser) {
                // List all cities
                $cities = $browser->elements('.city');

                // Assert that there is at least one city in the list
                expect($cities)->toHaveCountGreaterThan(0)
                    ->and($cities[0]->getText())->toContain('New York');
            });
    });
});

it('creates a city', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityCreatePage())
            ->click('@createButton')
            ->within(new CityFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'New York',
                    'additional_info' => 'City in the USA',
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('City created successfully');
    });
});

it('edits a city', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityEditPage())
            ->click('@editButton')
            ->within(new CityFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated New York',
                    'additional_info' => 'Updated info about New York',
                    'status' => 'inactive',
                ])->press('Save');
            })
            ->assertSee('City updated successfully');
    });
});

it('deletes a city', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CityIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this city?')
            ->acceptDialog()
            ->assertSee('City deleted successfully');
    });
});
