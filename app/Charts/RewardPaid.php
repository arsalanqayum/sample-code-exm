<?php

namespace App\Charts;

use App\Transaction;
use Illuminate\Http\Request;

class RewardPaid extends Chart
{
    /**
     * Handles the HTTP request for the given chart.
     * and never a string or an array.
     */
    public function handler(Request $request)
    {
        $rewards_paid = company()->transactions()
        ->whereJsonContains('meta->type', Transaction::REWARD_PAY)
        ->whereDate('created_at', '>=', now()->subDays($request->day))
        ->count();

        return response()->json([
            'data_exist' => $rewards_paid > 0,
            'collection' => [
                'labels' => ['Reward Paid'],
                'datasets' => [
                    [
                        'label' => 'Reward Paid',
                        'data' => [$rewards_paid],
                        'backgroundColor' => '#f87979'
                    ]
                ]
            ]
        ]);
    }
}