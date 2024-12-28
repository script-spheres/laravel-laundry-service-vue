<?php

use Laravel\Dusk\Browser;

use Tests\Browser\Components\Admin\FinancialYearFormComponent;
use Tests\Browser\Pages\Admin\FinancialYear\FinancialYearCreatePage;
use Tests\Browser\Pages\Admin\FinancialYear\FinancialYearEditPage;
use Tests\Browser\Pages\Admin\FinancialYear\FinancialYearIndexPage;

it('filters financial years by name', function () {
    $this->browse(function ($browser) {
        $browser->visit(new FinancialYearIndexPage())
            ->filter('@financialYearList')
            ->filter('[data-name="FY 2023-2024"]') // Filters financial years by name
            ->assertSee('FY 2023-2024');
    });
});

it('lists all financial years', function () {
    $this->browse(function ($browser) {
        $browser->visit(new FinancialYearIndexPage())
            ->within('@financialYearList', function ($browser) {
                // List all financial years
                $financialYears = $browser->elements('.financial-year');

                // Assert that there is at least one financial year in the list
                expect($financialYears)->toHaveCountGreaterThan(0)
                    ->and($financialYears[0]->getText())->toContain('FY 2023-2024');
            });
    });
});

it('creates a financial year', function () {
    $this->browse(function ($browser) {
        $browser->visit(new FinancialYearCreatePage())
            ->click('@createButton')
            ->within(new FinancialYearFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'FY 2023-2024',
                    'description' => 'Financial year from April 2023 to March 2024',
                    'start_date' => '2023-04-01',
                    'end_date' => '2024-03-31',
                    'is_active' => true,
                ])->press('Save');
            })
            ->assertSee('Financial year created successfully');
    });
});

it('edits a financial year', function () {
    $this->browse(function ($browser) {
        $browser->visit(new FinancialYearEditPage())
            ->click('@editButton')
            ->within(new FinancialYearFormComponent(), function ($browser) {
                $browser->fill([
                    'name' => 'Updated FY 2023-2024',
                    'description' => 'Updated description for financial year',
                    'start_date' => '2023-04-01',
                    'end_date' => '2024-03-31',
                    'is_active' => false,
                ])->press('Save');
            })
            ->assertSee('Financial year updated successfully');
    });
});

it('deletes a financial year', function () {
    $this->browse(function ($browser) {
        $browser->visit(new FinancialYearIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this financial year?')
            ->acceptDialog()
            ->assertSee('Financial year deleted successfully');
    });
});
