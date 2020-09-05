<?php

namespace App\Charts;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

abstract class Chart
{
    /** @var string */
    public $name;

    /** @var array */
    protected $labels;

    /**
     * Handles the HTTP request of the chart. This must always
     * return the chart instance. Do not return a string or an array.
     */
    abstract public function handler(Request $request);

    /**
     * Convert array labels to title case
     *
     * @param array $labels
     * @return array
     */
    public function labelsToTitle($labels)
    {
        return collect($labels)->map(function($label) {
            $replace =  str_replace('_', ' ', $label);
            return Str::title($replace);
        })->toArray();
    }

    /**
     * Divide groups
     *
     * @param array $data
     * @return array
     */
    public function divide($data)
    {
        return Arr::divide($data);
    }

    /**
     * Build data into vue chart js collection
     *
     * @return mixed
     */
}
