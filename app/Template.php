<?php

namespace App;

use App\Filters\TemplateFilter;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //Type
    const EMAIL = 'email';
    const SMS = 'sms';
    const VOICE = 'voice';

    /**
     * Field that are not mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get template category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template_category()
    {
        return $this->belongsTo('App\TemplateCategory');
    }

    /**
     * Get company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
     * Apply scope filter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param TemplateFilter $templateFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, TemplateFilter $templateFilter)
    {
        return $templateFilter->apply($query);
    }

    /**
     * scope of type for graphql
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        if($type != 'all') {
            return $query->where('type', $type);
        }

        return $query;
    }
}
