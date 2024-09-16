<?php

it('can view the index page', function () {
    $this
        ->get(route('index'))
        ->assertSuccessful()
        ->assertViewIs('index');
});
