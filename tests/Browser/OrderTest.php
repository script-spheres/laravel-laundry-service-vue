<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\OrderFormComponent;
use Tests\Browser\Pages\Admin\Order\OrderCreatePage;
use Tests\Browser\Pages\Admin\Order\OrderEditPage;
use Tests\Browser\Pages\Admin\Order\OrderIndexPage;

it('filters orders by status', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderIndexPage())
            ->filter('@orderList')
            ->filter('[data-status="pending"]') // Filters orders by 'pending' status
            ->assertSee('Pending');
    });
});

it('lists all orders', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderIndexPage())
            ->within('@orderList', function ($browser) {
                // List all orders
                $orders = $browser->elements('.order');

                // Assert that there is at least one order in the list
                expect($orders)->toHaveCountGreaterThan(0)
                    ->and($orders[0]->getText())->toContain('Order #');
            });
    });
});

it('creates an order', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderCreatePage())
            ->click('@createButton')
            ->within(new OrderFormComponent(), function ($browser) {
                $browser->fill([
                    'order_uuid' => (string) Str::uuid(),
                    'customer_id' => 1,
                    'store_id' => 1,
                    'total_weight_kg' => 10,
                    'sub_total' => 100.00,
                    'total_amount' => 120.00,
                    'tax_amount' => 20.00,
                    'discount_amount' => 0.00,
                    'paid_amount' => 120.00,
                    'delivery_date' => now()->addDays(1)->format('Y-m-d'),
                    'order_status' => 'pending',
                    'quick_note' => 'Urgent order for delivery.',
                ])->press('Save');
            })
            ->assertSee('Order created successfully');
    });
});

it('edits an order', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderEditPage())
            ->click('@editButton')
            ->within(new OrderFormComponent(), function ($browser) {
                $browser->fill([
                    'order_status' => 'in-progress',
                    'quick_note' => 'Order is now being prepared.',
                ])->press('Save');
            })
            ->assertSee('Order updated successfully');
    });
});

it('deletes an order', function () {
    $this->browse(function ($browser) {
        $browser->visit(new OrderIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this order?')
            ->acceptDialog()
            ->assertSee('Order deleted successfully');
    });
});

