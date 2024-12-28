<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\CustomerFormComponent;
use Tests\Browser\Pages\Admin\Customer\CustomerCreatePage;
use Tests\Browser\Pages\Admin\Customer\CustomerEditPage;
use Tests\Browser\Pages\Admin\Customer\CustomerIndexPage;

it('filters customers from an array', function () {
    $customers = [
        ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'status' => 'active'],
        ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'status' => 'inactive'],
        ['name' => 'Emily Davis', 'email' => 'emily.davis@example.com', 'status' => 'active'],
    ];

    // Filter customers by status 'active'
    $activeCustomers = array_filter($customers, fn($customer) => $customer['status'] === 'active');

    // Assert that the filtered array has 2 customers
    expect($activeCustomers)->toHaveCount(2)
        ->and($activeCustomers[0]['name'])->toBe('John Doe');
});

it('filters customers by email', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerIndexPage())
            ->filter('@customerList')
            ->filter('[data-email="john.doe@example.com"]') // Filters customers by email
            ->assertSee('John Doe');
    });
});

it('filters and lists customers by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerIndexPage())
            ->within('@customerList', function ($browser) {
                // List all customers
                $customers = $browser->elements('.customer');

                // Filter customers by name 'John Doe'
                $filteredCustomers = array_filter($customers, fn($customer) => str_contains($customer->getText(), 'John Doe'));

                // Assert that the filtered customers list contains only one item
                expect($filteredCustomers)->toHaveCount(1)
                    ->and($filteredCustomers[0]->getText())->toContain('John Doe');
            });
    });
});

it('lists all customers', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerIndexPage())
            ->within('@customerList', function ($browser) {
                // List all customers
                $customers = $browser->elements('.customer');

                // Assert that there is at least one customer in the list
                expect($customers)->toHaveCountGreaterThan(0)
                    ->and($customers[0]->getText())->toContain('John Doe');
            });
    });
});

it('creates a customer', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerCreatePage())
            ->click('@createButton')
            ->within(new CustomerFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'phone_number' => '1234567890',
                    'address' => '123 Main St, Springfield',
                    'communication_pref' => json_encode(['email', 'sms']),
                    'referral_code' => 'ABC123',
                    'referral_count' => 5,
                    'referred_by' => null, // Optional field
                ])->press('Save');
            })
            ->assertSee('Customer created successfully');
    });
});

it('edits a customer', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerEditPage())
            ->click('@editButton')
            ->within(new CustomerFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'John Doe Updated',
                    'email' => 'john.doe.updated@example.com',
                    'phone_number' => '0987654321',
                    'address' => '456 Elm St, Springfield',
                    'communication_pref' => json_encode(['email']),
                    'referral_count' => 10,
                ])->press('Save');
            })
            ->assertSee('Customer updated successfully');
    });
});

it('deletes a customer', function () {
    $this->browse(function ($browser) {
        $browser->visit(new CustomerIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this customer?')
            ->acceptDialog()
            ->assertSee('Customer deleted successfully');
    });
});
