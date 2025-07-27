<?php

namespace App\Listeners;

use App\Events\UserSubcriber;
use App\Mail\SubscribedMail;
use Illuminate\Support\Facades\Mail;

class SendSubsriberEmail
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
    public function handle(UserSubcriber $event): void
    {
        Mail::to($event->user->email)
        ->send(new SubscribedMail('Welcome to our amazing community!' , $event->user));
    }
}
