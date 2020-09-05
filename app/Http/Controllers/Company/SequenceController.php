<?php

namespace App\Http\Controllers\Company;

use App\Campaign;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Sequence;
use Illuminate\Http\Request;

/**
 * This controller is use for attach and detaching contact from campaign
 */
class SequenceController extends Controller
{
    /**
     * Get sequences by given campaign
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Campaign $campaign)
    {
        $sequences = $campaign->sequences()->paginate(15);

        return response()->json($sequences);
    }

    /**
     * Store newly created sequence
     *
     * @param Request $request
     * @param int $campaign_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $campaign_id)
    {
        $campaign = Campaign::findOrFail($campaign_id);

        $sequence = new Sequence();
        $sequence->contact_id = $request->contact_id;
        $sequence->company_id = $campaign->company->id;
        $sequence->campaign_id = $campaign_id;
        $sequence->save();

        return response()->json($sequence);
    }

    /**
     * Delete selected
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($campaign_id, $id)
    {
        $sequence = company()->contacts()->where('campaign_id', $campaign_id)->findOrFail($id);
        $sequence->detachCampaign();

        return response()->json(['flash' => 'Sequence has been deleted'], 201);
    }


    /**
     * Delete one or multiple sequence
     *
     * @param Request $request
     * @param int $campaign_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMultiple(Request $request, $campaign_id)
    {
        $ids = $request->ids;

        if(count($ids)) {
            foreach ($ids as $id) {
                company()->contacts()->where('campaign_id', $campaign_id)->findOrFail($id)->detachCampaign();
            }

            return response()->json(['flash' => 'Successfully delete sequences'], 201);
        }

        return response()->json(['flash' => 'No sequence deleted'], 201);
    }
}
