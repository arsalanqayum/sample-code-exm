<?php

namespace App\Jobs;

use App\InstantAlert as AppInstantAlert;
use App\InstantAlertRecipient;
use App\Mail\InstantAlertMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InstantAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var AppInstantAlert */
    public $instantAlert;

    /** @var InstantAlertRecipient */
    public $recipient;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AppInstantAlert $instantAlert, InstantAlertRecipient $recipient)
    {
        $this->instantAlert = $instantAlert;
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipient->contact->email)
            ->send(new InstantAlertMail($this->instantAlert));

        $this->recipient->changeStatus(InstantAlertRecipient::SENT);
    }

    /**
     * Handle failed job
     *
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->recipient->changeStatus(InstantAlertRecipient::FAILED);
    }
}
