<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\StoreInstantAlertRequest;
use App\InstantAlert;
use App\Services\CompanyAdmin\InstantAlertService;
use Illuminate\Http\Request;

class InstantAlertController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $instantAlerts = InstantAlert::where('company_id', $company->id);

        if(auth()->user()->type == 'admin') {
            $instantAlerts = $instantAlerts->paginate(12);
        } else {
            $instantAlerts = $instantAlerts->where('user_id', auth()->id())->paginate(12);
        }

        return response()->json($instantAlerts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreInstantAlertRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company, StoreInstantAlertRequest $request)
    {
        $data = $request->validated();

        $instantAlert = new InstantAlert();
        $instantAlert->fill($data);
        $instantAlert->user_id = $company->user_id;
        $instantAlert->company_id = $company->id;

        $instantAlert->save();

        return response()->json($instantAlert,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, $id)
    {
        $instantAlert = InstantAlert::findOrFail($id);

        return response()->json($instantAlert);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Start instant alert
     *
     * @param Company $company
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Company $company, $id)
    {
        $instantAlert = InstantAlert::where('status', 'pending')->findOrFail($id);

        if(!count($instantAlert->recipients)) {
            return response()->json(['flash' => 'Cannot start instant alert, no recipients'], 422);
        }

        $instantAlert->status = InstantAlert::COMPLETED;
        $instantAlert->save();

        $this->instantAlertService->send($instantAlert);

        return response()->json(['flash' => 'Instant Alert started'], 201);
    }
}
