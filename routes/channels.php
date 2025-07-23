<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('send-message-{receiver_id}', function ($user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});


Broadcast::channel('typing-{user_id}', function ($user, $user_id) {
    return true;
});

Broadcast::channel('user-status-tracker', function ($user) {
    return true; // allow all authenticated users
});

