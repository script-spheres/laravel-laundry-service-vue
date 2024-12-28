<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\CouponFormComponent;
use Tests\Browser\Pages\Admin\Coupon\CouponCreatePage;
use Tests\Browser\Pages\Admin\Coupon\CouponEditPage;
use Tests\Browser\Pages\Admin\Coupon\CouponIndexPage;

it('filters items from an array', function () {
    $items = [
        ['title' => 'Black Friday Sale', 'status' => 'active'],
        ['title' => 'Christmas Discount', 'status' => 'inactive'],
        ['title' => 'Summer Offer', 'status' => 'active'],
    ];

    // Filter items by status 'active'
    $activeCoupons = array_filter($items, fn($item) => $item['status'] === 'active');

    // Assert that the filtered array has 2 items
    expect($activeCoupons)->toHaveCount(2)
        ->and($activeCoupons[0]['title'])->toBe('Black Friday Sale');
});

it('filters coupons by title', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponIndexPage())
            ->filter('@couponList')
            ->filter('[data-title="Black Friday Sale"]') // Filters coupons by title 'Black Friday Sale'
            ->assertSee('Black Friday Sale');
    });
});

it('filters and lists coupons by title', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponIndexPage())
            ->within('@couponList', function ($browser) {
                // List all coupons
                $coupons = $browser->elements('.coupon');

                // Filter coupons that contain 'Black Friday Sale' in their title
                $filteredCoupons = array_filter($coupons, fn($coupon) => str_contains($coupon->getText(), 'Black Friday Sale'));

                // Assert that the filtered coupons list contains only one item
                expect($filteredCoupons)->toHaveCount(1)
                    ->and($filteredCoupons[0]->getText())->toContain('Black Friday Sale');
            });
    });
});

it('lists all coupons', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponIndexPage())
            ->within('@couponList', function ($browser) {
                // List all coupons
                $coupons = $browser->elements('.coupon');

                // Assert that there is at least one coupon in the list
                expect($coupons)->toHaveCountGreaterThan(0)
                    ->and($coupons[0]->getText())->toContain('Black Friday Sale');
            });
    });
});

it('creates a coupon', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponCreatePage())
            ->click('@createButton')
            ->within(new CouponFormComponent(), function ($browser) {
                $browser->fill([
                    'title' => 'Black Friday Sale',
                    'description' => 'Huge discounts for Black Friday',
                    'code' => 'BF2023',
                    'discount_type' => 'flat',
                    'discount_amount' => 20.00,
                    'min_amount' => 100.00,
                    'max_amount' => 500.00,
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Coupon created successfully');
    });
});

it('edits a coupon', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponEditPage())
            ->click('@editButton')
            ->within(new CouponFormComponent(), function ($browser) {
                $browser->fill([
                    'title' => 'Updated Black Friday Sale',
                    'description' => 'Updated discount details for Black Friday',
                    'code' => 'BF2023',
                    'discount_type' => 'percentage',
                    'discount_percentage' => 10.00,
                    'min_amount' => 100.00,
                    'max_amount' => 500.00,
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Coupon updated successfully');
    });
});

it('deletes a coupon', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CouponIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this coupon?')
            ->acceptDialog()
            ->assertSee('Coupon deleted successfully');
    });
});
