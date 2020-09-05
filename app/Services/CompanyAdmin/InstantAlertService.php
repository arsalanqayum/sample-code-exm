<?php

namespace App\Services\CompanyAdmin;

use App\Contact;
use App\InstantAlert;
use App\InstantAlertRecipient;
use App\Jobs\InstantAlert as InstantAlertJob;
use App\Notifications\InstantAlertSMS;
use Carbon\Carbon;

class InstantAlertService
{
    /**
     * Send email or sms to instant alert recipient.
     *
     * @param InstantAlert $instantAlert
     * @return void
     */
    public function send(InstantAlert $instantAlert)
    {
        $recipients = InstantAlertRecipient::where('instant_alert_id', $instantAlert->id)->get();

        $when = Carbon::create($instantAlert->start_date);
        $lte = $when->lte(now());

        if(count($recipients)) {
            if($instantAlert->type == 'email') {
                foreach ($recipients as $recipient) {
                    $job = InstantAlertJob::dispatch($instantAlert, $recipient);

                    if(!$lte) {
                        $job->delay($when);
                    }
                }
            }

            if($instantAlert->type == 'sms') {
                foreach ($recipients as $recipient) {
                    $contact = $recipient->contact;

                    if($lte) {
                        $contact->notify(
                            (new InstantAlertSMS($instantAlert, $recipient))
                        );
                    } else {
                        $contact->notify(
                            (new InstantAlertSMS($instantAlert, $recipient))->delay($when)
                        );
                    }
                }
            }
        }
    }

    /**
     * Import recipient by given import by parameter
     *
     * @param \App\InstantAlert $instantAlert
     * @param array $data
     * @param string $import_by
     * @return boolean
     */
    public function importRecipients($instantAlert, $data, $import_by)
    {
        $contacts = [];

        if($import_by == 'contact_list') {
            $contacts = Contact::where(['contact_list_id' => $data['contact_list_id'] ])->get();
        }

        $tags = collect($data['tags'])->pluck('id');

        $contacts = Contact::whereHas('tags', function($query) use($tags) {
            $query->whereIn('tag_id', $tags);
        })->get();

        foreach ($contacts as $contact) {
            $instantAlert->recipients()->firstOrCreate([
                'contact_id' => $contact->id,
            ]);
        }

        return count($contacts) ? true : false;
    }
}