<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class UserObserve
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $recepient = Auth::user();
        Notification::make()
        ->title('Pengguna baru dibuat')
        ->body('Tambah Data')
        ->sendToDatabase($recepient);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
