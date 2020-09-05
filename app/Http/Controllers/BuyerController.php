<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Http\Requests\StoreBuyer;
use App\Services\BuyerService;
use App\Services\VerificationService;
use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BuyerController extends Controller
{
    /** @var VerificationService */
    public $verificationService;

    /** @var BuyerService */
    public $buyerService;

    /**
     * Constructor
     *
     * @param VerificationService $verificationService
     * @param BuyerService $buyerService
     * @return void
     */
    public function __construct(VerificationService $verificationService, BuyerService $buyerService)
    {
        $this->verificationService = $verificationService;
        $this->buyerService = $buyerService;
    }

    /**
     * Store newly created buyer
     *
     * @param StoreBuyer $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBuyer $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $buyer = new Buyer($data);
            $buyer->save();

            $this->verificationService->sendVerification($buyer);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage());

            return response()->json(['flash' => 'Phone number is invalid'], 422);
        }

        return response()->json($buyer, 201);
    }

    /**
     * Verify buyer
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $verification = Verification::where('code', $request->code)->first();

        if(!$verification) {
            return response()->json(['flash' => 'Invalid verification code'], 422);
        }

        $verification->updateVerification();
        $verification->verificable->verify(true);

        $this->buyerService->notifyOwners($request, $verification->verificable);

        return response()->json(['flash' => 'Verification success'], 201);
    }
}
