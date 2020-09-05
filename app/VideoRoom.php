<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class VideoRoom extends Model
{
    protected $fillable = ['name', 'token'];
    /**
     * The "booting" model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($videoRoom) {
            $videoRoom->uuid = Uuid::uuid4();
        });
    }
}
