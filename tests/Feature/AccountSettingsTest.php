<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

// ═══════════════════════════════════════════════════════════════════
//  ACCOUNT SETTINGS ACCESS TESTS
// ═══════════════════════════════════════════════════════════════════

it('redirects guests to login when accessing account settings', function () {
    $this->get('/profile/account-settings')
        ->assertRedirect('/login');
});

it('allows an authenticated user to view the account settings page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/profile/account-settings')
        ->assertStatus(200)
        ->assertViewIs('profile.account-settings')
        ->assertSee('Account Identity')
        ->assertSee('Security Credentials')
        ->assertSee('Account Control')
        ->assertSee('Session Perimeter');
});

// ═══════════════════════════════════════════════════════════════════
//  IDENTITY PARAMETERS UPDATE TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows a user to update their identity parameters', function () {
    $user = User::factory()->create([
        'email' => 'old@pointcare.test',
        'phone' => '012-3456789',
    ]);

    $this->actingAs($user)
        ->post('/profile/account-settings/identity', [
            'email' => 'new@pointcare.test',
            'phone' => '019-9876543',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $user->refresh();
    expect($user->email)->toBe('new@pointcare.test')
        ->and($user->phone)->toBe('019-9876543');
});

it('validates identity unique email rule', function () {
    $otherUser = User::factory()->create(['email' => 'taken@pointcare.test']);
    $user = User::factory()->create(['email' => 'user@pointcare.test']);

    $this->actingAs($user)
        ->post('/profile/account-settings/identity', [
            'email' => 'taken@pointcare.test',
            'phone' => '012-3456789',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors(['email'], null, 'identity');

    $user->refresh();
    expect($user->email)->toBe('user@pointcare.test');
});

it('rejects identity updates with invalid phone formats', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/profile/account-settings/identity', [
            'email' => 'user@pointcare.test',
            'phone' => 'invalid-phone-123',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors(['phone'], null, 'identity');

    $user->refresh();
    expect($user->phone)->not->toBe('invalid-phone-123');
});

// ═══════════════════════════════════════════════════════════════════
//  SECURITY CREDENTIALS UPDATE TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows a user to update/rotate their password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $this->actingAs($user)
        ->post('/profile/account-settings/security', [
            'current_password' => 'old-password',
            'new_password' => 'new-secret-phrase',
            'new_password_confirmation' => 'new-secret-phrase',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $user->refresh();
    expect(Hash::check('new-secret-phrase', $user->password))->toBeTrue();
});

it('fails security rotation when current password is wrong', function () {
    $user = User::factory()->create([
        'password' => Hash::make('correct-password'),
    ]);

    $this->actingAs($user)
        ->post('/profile/account-settings/security', [
            'current_password' => 'wrong-password',
            'new_password' => 'new-secret-phrase',
            'new_password_confirmation' => 'new-secret-phrase',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors(['current_password'], null, 'security');
});

// ═══════════════════════════════════════════════════════════════════
//  SESSION REVOCATION TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows revoking other devices with correct password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('my-password'),
    ]);

    $this->actingAs($user)
        ->post('/profile/account-settings/revoke', [
            'current_password' => 'my-password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

// ═══════════════════════════════════════════════════════════════════
//  ACCOUNT DEACTIVATION TESTS
// ═══════════════════════════════════════════════════════════════════

it('allows a user to deactivate and delete their account', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/profile/account-settings/deactivate', [
            'confirm_deactivation' => '1',
        ])
        ->assertRedirect('/')
        ->assertSessionHasNoErrors();

    expect(User::find($user->id))->toBeNull()
        ->and(Auth::check())->toBeFalse();
});
