<?php

use App\Models\AddonService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);  // Refresh the database for each test

it('loads the addon services index page', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Create some addon services
    AddonService::factory()->count(5)->create();

    // Make a GET request to the index page
    $response = get(route('addon-services.index'));

    // Assert that the page loads successfully and the correct data is passed
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->has('addonServices') && $page->has('filters'));
});

it('loads the create page for addon services', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Make a GET request to the create page
    $response = get(route('addon-services.create'));

    // Assert that the page loads successfully
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('AddonService/AddonServiceForm'));
});

it('stores a new addon service', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Define the data to be stored
    $data = [
        'name' => 'New Addon Service',
        'price' => 100,
        'description' => 'Test description for the addon service',
    ];

    // Make a POST request to store the addon service
    $response = post(route('addon-services.store'), $data);

    // Assert that the addon service is stored in the database
    $this->assertDatabaseHas('addon_services', $data);

    // Assert the redirection after storing
    $response->assertRedirect(route('addon-services.index'));
    $response->assertSessionHas('message', 'Created successfully');
});

it('shows a specific addon service', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Create an addon service
    $addonService = AddonService::factory()->create();

    // Make a GET request to show the addon service
    $response = get(route('addon-services.show', $addonService));

    // Assert that the page loads successfully and the correct data is passed
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->has('addonService'));
});

it('loads the edit page for an addon service', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Create an addon service
    $addonService = AddonService::factory()->create();

    // Make a GET request to the edit page
    $response = get(route('addon-services.edit', $addonService));

    // Assert that the page loads successfully and the correct data is passed
    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->has('addonService'));
});

it('updates an addon service', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Create an addon service
    $addonService = AddonService::factory()->create();

    // Define the data to update
    $updatedData = [
        'name' => 'Updated Addon Service',
        'price' => 200,
        'description' => 'Updated description for the addon service',
    ];

    // Make a PUT request to update the addon service
    $response = put(route('addon-services.update', $addonService), $updatedData);

    // Assert that the addon service is updated in the database
    $this->assertDatabaseHas('addon_services', $updatedData);

    // Assert the redirection after updating
    $response->assertRedirect(route('addon-services.index'));
    $response->assertSessionHas('message', 'Updated successfully');
});

it('deletes an addon service', function () {
    // Create an authenticated user
    $user = User::factory()->create();

    // Act as the authenticated user
    actingAs($user);

    // Create an addon service
    $addonService = AddonService::factory()->create();

    // Make a DELETE request to delete the addon service
    $response = delete(route('addon-services.destroy', $addonService));

    // Assert that the addon service is deleted from the database
    $this->assertDeleted($addonService);

    // Assert the redirection after deleting
    $response->assertRedirect(route('addon-services.index'));
    $response->assertSessionHas('message', 'Deleted successfully');
});
