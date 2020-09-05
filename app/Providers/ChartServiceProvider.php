<?php

namespace App\Providers;

use App\Charts\Chart;
use App\Charts\NumberOfChat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ChartServiceProvider extends ServiceProvider
{
    /** @var string */
    protected $namespace = 'App\Charts';

    /**
     * Register chart here
     * Should be inside App\Charts
     *
     * @var array
     */
    protected $charts = [
        'NumberOfChat',
        'RewardPaid'
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->charts as $chart) {
            $class = $this->namespace.'\\'.$chart;
            $handler = new $class();

            if($handler instanceof Chart) {
                $routeName = $handler->name ?: Str::snake($chart);

                Route::group([
                    'middleware' => 'auth:api',
                    'namespace' => $this->namespace,
                    'prefix' => config('charts.route_prefix')
                ], function() use($routeName, $chart) {
                    Route::get($routeName, $chart.'@handler');
                });
            }
        }
    }
}
