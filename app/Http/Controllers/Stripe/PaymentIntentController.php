<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentIntentController extends Controller
{
    /**
     * Create payment intent
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required'
        ]);

        $intent = Stripe::createPaymentIntent($data);

        if($intent) {
            return response()->json(['intent' => $intent], 201);
        }

        return response()->json(['flash' => 'Failed to create payment, please try again'], 422);
    }
}
