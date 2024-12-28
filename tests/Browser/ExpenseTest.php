<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\ExpenseFormComponent;
use Tests\Browser\Pages\Admin\Expense\ExpenseCreatePage;
use Tests\Browser\Pages\Admin\Expense\ExpenseEditPage;
use Tests\Browser\Pages\Admin\Expense\ExpenseIndexPage;

it('filters expenses by amount', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseIndexPage())
            ->filter('@expenseList')
            ->filter('[data-amount="100.00"]') // Filters expenses with amount 100.00
            ->assertSee('100.00');
    });
});

it('filters and lists expenses by date', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseIndexPage())
            ->within('@expenseList', function ($browser) {
                // List all expenses
                $expenses = $browser->elements('.expense');

                // Filter expenses that are on a specific date
                $filteredExpenses = array_filter($expenses, fn($expense) => str_contains($expense->getText(), '2024-12-01'));

                // Assert that the filtered expenses list contains the desired date
                expect($filteredExpenses)->toHaveCountGreaterThan(0)
                    ->and($filteredExpenses[0]->getText())->toContain('2024-12-01');
            });
    });
});

it('lists all expenses', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseIndexPage())
            ->within('@expenseList', function ($browser) {
                // List all expenses
                $expenses = $browser->elements('.expense');

                // Assert that there is at least one expense in the list
                expect($expenses)->toHaveCountGreaterThan(0)
                    ->and($expenses[0]->getText())->toContain('Expense Name');
            });
    });
});

it('creates an expense', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseCreatePage())
            ->click('@createButton')
            ->within(new ExpenseFormComponent(), function ($browser) {
                $browser->fill([
                    'expense_type_id' => '1',  // Assuming 1 is a valid expense type ID
                    'store_id' => '1',         // Assuming 1 is a valid store ID
                    'date' => '2024-12-01',
                    'amount' => '100.00',
                    'note' => 'Office supplies purchase',
                ])->press('Save');
            })
            ->assertSee('Expense created successfully');
    });
});

it('edits an expense', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseEditPage())
            ->click('@editButton')
            ->within(new ExpenseFormComponent(), function ($browser) {
                $browser->fill([
                    'expense_type_id' => '2',  // Assuming 2 is a valid expense type ID
                    'store_id' => '2',         // Assuming 2 is a valid store ID
                    'date' => '2024-12-05',
                    'amount' => '150.00',
                    'note' => 'Updated office supplies purchase',
                ])->press('Save');
            })
            ->assertSee('Expense updated successfully');
    });
});

it('deletes an expense', function () {
    $this->browse(function ($browser) {
        $browser->visit(new ExpenseIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this expense?')
            ->acceptDialog()
            ->assertSee('Expense deleted successfully');
    });
});
