<?php
use App\Models\User;
use function Pest\Laravel\{actingAs, assertGuest};

it('log out an authenticated user', function(){
    $user = User::factory()->create();

    actingAs($user)

        ->visit('/')
        ->click('button[title="Secure Terminate Session"]')
        ->assertPathIs('/');

    assertGuest();

});
