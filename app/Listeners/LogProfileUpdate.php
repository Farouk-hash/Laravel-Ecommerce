<?php

namespace App\Listeners;

use App\Events\UserProfileUpdated;
use Illuminate\Support\Facades\Log;

class LogProfileUpdate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserProfileUpdated $event): void
    {

        $changes = $event->user->getChanges();
        if(!empty($changes)){
            $logDetails = [];
            $user = $event->user ; 
            foreach($changes as $key => $value){
                $originalValue = $user->getOriginal($key);
                $logDetails[] = "{$key}: Had changed from {$originalValue} to {$value}" ;
            }
            Log::info("CameFrom Listener: User-Id: {$event->user->id} Update Thier". implode(', ', $logDetails));
        }
    }
}
