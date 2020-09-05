<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Get user's balance, if auth user type is company, show company valance
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if(auth()->user()->type == 'company') {
            return response()->json(company()->wallet);
        }

        return response()->json(auth()->user()->wallet);
    }
}
