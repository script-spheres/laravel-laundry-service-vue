<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\ExpenseTypeFormComponent;
use Tests\Browser\Pages\Admin\ExpenseType\ExpenseTypeCreatePage;
use Tests\Browser\Pages\Admin\ExpenseType\ExpenseTypeEditPage;
use Tests\Browser\Pages\Admin\ExpenseType\ExpenseTypeIndexPage;

it('filters expense types by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseTypeIndexPage())
            ->filter('@expenseTypeList')
            ->filter('[data-name="Office Supplies"]') // Filters expense types by name
            ->assertSee('Office Supplies');
    });
});

it('lists all expense types', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseTypeIndexPage())
            ->within('@expenseTypeList', function ($browser) {
                // List all expense types
                $expenseTypes = $browser->elements('.expense-type');

                // Assert that there is at least one expense type in the list
                expect($expenseTypes)->toHaveCountGreaterThan(0)
                    ->and($expenseTypes[0]->getText())->toContain('Office Supplies');
            });
    });
});

it('creates an expense type', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseTypeCreatePage())
            ->click('@createButton')
            ->within(new ExpenseTypeFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Office Supplies',
                    'description' => 'Expenses related to office supplies',
                ])->press('Save');
            })
            ->assertSee('Expense type created successfully');
    });
});

it('edits an expense type', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseTypeEditPage())
            ->click('@editButton')
            ->within(new ExpenseTypeFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated Office Supplies',
                    'description' => 'Updated description for office supplies',
                ])->press('Save');
            })
            ->assertSee('Expense type updated successfully');
    });
});

it('deletes an expense type', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseTypeIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this expense type?')
            ->acceptDialog()
            ->assertSee('Expense type deleted successfully');
    });
});
