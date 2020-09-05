<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class RegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $url;
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->from('info@ownerchat.com') ->subject('OwnersChat Login Credentials')->view('emails.register_mail');
    }
}
