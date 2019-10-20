<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Override deleting behavior for parent
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($event)
        {
            $event->invited()->delete();
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_title', 'secondary_title', 'start_date', 'end_date', 'content', 'published', 'location', 'address_latitude', 'address_longitude'
    ];

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileble');
    }

    public function invitedVisitors(){
        return $this->hasMany(invited::class, 'event_id');
    }

    /**
     * Scope a query to only include published enws.
     *
     * @param Builder $query
     * @return void
     */
    public function scopePublished($query)
    {
        $query->whereIsPublished(True);
    }
}
