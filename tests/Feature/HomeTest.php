<?php

use App\Models\User;

it('can view the home page', function () {
    $this
        ->actingAs(User::factory()->create())
        ->get(route('home'))
        ->assertSuccessful()
        ->assertViewIs('home');
});
