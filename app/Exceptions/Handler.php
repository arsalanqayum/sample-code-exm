<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Twilio\Exceptions\RestException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if(app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if($request->wantsJson() && $exception instanceof ModelNotFoundException) {
            return response()->json(['errors' => 'Not Found'], 404);
        }

        if($request->wantsJson() && $exception instanceof RestException) {
            return response()->json(['flash' => __('twilio.error.'.$exception->getCode())], 422);
        }

        if($exception instanceof StripeException) {
            return $exception->render($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
