<?php

namespace App\Http\Controllers\Admin;

use App\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display all listing buyers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $buyers = Buyer::paginate(15);
        return response()->json($buyers,200);
    }
}
