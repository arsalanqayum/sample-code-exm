<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Show all company transactions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transactions = company()->transactions()->paginate(12);

        return response()->json($transactions);
    }
}
