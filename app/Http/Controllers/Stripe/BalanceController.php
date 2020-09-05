<?php

namespace App\Http\Controllers\Stripe;

use App\Facades\Stripe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Display user stripe account balance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $balance = Stripe::retrieveBalance();

        return response()->json(['balance' => $balance]);
    }
}
