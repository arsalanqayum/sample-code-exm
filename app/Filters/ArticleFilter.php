<?php

namespace App\Filters;

class ArticleFilter extends Filter
{
    /**
     * List of searchable column
     *
     * @var array
     */
    protected $filters = ['title', 'type'];


    /**
     * Search title by given title parameter
     *
     * @param string $title
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function title($title)
    {
        if($title) {
            return $this->builder->where('title', 'like', "%$title%");
        }

        return $this->builder;
    }
}