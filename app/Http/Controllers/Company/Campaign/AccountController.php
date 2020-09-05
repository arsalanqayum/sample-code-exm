<?php

namespace App\Http\Controllers\Company\Campaign;

use App\Campaign;
use App\Http\Controllers\Controller;
use App\Services\Company\PaymentService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /** @var PaymentService */
    public $paymentService;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Display all owner that connected to campaign
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Campaign $campaign)
    {
        $accounts = $campaign->accounts()->with(['user'])->paginate(12);

        return response()->json($accounts);
    }

    /**
     * Update account
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Campaign $campaign, $id, Request $request)
    {
        $data = $request->validate([
            'status' => 'nullable|in:pending,active'
        ]);

        $account = $campaign->accounts()->findOrFail($id);
        $account->status = $data['status'];
        $account->save();

        return response()->json(['flash' => 'Owner Account Updated']);
    }

    /**
     * Remove owner from campaign
     *
     * @param Campaign $campaign
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Campaign $campaign, $id)
    {
        $campaign->accounts()->findOrFail($id)->delete();

        return response()->json(['flash' => 'Owner has been removed']);
    }

    /**
     * Pay multiple or single owner
     *
     * @param Campaign $campaign
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function payOwners(Campaign $campaign, Request $request)
    {
        $data = $request->validate([
            'ids' => 'required|array'
        ]);

        $accounts = $campaign->accounts()
            ->whereIn('id', $data['ids'])
            ->where('paid', false)
            ->get();

        $total = $accounts->sum('earning');

        if(company()->balance < $total) {
            return response()->json(['flash' => 'Your balance is not enough'], 422);
        }

        return $this->paymentService->payOwners($accounts);
    }
}
