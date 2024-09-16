<?php

use App\Models\User;

it('can view the registration page', function () {
    $this
        ->get(route('register'))
        ->assertSuccessful()
        ->assertViewIs('auth.register');
});

it('cannot post empty data to the registration page', function () {
    $this
        ->from(route('register'))
        ->post(route('register'))
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
});

it('can register a new user', function () {
    $this
        ->from(route('register'))
        ->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('home'))
        ->assertSessionHasNoErrors();
});

it('cannot register a duplicate user', function () {
    $user = User::factory()->create();
    $this
        ->from(route('register'))
        ->post(route('register'), ['name' => $user->name, 'email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
            'email' => 'The email has already been taken.',
        ]);
});
