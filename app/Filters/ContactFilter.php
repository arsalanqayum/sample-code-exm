<?php

namespace App\Filters;

class ContactFilter extends Filter
{
    /**
     * Field that filterable
     *
     * @var array
     */
    protected $filters = ['contact_list_id', 'tags'];

    /**
     * Filter contact by given contact_list_id
     *
     * @param int $contact_list_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function contact_list_id($contact_list_id)
    {
        if($contact_list_id) {
            return $this->builder->where('contact_list_id', $contact_list_id);
        }

        return $this->builder;
    }

    /**
     * Filter contact by given tags
     *
     * @param string $stringTags
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function tags($stringTags)
    {
        if($stringTags) {
            $tags = explode(',', $stringTags);

            $this->builder->when(count($tags), function($query) use($tags) {
                foreach ($tags as $tag) {
                    $query->whereHas('tags', function($query) use($tag) {
                        $query->where('name', $tag);
                    });
                }
            });
        }

        return $this->builder;
    }
}