<?php

use Laravel\Dusk\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

it('creates a user in the database', function () {
    $user = \App\Models\User::factory()->create();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
    ]);
});

it('updates a user record in the database', function () {
    $user = \App\Models\User::factory()->create();

    $user->update([
        'name' => 'Updated Name',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
    ]);
});

it('deletes a user record from the database', function () {
    $user = \App\Models\User::factory()->create();

    $user->delete();

    $this->assertSoftDeleted('users', [
        'id' => $user->id,
    ]);
});

it('ensures unique email addresses for users', function () {
    $email = 'test@example.com';
    \App\Models\User::factory()->create(['email' => $email]);

    $this->expectException(\Illuminate\Database\QueryException::class);

    \App\Models\User::factory()->create(['email' => $email]);
});

it('hashes passwords before storing them', function () {
    $user = \App\Models\User::factory()->create(['password' => 'plaintext_password']);

    $this->assertTrue(Hash::check('plaintext_password', $user->password));
});

it('verifies email_verified_at is nullable', function () {
    $user = \App\Models\User::factory()->create(['email_verified_at' => null]);

    $this->assertNull($user->email_verified_at);
});

it('verifies the remember token is properly set', function () {
    $user = \App\Models\User::factory()->create();

    $this->assertNotEmpty($user->remember_token);
});
