<?php

namespace App\Exceptions;

use \Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class StripeException extends AbstractException
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Stripe\Exception\ApiConnectionException::class,
        \Stripe\Exception\CardException::class,
        \Stripe\Exception\IdempotencyException::class,
    ];

    public function render($request)
    {
        $exception = $this->getPrevious();

        $message = Lang::get('payment.api.unknown');
        $httpCode = 500;

        Log::error($exception->getCode());

        Log::info(get_class($exception));

        switch (get_class($exception)) {
            case \Stripe\Exception\CardException::class:
                $httpCode = 422;
                $message = data_get(
                    $exception->getJsonBody(), 'error.message',
                    Lang::get('payment.api.invalid_card')
                );
                break;
            case \Stripe\Exception\RateLimitException::class:
                $message = Lang::get('payment.api.rate_limit');
                break;
            case \Stripe\Exception\InvalidRequestException::class:
                $httpCode = 422;
                // $message = Lang::get('payment.'.$exception->getStripeCode());
                $message = $exception->getMessage();
                break;
            case \Stripe\Exception\AuthenticationException::class:
                $message = Lang::get('payment.api.authentication');
                break;
            case \Stripe\Exception\ApiConnectionException::class:
                $message = Lang::get('payment.api.connection');
                break;
            case \Stripe\Exception\ApiErrorException::class:
                $message = Lang::get('payment.'.$exception->getStripeCode());
                break;
        }

        return Response::json(['flash' => $message], $httpCode);
    }
}
