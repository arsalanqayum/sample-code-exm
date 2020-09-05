<?php

namespace App\Services\CompanyAdmin;

use App\Facades\Stripe;
use App\Order;
use App\PaymentHistory;

class OrderService
{
    /**
     * Pay reward or no depend on action
     *
     * @param array $data
     * @param mixed $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function payReward($data, $order)
    {
        if($data['accept']) {
            if(!$order->company) {
                return $this->transferReward($order);
            }
        }

        $order->user->reward->exchange('available_points', $order->amount );

        $order->status = Order::REJECTED;
        $order->save();

        return response()->json(['flash' => 'Order rejected'], 201);
    }

    /**
     * Transfer payment
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    private function transferReward(Order $order)
    {
        $transfer = Stripe::createTransfer(
            [
                'account_id' => $order->user->stripeAccount->account_id,
                'amount' => $order->amount * 100
            ],
            [
                'info' => 'reward'
            ]
        );

        if($transfer) {
            $order->user->paymentHistories()->create([
                'uniqid' => $transfer['id'],
                'type' => PaymentHistory::TRANSFER,
                'amount' => $transfer['amount'],
                'status' => 'succeeded',
                'description' => 'Reward transfer',
            ]);

            $order->status = Order::ACCEPTED;
            $order->save();

            return response()->json(['flash' => 'Balance transfer to owner'], 201);
        }

        return response()->json(['flash' => 'Failed to transfer balance'], 422);
    }
}