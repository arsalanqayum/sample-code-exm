<?php

namespace App\Http\Controllers\Company;

use App\Campaign;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreSequenceType;
use App\SequenceType;
use App\Services\Company\CampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SequenceTypeController extends Controller
{
    /** @var CampaignService */
    public $campaignService;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    /**
     * Display all sequence types by given company id
     *
     * @param int $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($campaign_id)
    {
        $sequences_types = SequenceType::where('campaign_id', $campaign_id)->get();

        return response()->json($sequences_types);
    }

    /**
     * Display all sequence type and recipient status
     *
     * @param Campaign $campaign
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Campaign $campaign, $id)
    {
        $st = $campaign->sequence_types()->findOrFail($id);

        $recipients = $st->recipients()->with(['contact'])->paginate(15);

        return response()->json($recipients, 200);
    }

    /**
     * Create Sequence type
     *
     * @param int $campaign_id
     * @param StoreSequenceType $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($campaign_id, StoreSequenceType $request)
    {
        $data = $request->validated();

        $sequences_types = $request->sequence_types;

        try {
            //Determine if sequence type is store multiple or single
            if($data['multiple']) {
                foreach ($sequences_types as $st) {
                    $this->campaignService->updateOrCreateST($st, $campaign_id);
                }

                return response()->json(['flash' => 'Sequence types created']);
            }

            $st = new SequenceType($request->only(['start_date', 'template_id']));
            $st->campaign_id = $campaign_id;
            $st->save();

            return response()->json($st, 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(['flash' => 'Something went wrong'], 422);
        }
    }

    /**
     * Update sequence type by given id
     *
     * @param Request $request
     * @param Campaign $campaign
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Campaign $campaign, $id)
    {
        $data = $request->validate([
            'template_id' => 'required',
            'start_date' => 'required'
        ]);

        $sequence_type = $campaign->sequence_types()->findOrFail($id);

        $sequence_type->fill($data);
        $sequence_type->save();

        return response()->json(['flash' => 'Sequence updated'], 201);
    }

    /**
     * Destroy sequence type by given id
     *
     * @param int $campaign_id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($campaign_id, $id)
    {
        $sequence_type = SequenceType::where('campaign_id', $campaign_id)->findOrFail($id);

        $this->authorize('delete', $sequence_type);

        $sequence_type->delete();

        return response()->json(['flash' => 'Sequence Type successfully deleted']);
    }
}
