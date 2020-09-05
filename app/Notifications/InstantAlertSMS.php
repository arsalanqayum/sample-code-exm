<?php

namespace App\Notifications;

use App\InstantAlert;
use App\InstantAlertRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class InstantAlertSMS extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var InstantAlert */
    public $instantAlert;

    /** @var InstantAlertRecipient */
    public $recipient;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(InstantAlert $instantAlert, InstantAlertRecipient $recipient)
    {
        $this->instantAlert = $instantAlert;
        $this->recipient = $recipient;
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
        $this->recipient->changeStatus('sent');
        return (new TwilioSmsMessage())->content($this->instantAlert->body);
    }
}
