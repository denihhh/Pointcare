<?php
use App\Models\User;
use function Pest\Laravel\{actingAs, assertGuest};

it('log out an authenticated user', function(){
    $user = User::factory()->create();

    actingAs($user)

        ->visit('/')
        ->click('@profile-dropdown')
        ->click('@logout-button')
        ->assertPathIs('/');

    assertGuest();

});
