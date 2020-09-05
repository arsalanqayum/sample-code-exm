<?php

namespace App\Http\Controllers\Company;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Store company balance after payment intent success
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $intent = Stripe::showPaymentIntent($request->only(['id', 'client_secret', 'amount']));

        if(!$intent) {
            return response()->json(['flash' => 'Balance failed to update'], 422);
        }

        company()->deposit($request->amount, ['type' => Transaction::TOP_UP]);

        return response()->json(['intent' => $intent], 201);
    }
}
