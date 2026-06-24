<?php

use App\Models\User;
use App\Models\ContactMessage;

it('loads the contact page successfully for guests', function () {
    $this->get('/contact')
        ->assertStatus(200)
        ->assertSee('Contact Support')
        ->assertSee('We are Here to')
        ->assertSee('Support You');
});

it('redirects authenticated users trying to access contact page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/contact')
        ->assertRedirect('/');
});

it('redirects authenticated users trying to access about page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/about')
        ->assertRedirect('/');
});

it('validates contact form submissions for guests', function () {
    $this->post('/contact', [])
        ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        
    expect(ContactMessage::count())->toBe(0);
});

it('submits contact form successfully with valid data for guests and saves to database', function () {
    $this->post('/contact', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'General Inquiries',
        'message' => 'This is a test contact message that is at least ten characters long.',
    ])
    ->assertRedirect()
    ->assertSessionHas('alert');

    expect(ContactMessage::count())->toBe(1);
    
    $message = ContactMessage::first();
    expect($message->name)->toBe('Jane Doe');
    expect($message->email)->toBe('jane@example.com');
    expect($message->subject)->toBe('General Inquiries');
    expect($message->message)->toBe('This is a test contact message that is at least ten characters long.');
    expect($message->status)->toBe('pending');
});
