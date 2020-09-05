<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class crendetailMails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $url;
    public function __construct($user, $url)
    {
        $this->user=$user;
        $this->url=$url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->user);

        return $this->from('info@ownerchat.com') ->subject('Owners Login Credentials')->view('emails.register_mail');
    }
}
