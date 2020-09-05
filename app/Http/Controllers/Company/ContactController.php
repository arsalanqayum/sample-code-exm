<?php

namespace App\Http\Controllers\Company;

use App\Campaign;
use App\Contact;
use App\Events\Campaign\ContactImported;
use App\Filters\ContactFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\ImportContact;
use App\Http\Requests\Company\StoreContactRequest;
use App\Http\Requests\Company\UpdateContactRequest;
use App\Imports\ContactImport;
use App\Services\Company\CampaignService;
use App\Tag;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /** @var CampaignService */
    public $campaignService;

    /**
     * Constructor
     *
     * @param CampaignService $campaignService
     * @return void
     */
    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * Display all contacts owned by auth user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ContactFilter $contactFilter)
    {
        $contacts = Contact::with(['contact_list'])->where([
            'company_id' => company()->id,
        ])->filter($contactFilter)
        ->paginate(15);

        return response()->json($contacts);
    }

    /**
     * Import contact from csv file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $contact = new ContactImport();

        Excel::import($contact,$request->file('file'),\Maatwebsite\Excel\Excel::CSV);

        return response()->json($contact);
    }

    /**
     * Store imported contact
     *
     * @param ImportContact $reqeust
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeContact(ImportContact $request)
    {
        $contacts = $request->contacts;
        $tags = $request->tags;
        if(count($contacts)) {
            //insert contact if length > 0
            foreach ($contacts as $data) {
                $contact = new Contact();
                $contact->fill($data);
                $contact->company_id = company()->id;
                if($contact->save()) {
                    //Insert tags if length > 0
                    if(count($tags)) {
                        foreach($tags as $tag) {
                            $tag['type'] = 'contact';
                            $contact_tag = company()->tags()->firstOrCreate($tag);
                            $contact_tag->contacts()->save($contact);
                        }
                    }
                }
            }

            return response()->json('success',201);
        }

        return response()->json('empty');
    }

    /**
     * Store Company Contact
     *
     * @param StoreContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $contact = new Contact();
        $contact->fill($data);
        $contact->company_id = company()->id;
        $contact->save();

        if($contact->campaign_id) {
            $contacts = collect([$contact]);
            $campaign = Campaign::findOrFail($contact->campaign_id);
            event( new ContactImported($contacts, $campaign) );
        }

        return response()->json($contact, 201);
    }

    /**
     * Show Contact by the given id
     *
     * @param string $company
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $contact = Contact::with(['tags'])->findOrFail($id);

        return response()->json($contact);
    }

    /**
     * Update contact by the given id
     *
     * @param UpdateContactRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->fill($request->except(['tags']));
        $contact->save();

        if($request->has('tags')) {
            foreach ($request->tags as $tag) {
                company()->tags()->firstOrCreate([
                    'name' => Str::slug($tag['name']),
                    'type' => 'contact'
                ]);
            }

            $tags = collect($request->tags)->map(function($tag) {
                return $tag['name'];
            });

            $contactTags = Tag::whereIn('name', $tags)->get();

            $contact->tags()->sync($contactTags);
        }

        return response()->json(['contact' => $contact, 'flash' => 'Contact updated'], 201);
    }
}
