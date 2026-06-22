<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class NotificationList extends Component
{
    use WithPagination;

    protected $listeners = ['notifications-updated' => '$refresh'];

    public function markAsRead($id)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                $this->dispatch('notifications-updated');
            }
        }
    }

    public function deleteNotification($id)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->where('id', $id)->first();
            if ($notification) {
                $notification->delete();
                $this->dispatch('notifications-updated');
            }
        }
    }

    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            $this->dispatch('notifications-updated');
        }
    }

    public function render()
    {
        $notifications = collect();

        if (Auth::check()) {
            $notifications = Auth::user()->notifications()->paginate(10);
        }

        return view('livewire.notification-list', [
            'notifications' => $notifications,
        ]);
    }
}
