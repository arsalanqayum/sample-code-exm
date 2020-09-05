<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Display all company stats
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $contacts = company()->contacts()->where('campaign_id', '!=', null)->count();
        $campaigns = company()->campaigns->count();
        $users = company()->users()->with(['user'])->get();

        return response()->json([
            'contacts' => $contacts,
            'campaigns' => $campaigns,
            'users' => $users
        ]);
    }
}
