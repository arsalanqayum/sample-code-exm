<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstantAlert;
use App\InstantAlert;
use App\InstantAlertRecipient;
use App\Services\CompanyAdmin\InstantAlertService;
use Illuminate\Http\Request;

class InstantAlertRecipientController extends Controller
{
    /** @var InstantAlertService */
    public $instantAlertService;

    /**
     * Constructor
     *
     * @param InstantAlertService $instantAlertService
     * @return void
     */
    public function __construct(InstantAlertService $instantAlertService)
    {
        $this->instantAlertService = $instantAlertService;
    }

    /**
     * Get all instant alert recipients by given instant alert id
     *
     * @param InstantAlert $instantAlert
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(InstantAlert $instantAlert)
    {
        $recipients = InstantAlertRecipient::with('contact')->where('instant_alert_id', $instantAlert->id)->get();

        return response()->json($recipients);
    }

    /**
     * Mass store instant alert recipient
     *
     * @param InstantAlert $instantAlert
     * @param StoreInstantAlert $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InstantAlert $instantAlert, StoreInstantAlert $request)
    {
        $data = $request->validated();

        $result = $this->instantAlertService->importRecipients($instantAlert,$data , $request->import_by);

        if($result) {
            return response()->json(['flash' => 'Contact imported'], 201);
        }

        return response()->json(['flash' => 'No contact imported'], 201);
    }

    /**
     * Delete one or multiple recipient base on request
     *
     * @param InstantAlert $instantAlert
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InstantAlert $instantAlert, Request $request)
    {
        $ids = $request->ids;

        if(count($ids)) {
            foreach ($ids as $id) {
                InstantAlertRecipient::where('instant_alert_id', $instantAlert->id)
                    ->findOrFail($id)->delete();
            }

            return response()->json(['flash' => 'Recipients deleted'], 201);
        }

        return response()->json(['flash' => 'No recipients deleted'], 201);
    }
}
