<?php

namespace App\Notifications\Company;

use App\Template;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class SMSCampaign extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var Template */
    public $template;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    /**
     * Send to twilio
     *
     * @param mixed $notifiable
     * @return TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        $body = replaceTemplate($this->template->body, $notifiable);
        return (new TwilioSmsMessage())->content($body);
    }
}
