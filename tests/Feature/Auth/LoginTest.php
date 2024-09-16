<?php

use App\Models\User;

it('can view the login page', function () {
    $this
        ->get(route('login'))
        ->assertSuccessful()
        ->assertViewIs('auth.login');
});

it('cannot post empty data to the login page', function () {
    $this
        ->from(route('login'))
        ->post(route('login'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
});

it('cannot login with invalid credentials', function () {
    $this
        ->from(route('login'))
        ->post(route('login'), ['email' => 'bad@example.com', 'password' => 'bad'])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors([
            'email' => 'Invalid credentials.',
        ]);
});

it('can login successfully', function () {
    $user = User::factory()->create();
    $this
        ->from(route('login'))
        ->post(route('login'), ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('home'))
        ->assertSessionHasNoErrors();
});
