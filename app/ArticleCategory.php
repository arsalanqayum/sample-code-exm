<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * Get articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
