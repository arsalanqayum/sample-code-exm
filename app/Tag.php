<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    const CONTACT = 'contact';

    /**
     * Field that are mass assignment
     *
     * @var array
     */
    protected $fillable = ['name', 'type'];

    /**
     * event when saving tag
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving( function($tag) {
            $tag->slug = Str::slug($tag->name);
        });
    }

    /**
     * Get all contacts
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function contacts()
    {
        return $this->morphedByMany('App\Contact','taggable');
    }

    /**
     * Get the owning of tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function taggable()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include tags of a given name
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->where('name', 'like', "%$name%");
    }
}
