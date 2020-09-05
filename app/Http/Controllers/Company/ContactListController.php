<?php

namespace App\Http\Controllers\Company;

use App\Company;
use App\ContactList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactListController extends Controller
{
    /**
     * Get all contact lists owned by auth user
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($slug)
    {
        if(auth()->user()->type == 'admin') {
            $company = Company::whereSlug($slug)->firstOrFail();
        } else {
            $company = auth()->user()->companies()->whereSlug($slug)->firstOrFail();
        }

        $contact_lists = $company->contact_lists()->withCount('contacts')->where('company_id', $company->id)->paginate(15);

        return response()->json($contact_lists);
    }

    /**
     * Create auth user contact list
     *
     * @param string $slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($slug, Request $request)
    {
        $company = auth()->user()->companies()->whereSlug($slug)->firstOrFail();

        $data = $request->validate([
            'name' => 'required'
        ]);

        $contact_list = new ContactList();
        $contact_list->fill($data);
        $contact_list->company_id = $company->id;
        $contact_list->save();

        $contact_list->contacts_count = $contact_list->contacts->count();

        return response()->json($contact_list);
    }

    /**
     * Update selected contact list by given id
     *
     * @param string $slug
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($slug, $id, Request $request)
    {
        auth()->user()->companies()->whereSlug($slug)->firstOrFail();

        $data = $request->validate([
            'name' => 'required',
        ]);

        $contact_list = ContactList::findOrFail($id);
        $contact_list->fill($data);
        $contact_list->save();

        return response()->json($contact_list);
    }
}
