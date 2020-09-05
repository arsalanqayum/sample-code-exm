<?php

namespace App\Http\Controllers\Owner;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use App\PaymentHistory;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Create payout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required',
            'bank_account' => 'required'
        ]);

        return Stripe::createPayout($data);
    }
}
