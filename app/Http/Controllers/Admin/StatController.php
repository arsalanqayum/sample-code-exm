<?php

namespace App\Http\Controllers\Admin;

use App\Campaign;
use App\Http\Controllers\Controller;
use App\Sequence;
use App\User;
use Illuminate\Http\Request;

class StatController extends Controller
{
    /**
     * Display stats for admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $campaigns = Campaign::count();

        $sequences = Sequence::count();

        $users = User::where('type', '!=', 'admin')->count();

        return response()->json([
            'campaigns' => $campaigns,
            'sequences' => $sequences,
            'users' => $users
        ]);
    }
}
