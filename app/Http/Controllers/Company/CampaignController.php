<?php

namespace App\Http\Controllers\Company;

use App\Campaign;
use App\Company;
use App\Contact;
use App\Events\Campaign\ContactImported;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaign;
use App\Services\Company\CampaignService;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /** @var CompanyService */
    public $companyService;

    /** @var CampaignService */
    public $campaignService;

    /**
     * Constuctor
     *
     * @param CompanyService $companyService
     * @param CampaignService $campaignService
     * @return void
     */
    public function __construct(CompanyService $companyService, CampaignService $campaignService)
    {
        $this->companyService = $companyService;
        $this->campaignService = $campaignService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $company = $this->companyService->getUserCompany($slug);

        $campaigns = Campaign::where('company_id', $company->id)->get();

        return response()->json($campaigns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $slug
     * @param StoreCampaignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignRequest $request)
    {
        $data = $request->validated();

        $company = auth()->user()->company;

        $campaign = new Campaign($data);
        $campaign->company_id = $company->id;
        $campaign->save();

        return response()->json($campaign);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::withCount(['contacts','sequence_types'])->findOrFail($id);

        if($campaign->status == Campaign::COMPLETED) {
            $campaign->canPayOwners = $campaign->canPayOwners();
            $campaign->hasPayOwners = $campaign->hasPayOwners();
        }

        return response()->json($campaign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCampaign  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCampaign $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->name = $request->name;
        $campaign->save();

        return response()->json($campaign, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Campaign::where('status', 'draft')->findOrFail($id)->delete();

        return response()->json(['flash' => 'Campaign removed'], 201);
    }

    /**
     * Start Campaign
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function startCampaign($id)
    {
        $campaign = Campaign::where('status', Campaign::DRAFT)->findOrFail($id);

        try {
            if(!$campaign->sequence_types->count()) {
                return response()->json(['flash' => 'Cannot start campaign, no sequence types provided'], 422);
            }

            $this->campaignService->handleCampaign($campaign);

            return response()->json(['flash' => 'Campaign Start'], 201);
        } catch (\Throwable $th) {

            return response()->json(['flash' => 'Something went wrong'], 422);
        }
    }

    /**
     * Import sequence from contact list
     *
     * @param Request $request
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function importSequence(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $request->validate([
            'contact_list_id' => 'required'
        ]);

        $contacts = Contact::where([
            'contact_list_id' => $request->contact_list_id,
            'status' => Contact::CONTACT
        ])->get();

        if(count($contacts)) {
            foreach ($contacts as $contact) {
                $contact->attachCampaign($campaign->id);
            }

            event(new ContactImported($contacts, $campaign));

            return response()->json(['flash' => 'Contact imported'], 201);
        }

        return response()->json(['flash' => 'No contact list imported'], 201);
    }

    /**
     * Prepare draft campaign template to be copy
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function copyCampaignTemplate(Request $request)
    {
        $campaign = Campaign::findOrFail($request->id);

        $company = Company::where('user_id', auth()->id())->firstOrFail();

        $companyCampaign = $this->campaignService->copyCampaignAndSequenceType($company, $campaign);

        if($companyCampaign) {
            return response()->json(['flash' => 'Campaign has been copied', 'campaign' => $companyCampaign], 201);
        }

        return response()->json(['flash' => 'Failed to copy campaign, please try again'], 422);
    }
}
