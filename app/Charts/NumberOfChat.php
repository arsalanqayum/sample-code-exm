<?php

namespace App\Charts;

use App\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NumberOfChat extends Chart
{
    /** @var array */
    protected $labels = [
        'in_progress', 'pending', 'terminated', 'waiting_feedback'
    ];

    /**
     * Handles the HTTP request for the given chart.
     * and never a string or an array.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources
     */
    public function handler(Request $request)
    {
        $query = $request->validate([
            'day' => 'nullable|in:1,7,30'
        ]);

        $userIds = CompanyUser::where('company_id', company()->id)->get()->pluck('user_id');

        $chats = DB::table('owner_chats')
        ->whereIn('user_id', $userIds)
        ->whereDate('created_at', '>=', now()->subDays($request->day))
        ->get();

        $chatsCount = collect($this->labels)->map(function($label) use($chats) {
            return $chats->where('status', $label)->count();
        })->toArray();

        return response()->json([
            'data_exist' => count($chats),
            'collection' => [
                'labels' => $this->labelsToTitle($this->labels),
                'datasets' => [
                    [
                        'label' => 'Number of Chat',
                        'data' => $chatsCount,
                        'backgroundColor' => ['#63b3ed', '#faf089', '#f56565']
                    ]
                ]
            ]
        ]);
    }
}