<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    protected $listeners = ['notifications-updated' => '$refresh'];

    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->dispatch('notifications-updated');
        }
    }

    public function markAsRead($id)
    {
        if (Auth::check()) {
            $notification = Auth::user()->unreadNotifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                $this->dispatch('notifications-updated');
            }
        }
    }

    public function render()
    {
        $notifications = collect();
        $unreadCount = 0;

        if (Auth::check()) {
            $user = Auth::user();
            $unreadCount = $user->unreadNotifications()->count();
            $notifications = $user->notifications()->take(5)->get();
        }

        return view('livewire.notification-bell', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
