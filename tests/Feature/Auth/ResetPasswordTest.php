<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;

it('can see password reset page ', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);
    $this
        ->get(route('password.reset', ['token' => $token]))
        ->assertSuccessful()
        ->assertViewIs('auth.reset-password');
});

it('can reset the password', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);
    $this
        ->from(route('password.reset', ['token' => $token]))
        ->post(route('password.reset.store'), ['email' => $user->email, 'password' => 'new-password', 'token' => $token])
        ->assertRedirect(route('login'))
        ->assertSessionHasNoErrors();
    $this->assertTrue(password_verify('new-password', $user->fresh()->password));
});
