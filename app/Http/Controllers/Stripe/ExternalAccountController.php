<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExternalAccountController extends Controller
{
    /**
     * Store external account to owner stripe account
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'account_number' => 'required',
            'routing_number' => 'required',
        ]);

        $account = Stripe::createExternalAccount($data);

        if($account) {
            return response()->json(['account' => $account, 'flash' => 'Bank Account added'], 201);
        }

        return response()->json(['flash' => 'Failed to add bank account'], 422);
    }
}
