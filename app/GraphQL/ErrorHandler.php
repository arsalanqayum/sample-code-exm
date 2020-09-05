<?php

namespace App\GraphQL;

use Closure;
use GraphQL\Error\Error;
use Nuwave\Lighthouse\Execution\ErrorHandler as LightHouseErrorHandler;

class ErrorHandler implements LightHouseErrorHandler
{
    public static function handle(Error $error, Closure $next): array
    {
        if(app()->environment('production')) {
            $error = new Error(
                'Something went wrong',
            );
        }

        return $next($error);
    }
}