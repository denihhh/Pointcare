<?php
use Illuminate\Support\Facades\Auth;
use App\Models\User;


it('logs in a user', function () {
    $user = User::factory()->create(['password'=>'danish123']);

    visit('/login')

        ->fill('email', $user->email)
        ->fill('password', 'danish123')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    visit('/login')
        ->assertPathIs('/');

    // visit('/')
    //    ->click('@logout-button');

    //$this->assertGuest();

    //expect(Auth::check())->toBeFalse();


});

