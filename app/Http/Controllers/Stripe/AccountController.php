<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Stripe\StoreAccount;
use App\Http\Requests\Stripe\UpdateAccount;
use App\StripeAccount;

class AccountController extends Controller
{
    /**
     * Show user stripe account data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $stripeAccount = StripeAccount::where('user_id', auth()->id())->first();

        if(!$stripeAccount) {
            return response()->json(['account' => null]);
        }

        $account = Stripe::retrieve($stripeAccount->account_id);

        if(!$account && !$stripeAccount) {
            return response()->json(['account' => $account], 200);
        }

        return response()->json(['account' => $account]);
    }

    /**
     * Store stripe custom account both on stripe service and database
     *
     * @param StoreAccount $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAccount $request)
    {
        $data = $request->validated();

        $account = Stripe::createAccount($data);

        if($account) {
            Stripe::createStripeAccount($account);

            return response()->json(['flash' => 'Payment account created', 'account' => $account], 201);
        }

        return response()->json(['flash' => 'Something went wrong with our server'], 422);
    }

    /**
     * Update stripe account
     *
     * @param UpdateAccount $request
     * @param string $account_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccount $request, $account_id)
    {
        $data = $request->validated();

        if(Stripe::updateAccount($account_id, $data)) {
            return response()->json(['flash' => 'Payment account has been updated'], 201);
        }

        return response()->json(['flash' => 'failed to update account'], 422);
    }
}
