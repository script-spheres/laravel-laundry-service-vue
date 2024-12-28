<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\AddonServiceFormComponent;
use Tests\Browser\Pages\Admin\AddonService\AddonServiceCreatePage;
use Tests\Browser\Pages\Admin\AddonService\AddonServiceEditPage;
use Tests\Browser\Pages\Admin\AddonService\AddonServiceIndexPage;

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

it('filters addon services by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceIndexPage())
            ->filter('@addonServiceList')
            ->filter('[data-name="New Addon Service"]') // Filter addon services by name
            ->assertSee('New Addon Service');
    });
});

it('filters and lists addon services by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceIndexPage())
            ->within('@addonServiceList', function ($browser) {
                // List all addon services
                $addonServices = $browser->elements('.addon-service');

                // Filter addon services that contain 'New Addon Service' in their name
                $filteredAddonServices = array_filter($addonServices, fn($addonService) => str_contains($addonService->getText(), 'New Addon Service'));

                // Assert that the filtered addon services list contains only one item
                expect($filteredAddonServices)->toHaveCount(1)
                    ->and($filteredAddonServices[0]->getText())->toContain('New Addon Service');
            });
    });
});

it('lists all addon services', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceIndexPage())
            ->within('@addonServiceList', function ($browser) {
                // List all addon services
                $addonServices = $browser->elements('.addon-service');

                // Assert that there is at least one addon service in the list
                expect($addonServices)->toHaveCountGreaterThan(0)
                    ->and($addonServices[0]->getText())->toContain('New Addon Service');
            });
    });
});

it('creates an addon service', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceCreatePage())
            ->click('@createButton')
            ->within(new AddonServiceFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'New Addon Service',
                    'description' => 'This is a new addon service.',
                    'image' => __DIR__ . '/images/addon-service.jpg', // Ensure this file exists
                    'price' => '19.99',
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Addon Service created successfully');
    });
});

it('edits an addon service', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceEditPage())
            ->click('@editButton')
            ->within(new AddonServiceFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated Addon Service',
                    'description' => 'This addon service has been updated.',
                    'price' => '29.99',
                ])->press('Save');
            })
            ->assertSee('Addon Service updated successfully');
    });
});

it('deletes an addon service', function () {
    $this->browse(function ($browser) {
        $browser->visit(new AddonServiceIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this addon service?')
            ->acceptDialog()
            ->assertSee('Addon Service deleted successfully');
    });
});

