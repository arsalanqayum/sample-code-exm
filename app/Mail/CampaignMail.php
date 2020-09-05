<?php

namespace App\Mail;

use App\Contact;
use App\Template;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Contact */
    public $contact;

    /** @var \App\Template */
    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Template $template)
    {
        $this->contact = $contact;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $body = replaceTemplate($this->template->body, $this->contact);
        $subject = replaceTemplate($this->template->subject, $this->contact);

        return $this->markdown('emails.campaigns.email', [
            'body' => $body
        ])->subject($subject);
    }
}
