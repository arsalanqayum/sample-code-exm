<?php

namespace App\Jobs;

use App\Contact;
use App\Mail\CampaignMail;
use App\RecipientStatus;
use App\SequenceType;
use App\Template;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CampaignSequence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Contact */
    public $contact;

    /** @var SequenceType */
    public $sequenceType;

    /** @var Template */
    public $template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, SequenceType $sequenceType, Template $template)
    {
        $this->contact = $contact;
        $this->template = $template;
        $this->sequenceType = $sequenceType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->contact->email)
            ->send(new CampaignMail($this->contact, $this->template));

        $this->contact->changeStatus($this->sequenceType->id);
    }

    /**
     * Handle failed job
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->contact->changeStatus($this->sequenceType->id, RecipientStatus::FAILED);
    }
}
