<?php

namespace App\Services\Company;

use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Pay owner accounts inside campaign
     *
     * @param mixed $accounts
     * @return \Illuminate\Http\JsonResponse
     */
    public function payOwners($accounts)
    {
        if(!count($accounts)) {
            return response()->json(['flash' => 'accounts has been paid']);
        }

        DB::beginTransaction();

        try {
            foreach($accounts as $account) {
                company()->transfer($account->user, $account->earning, ['type' => Transaction::REWARD_PAY]);

                $account->paid = true;
                $account->save();
            }

            DB::commit();

            return response()->json(['flash' => 'accounts has been paid']);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            DB::rollBack();

            return response()->json(['message' => 'Failed to pay accounts'], 500);
        }
    }
}