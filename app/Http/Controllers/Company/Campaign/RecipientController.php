<?php

namespace App\Http\Controllers\Company\Campaign;

use App\Campaign;
use App\Events\Campaign\ContactDetached;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * This controller is use for attach and detaching contact from campaign
 */
class RecipientController extends Controller
{
    /**
     * Get sequences by given campaign
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Campaign $campaign)
    {
        $sequences = $campaign->contacts()->paginate(15);

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
        //
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

        event(new ContactDetached([$id], $campaign_id));

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

            event(new ContactDetached($ids, $campaign_id));

            return response()->json(['flash' => 'Successfully delete sequences'], 201);
        }

        return response()->json(['flash' => 'No sequence deleted'], 201);
    }
}
