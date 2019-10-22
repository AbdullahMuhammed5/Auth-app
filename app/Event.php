<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_title', 'secondary_title', 'start_date', 'end_date',
        'content', 'published', 'location', 'address_latitude', 'address_longitude', 'cover'
    ];

//    protected $dates = [
//        'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'
//    ];

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileble');
    }

    public function visitors(){
        return $this->belongsToMany(Visitor::class);
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

    public function setStartDateAttribute($date)
    {
        return $this->attributes['start_date'] = Carbon::parse($date);
    }

    public function setEndDateAttribute($date)
    {
        return $this->attributes['end_date'] =  Carbon::parse($date);
    }

//    public function getStartDateAttribute($date)
//    {
////        $date = Carbon::parse($date);
////        $days = $date->diffInDays($date);
////        dd($days);
////        $hours = $date->copy()->addDays($days)->diffInHours($date);
////        $minutes = $date->copy()->addDays($days)->addHours($hours)->diffInMinutes($date);
////        return $minutes;
//        return Carbon::parse($date)->diffForHumans();
//    }

//    public function getEndDateAttribute($date)
//    {
//        return Carbon::parse($date)->diffForHumans();
//    }
}
