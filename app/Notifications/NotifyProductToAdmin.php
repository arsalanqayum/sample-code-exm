<?php

namespace App\Notifications;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class NotifyProductToAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var Product */
    public $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
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
        $link = config('app.frontend_url'). "/sad/products/{$this->product->id}";

        $body = "New product verification pending. Please review > {$link}";

        return (new TwilioSmsMessage())->content($body);
    }
}
