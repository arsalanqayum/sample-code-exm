<?php

namespace App\Services\Company;

use App\Template;
use App\Campaign;
use App\Contact;
use App\SequenceType;
use App\Jobs\CampaignSequence;
use App\Notifications\Company\SMSCampaign;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    /**
     * Handle Campaign Service
     *
     * @param Campaign $campaign
     * @return void
     */
    public function handleCampaign($campaign)
    {
        foreach ($campaign->sequence_types as $sequence_type) {
            $template = Template::findOrFail($sequence_type->template_id);

            $contacts = $campaign->contacts;

            $when = Carbon::create($sequence_type->start_date); //Less than or equal to now

            if($campaign->prebuilt) {
                $when = now()->addDay($sequence_type->prebuilt_start_day_after);
            }

            $lte = $when->lte(now());

            if($campaign->type == 'email') {
                foreach ($contacts as $contact) {
                    if($contact->email) {
                        if(!$lte) {
                            CampaignSequence::dispatch($contact, $sequence_type, $template)->delay($when);
                        } else {
                            CampaignSequence::dispatch($contact, $sequence_type, $template);
                        }
                    }
                }
            }

            if($campaign->type == 'sms') {
                foreach ($contacts as $contact) {
                    if($contact->phone) {
                        if($lte) {
                            $contact->notify(
                                (new SMSCampaign($template))
                            );
                        } else {
                            $contact->notify(
                                (new SMSCampaign($template))->delay($when)
                            );
                        }
                    }
                }
            }
        }

        $campaign->status = Campaign::ACTIVE;
        $campaign->save();
    }

    /**
     * Copy campaign and sequence type to company
     *
     * @param \App\Company $company
     * @param \App\Campaign $campaign
     * @return mixed|boolean
     */
    public function copyCampaignAndSequenceType($company, $campaign)
    {
        DB::beginTransaction();

        try {
            $companyCampaign = $campaign->replicate();
            $companyCampaign->company_id = $company->id;
            $companyCampaign->prebuilt = false;
            $companyCampaign->save();

            foreach($campaign->sequence_types as $sequence_type) {
                $companySequenceType = $sequence_type->replicate();
                $companySequenceType->campaign_id = $companyCampaign->id;
                $companySequenceType->save();
            }
            DB::commit();

            return $companyCampaign;
        } catch (\Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Update or create sequence type
     *
     * @param mixed|array $data;
     * @param int $campaign_id
     * @return void
     */
    public function updateOrCreateST($data, $campaign_id)
    {
        if( isset($data['id']) ) {
            $sequence_type = SequenceType::where('campaign_id', $campaign_id)->findOrFail( $data['id'] );

            $sequence_type->fill(
                Arr::except($data, ['id'])
            );

            $sequence_type->save();
        } else {
            $sequences_type = new SequenceType();

            $sequences_type->fill($data);
            $sequences_type->campaign_id = $campaign_id;
            $sequences_type->save();
        }
    }

    /**
     * Add sequence to campaign by given contact_list_id
     *
     * @param int $campaign_id
     * @param int $contact_list_id
     * @return void
     */
    public function addSequences($campaign_id, $contact_list_id)
    {
        $campaign = Campaign::find($campaign_id);

        $contacts = Contact::where('user_id', auth()->id())->where('contact_list_id', $contact_list_id)->get();

        if($campaign) {
            foreach ($contacts as $contact) {
                $campaign->contacts()->create([
                    'contact_id' => $contact->id,
                ]);
            }
        }
    }
}