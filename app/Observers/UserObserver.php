<?php

namespace App\Observers;

use App\Models\user;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the user "created" event.
     */
    public function created(user $user): void
    {
        Log::info("✅ New user registered: {$user->name} ({$user->email})");
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(user $user): void
    {
        $changes = $user->getChanges();
        if(!empty($changes)){
            $logDetails = [];
            foreach($changes as $key => $value){
                $originalValue = $user->getOriginal($key);
                $logDetails[] = "{$key}: Had changed from {$originalValue} to {$value}" ;
            }
            $logMessage = "CameFrom Observer: User updated (Email: {$user->email}) - Changes: " . implode(', ', $logDetails);
            Log::info($logMessage);
        }
    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(user $user): void
    {
        //
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(user $user): void
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(user $user): void
    {
        //
    }
}
