<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\UnitFormComponent;
use Tests\Browser\Pages\Admin\Unit\UnitCreatePage;
use Tests\Browser\Pages\Admin\Unit\UnitEditPage;
use Tests\Browser\Pages\Admin\Unit\UnitIndexPage;

it('filters items from an array', function () {
    $items = [
        ['actual_name' => 'Kilogram', 'short_name' => 'kg', 'status' => 'active'],
        ['actual_name' => 'Meter', 'short_name' => 'm', 'status' => 'inactive'],
        ['actual_name' => 'Liter', 'short_name' => 'l', 'status' => 'active'],
    ];

    // Filter items by status 'active'
    $activeUnits = array_filter($items, fn($item) => $item['status'] === 'active');

    // Assert that the filtered array has 2 items
    expect($activeUnits)->toHaveCount(2)
        ->and($activeUnits[0]['actual_name'])->toBe('Kilogram');
});

it('filters units by actual name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitIndexPage())
            ->filter('@unitList')
            ->filter('[data-actual_name="Kilogram"]') // Filters units by actual_name 'Kilogram'
            ->assertSee('Kilogram');
    });
});

it('filters and lists units by actual name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitIndexPage())
            ->within('@unitList', function ($browser) {
                // List all units
                $units = $browser->elements('.unit');

                // Filter units that contain 'Kilogram' in their actual name
                $filteredUnits = array_filter($units, fn($unit) => str_contains($unit->getText(), 'Kilogram'));

                // Assert that the filtered units list contains only one item
                expect($filteredUnits)->toHaveCount(1)
                    ->and($filteredUnits[0]->getText())->toContain('Kilogram');
            });
    });
});

it('lists all units', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitIndexPage())
            ->within('@unitList', function ($browser) {
                // List all units
                $units = $browser->elements('.unit');

                // Assert that there is at least one unit in the list
                expect($units)->toHaveCountGreaterThan(0)
                    ->and($units[0]->getText())->toContain('Kilogram');
            });
    });
});

it('creates a unit', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitCreatePage())
            ->click('@createButton')
            ->within(new UnitFormComponent(), function ($browser) {
                $browser->fill([
                    'actual_name' => 'Kilogram',
                    'short_name' => 'kg',
                    'allow_decimal' => true,
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Unit created successfully');
    });
});

it('edits a unit', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitEditPage())
            ->click('@editButton')
            ->within(new UnitFormComponent(), function ($browser) {
                $browser->fill([
                    'actual_name' => 'Updated Kilogram',
                    'short_name' => 'kg',
                    'allow_decimal' => true,
                    'status' => 'inactive',
                ])->press('Save');
            })
            ->assertSee('Unit updated successfully');
    });
});

it('deletes a unit', function () {
    $this->browse(function ($browser) {
        $browser->visit(new UnitIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this unit?')
            ->acceptDialog()
            ->assertSee('Unit deleted successfully');
    });
});
