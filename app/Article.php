<?php

namespace App;

use App\Filters\ArticleFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * Get article category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\ArticleCategory');
    }

    /**
     * Scope filter
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ArticleFilter $articleFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, ArticleFilter $articleFilter)
    {
        return $articleFilter->apply($query);
    }
}
