<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserChatStatus implements ShouldBroadcast , ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id ;
    public $user_status ;  
    public function __construct($user_id , $user_status)
    {
        $this->user_id = $user_id ; 
        $this->user_status = $user_status ; // online , offline ;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user-status-tracker'), // one shared channel for all users
        ];
    }


    // rename broadcast ; 
    // public function broadcastAs(): string
    // {
    //     return 'UserStatusChanged';
    // }
}
