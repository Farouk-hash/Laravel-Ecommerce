<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $value;
    public $user ; 
    public function __construct(string $value , User $user)
    {
        $this->value = $value;
        $this->user = $user ; 
    }

    public function build()
    {
        return $this->subject('Thanks for Subscribing!')
                    ->view('Application.emails.subscribed')
                    ->with([
                        'customMessage' => $this->value,
                        'user' => $this->user,
                        'appName' => config('app.name'),
                        'year' => date('Y')
                    ]);
    }
}
