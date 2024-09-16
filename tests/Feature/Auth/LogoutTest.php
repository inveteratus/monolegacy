<?php

use App\Models\User;

it('can logout successfully', function () {
    $this
        ->actingAs(User::factory()->create())
        ->post('logout')
        ->assertRedirect(route('index'))
        ->assertSessionHasNoErrors();
});
