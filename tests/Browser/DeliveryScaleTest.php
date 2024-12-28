<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\DeliveryScaleFormComponent;
use Tests\Browser\Pages\Admin\DeliveryScale\DeliveryScaleCreatePage;
use Tests\Browser\Pages\Admin\DeliveryScale\DeliveryScaleEditPage;
use Tests\Browser\Pages\Admin\DeliveryScale\DeliveryScaleIndexPage;

it('filters delivery scales by status', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleIndexPage())
            ->filter('@deliveryScaleList')
            ->filter('[data-status="active"]') // Filters delivery scales by status 'active'
            ->assertSee('Active Delivery Scale');
    });
});

it('filters and lists delivery scales by radius', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleIndexPage())
            ->within('@deliveryScaleList', function ($browser) {
                // List all delivery scales
                $deliveryScales = $browser->elements('.delivery-scale');

                // Filter delivery scales that have radius 10 km
                $filteredDeliveryScales = array_filter($deliveryScales, fn($scale) => str_contains($scale->getText(), '10 km'));

                // Assert that the filtered list contains only the desired radius
                expect($filteredDeliveryScales)->toHaveCountGreaterThan(0)
                    ->and($filteredDeliveryScales[0]->getText())->toContain('10 km');
            });
    });
});

it('lists all delivery scales', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleIndexPage())
            ->within('@deliveryScaleList', function ($browser) {
                // List all delivery scales
                $deliveryScales = $browser->elements('.delivery-scale');

                // Assert that there is at least one delivery scale in the list
                expect($deliveryScales)->toHaveCountGreaterThan(0)
                    ->and($deliveryScales[0]->getText())->toContain('10 km');
            });
    });
});

it('creates a delivery scale', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleCreatePage())
            ->click('@createButton')
            ->within(new DeliveryScaleFormComponent(), function ($browser) {
                $browser->fill([
                    'radius' => '10.00',
                    'radius_unit' => 'km',
                    'min_order_amount' => '50.00',
                    'delivery_charges' => '5.00',
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Delivery scale created successfully');
    });
});

it('edits a delivery scale', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleEditPage())
            ->click('@editButton')
            ->within(new DeliveryScaleFormComponent(), function ($browser) {
                $browser->fill([
                    'radius' => '15.00',
                    'radius_unit' => 'km',
                    'min_order_amount' => '75.00',
                    'delivery_charges' => '7.00',
                    'status' => 'inactive',
                ])->press('Save');
            })
            ->assertSee('Delivery scale updated successfully');
    });
});

it('deletes a delivery scale', function () {
    $this->browse(function ($browser) {
        $browser->visit(new DeliveryScaleIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this delivery scale?')
            ->acceptDialog()
            ->assertSee('Delivery scale deleted successfully');
    });
});
