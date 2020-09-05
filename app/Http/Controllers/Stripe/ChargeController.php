<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Create charge
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required',
            'source' => 'required'
        ]);

        $charge = Stripe::createCharge($data);

        if($charge) {
            return response()->json(['charge' => $charge, 'flash' => 'Add fund success'], 201);
        }

        return response()->json(['flash' => 'Failed to add fund, please try again'], 422);
    }
}
