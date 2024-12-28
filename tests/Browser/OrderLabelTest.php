<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\OrderLabelFormComponent;
use Tests\Browser\Pages\Admin\OrderLabel\OrderLabelCreatePage;
use Tests\Browser\Pages\Admin\OrderLabel\OrderLabelEditPage;
use Tests\Browser\Pages\Admin\OrderLabel\OrderLabelIndexPage;

it('filters order labels by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderLabelIndexPage())
            ->filter('@orderLabelList')
            ->filter('[data-name="Urgent"]') // Filters order labels by name
            ->assertSee('Urgent');
    });
});

it('lists all order labels', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderLabelIndexPage())
            ->within('@orderLabelList', function ($browser) {
                // List all order labels
                $orderLabels = $browser->elements('.order-label');

                // Assert that there is at least one order label in the list
                expect($orderLabels)->toHaveCountGreaterThan(0)
                    ->and($orderLabels[0]->getText())->toContain('Urgent');
            });
    });
});

it('creates an order label', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderLabelCreatePage())
            ->click('@createButton')
            ->within(new OrderLabelFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Urgent',
                    'description' => 'Label for urgent orders.',
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Order label created successfully');
    });
});

it('edits an order label', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderLabelEditPage())
            ->click('@editButton')
            ->within(new OrderLabelFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated Urgent',
                    'description' => 'Updated description for urgent orders.',
                    'status' => 'inactive',
                ])->press('Save');
            })
            ->assertSee('Order label updated successfully');
    });
});

it('deletes an order label', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderLabelIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this order label?')
            ->acceptDialog()
            ->assertSee('Order label deleted successfully');
    });
});
