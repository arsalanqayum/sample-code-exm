<?php

use App\Campaign;
use App\SequenceType;
use App\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SequenceType::unguard();

        $new = Campaign::create([
            'company_id' => null,
            'name' => 'New Owner Invite',
            'prebuilt' => true,
            'type' => 'sms',
            'chat_purpose' => 'support',
            'end_date' => now()->addWeek(1)
        ]);

        $this->createNewOwnerCampaign($new);

        $prev = Campaign::create([
            'company_id' => null,
            'name' => 'Previous Owner Invite',
            'prebuilt' => true,
            'type' => 'email',
            'chat_purpose' => 'sales',
            'end_date' => now()->addWeek(1)
        ]);

        $this->createPrevOwnerAndProspectCampaign($prev);

        $prospect = Campaign::create([
            'company_id' => null,
            'name' => 'Prospect Invite',
            'prebuilt' => true,
            'type' => 'email',
            'chat_purpose' => 'sales',
            'end_date' => now()->addWeek(1)
        ]);

        $this->createPrevOwnerAndProspectCampaign($prospect);

        SequenceType::reguard();
    }

    /**
     * Get template by name and return id
     *
     * @param string $name
     * @return int
     */
    private function getTemplate($name)
    {
        return Template::where('name', $name)->first()->id;
    }

    /**
     * New Owner Invite Campaign
     *
     * @param Campaign $campaign
     * @return void
     */
    private function createNewOwnerCampaign(Campaign $campaign)
    {
        $campaign->sequence_types()->createMany([
            [
                'template_id' => $this->getTemplate('Register Invitation'),
                'prebuilt_start_day_after' => 2,
            ],
        ]);
    }

    /**
     * Preview owner campaign
     *
     * @param Campaign $campaign
     * @return void
     */
    private function createPrevOwnerAndProspectCampaign(Campaign $campaign)
    {
        $campaign->sequence_types()->createMany([
            [
                'template_id' => $this->getTemplate('How it works'),
                'prebuilt_start_day_after' => 0,
            ],
            [
                'template_id' => $this->getTemplate('How much you can earn'),
                'prebuilt_start_day_after' => 3,
            ],
            [
                'template_id' => $this->getTemplate('Top questions'),
                'prebuilt_start_day_after' => 7,
            ],
            [
                'template_id' => $this->getTemplate('Last request'),
                'prebuilt_start_day_after' => 14,
            ]
        ]);
    }
}
