<?php

use App\Models\User;
use App\Models\ContactMessage;
use App\Livewire\AdminDashboard;
use Livewire\Livewire;

it('denies support messages access to non-admin users', function () {
    $patient = User::factory()->create(['role' => 'patient']);

    // Non-admins get redirected when trying to hit the dashboard endpoint
    $this->actingAs($patient)
        ->get('/admin/dashboard')
        ->assertStatus(403);
});

it('allows admin users to view support messages list and statistics', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    
    ContactMessage::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'subject' => 'Technical System Bugs',
        'message' => 'Help! The application is not loading properly on my device.',
        'status' => 'pending',
    ]);

    Livewire::actingAs($admin)
        ->test(AdminDashboard::class)
        ->set('activeTab', 'messages')
        ->assertSee('John Doe')
        ->assertSee('Technical System Bugs')
        ->assertSee('Help! The application')
        ->assertSee('Pending')
        ->assertViewHas('totalMessages', 1)
        ->assertViewHas('pendingMessagesCount', 1);
});

it('allows admin users to toggle support message resolution status', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    
    $message = ContactMessage::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'General Inquiries',
        'message' => 'I would like to inquire about your clinic services and doctor schedules.',
        'status' => 'pending',
    ]);

    Livewire::actingAs($admin)
        ->test(AdminDashboard::class)
        ->call('toggleMessageStatus', $message->id)
        ->assertHasNoErrors();

    // Verify database record status updated to resolved
    $message->refresh();
    expect($message->status)->toBe('resolved');

    // Toggle back to pending
    Livewire::actingAs($admin)
        ->test(AdminDashboard::class)
        ->call('toggleMessageStatus', $message->id)
        ->assertHasNoErrors();

    $message->refresh();
    expect($message->status)->toBe('pending');
});

it('allows admin users to delete support messages', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    
    $message = ContactMessage::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'General Inquiries',
        'message' => 'This is a test contact message that is at least ten characters long.',
        'status' => 'pending',
    ]);

    expect(ContactMessage::count())->toBe(1);

    Livewire::actingAs($admin)
        ->test(AdminDashboard::class)
        ->call('deleteMessage', $message->id)
        ->assertHasNoErrors();

    expect(ContactMessage::count())->toBe(0);
});
