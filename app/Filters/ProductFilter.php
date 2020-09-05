<?php

namespace App\Filters;

class ProductFilter extends Filter
{
    /**
     * Scope filter attributes
     *
     * @var array
     */
    protected $filters = ['name', 'age', 'category_id'];

    /**
     * Search product by given name
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($name)
    {
        if($name) {
            return $this->builder->where('name', 'like', "%$name%");
        }

        return $this->builder;
    }

    /**
     * Search product by given user demographic age
     *
     * @param string $age
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function age($age)
    {
        if($age) {
            $this->builder->whereHas('user', function($query) use($age) {
                $query->whereHas('profile', function($q) use($age) {
                    $q->where('age', $age);
                });
            });
        }

        return $this->builder;
    }

    /**
     * Filter product by category
     *
     * @param int $category_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function category_id($category_id)
    {
        if($category_id) {
            return $this->builder->where('category_id', $category_id);
        }

        return $this->builder;
    }
}