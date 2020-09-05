<?php

namespace App\Services;

class PaymentHistoryService
{
    /**
     * Create payment history for user or company
     *
     * @param mixed $model
     * @param array $data
     * @return void
     */
    public function createPaymentHistory($model, $data)
    {
        $model->paymentHistories()->create([

        ]);
    }
}