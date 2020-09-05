<?php

namespace App\Mail;

use App\InstantAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstantAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var InstantAlert */
    public $instantAlert;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(InstantAlert $instantAlert)
    {
        $this->instantAlert = $instantAlert;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.instant_alert', [
            'body' => $this->instantAlert->body,
        ])->subject('Instant Alert');
    }
}
