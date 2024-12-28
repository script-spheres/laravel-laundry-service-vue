<?php

use Laravel\Dusk\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Browser\Components\Admin\TimeslotFormComponent;
use Tests\Browser\Pages\Admin\Timeslot\TimeslotCreatePage;
use Tests\Browser\Pages\Admin\Timeslot\TimeslotEditPage;
use Tests\Browser\Pages\Admin\Timeslot\TimeslotIndexPage;

it('filters timeslots by day', function () {
    $items = [
        ['day' => 'Monday', 'timeslots' => ['09:00', '10:00']],
        ['day' => 'Tuesday', 'timeslots' => ['11:00', '12:00']],
        ['day' => 'Monday', 'timeslots' => ['14:00', '15:00']],
    ];

    // Filter items by 'Monday'
    $mondayTimeslots = array_filter($items, fn($item) => $item['day'] === 'Monday');

    // Assert that the filtered array has 2 items
    expect($mondayTimeslots)->toHaveCount(2)
        ->and($mondayTimeslots[0]['timeslots'])->toBe(['09:00', '10:00']);
});

it('filters timeslots by day and shows available times', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotIndexPage())
            ->filter('@timeslotList')
            ->filter('[data-day="Monday"]') // Filter timeslots by day
            ->assertSee('09:00')
            ->assertSee('10:00');
    });
});

it('filters and lists timeslots by day', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotIndexPage())
            ->within('@timeslotList', function ($browser) {
                // List all timeslots for Monday
                $timeslots = $browser->elements('.timeslot');

                // Filter timeslots for 'Monday'
                $filteredTimeslots = array_filter($timeslots, fn($timeslot) => str_contains($timeslot->getText(), 'Monday'));

                // Assert that the filtered timeslots list contains only items for Monday
                expect($filteredTimeslots)->toHaveCountGreaterThan(0)
                    ->and($filteredTimeslots[0]->getText())->toContain('Monday');
            });
    });
});

it('lists all timeslots', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotIndexPage())
            ->within('@timeslotList', function ($browser) {
                // List all timeslots
                $timeslots = $browser->elements('.timeslot');

                // Assert that there is at least one timeslot in the list
                expect($timeslots)->toHaveCountGreaterThan(0)
                    ->and($timeslots[0]->getText())->toContain('09:00');
            });
    });
});

it('creates a new timeslot', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotCreatePage())
            ->click('@createButton')
            ->within(new TimeslotFormComponent(), function ($browser) {
                $browser->fill([
                    'day' => 'Monday',
                    'timeslots' => json_encode(['09:00', '10:00']), // JSON encoded timeslots
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Timeslot created successfully');
    });
});

it('edits an existing timeslot', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotEditPage())
            ->click('@editButton')
            ->within(new TimeslotFormComponent(), function ($browser) {
                $browser->fill([
                    'day' => 'Monday',
                    'timeslots' => json_encode(['11:00', '12:00']), // Update timeslots
                    'status' => 'active',
                ])->press('Save');
            })
            ->assertSee('Timeslot updated successfully');
    });
});

it('deletes a timeslot', function () {
    $this->browse(function ($browser) {
        $browser->visit(new TimeslotIndexPage())
            ->click('@deleteButton')
            ->assertDialogOpened('Are you sure you want to delete this timeslot?')
            ->acceptDialog()
            ->assertSee('Timeslot deleted successfully');
    });
});

