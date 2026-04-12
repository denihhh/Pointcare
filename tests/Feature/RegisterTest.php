<?php
use Illuminate\Support\Facades\Auth;


it('registers a new user', function () {
    visit('/register')
        ->fill('name', 'Danish Haikal')
        ->fill('email', 'danish@example.com')
        ->fill('password', 'danish123')
        ->click('Create Account')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name'=>'Danish Haikal',
        'email'=>'danish@example.com',
    ]);
});

