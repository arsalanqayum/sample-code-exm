<?php

namespace App\Filters;

use Illuminate\Support\Facades\Log;

class TemplateFilter extends Filter
{
    /**
     * Scope filter attributes
     *
     * @var array
     */
    protected $filters = ['type'];

    /**
     * Get templates by given type
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function type($type)
    {
        if($type && $type != 'all') {
            return $this->builder->where('type', $type);
        }

        return $this->builder;
    }
}