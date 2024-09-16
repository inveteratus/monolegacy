<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

it('can view the password recovery page', function () {
    $this
        ->get(route('password.recover'))
        ->assertSuccessful()
        ->assertViewIs('auth.forgot-password');
});

it('doesn\'t send anything to an unknown user', function () {
    Notification::fake();

    $this
        ->from(route('password.recover'))
        ->post(route('password.recover'), ['email' => 'bad@example.com'])
        ->assertRedirect(route('password.recover'))
        ->assertSessionHas(['status' => 'A password reset link has been emailed to you.']);

    Notification::assertNothingSent();
});

it('sends an email to a known user', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this
        ->from(route('password.recover'))
        ->post(route('password.recover'), ['email' => $user->email])
        ->assertRedirect(route('password.recover'))
        ->assertSessionHas(['status' => 'A password reset link has been emailed to you.']);

    Notification::assertSentTo($user, ResetPassword::class);
});
