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

    public function scopeDateHasCame($query)
    {
        $now_formatted = Carbon::now()->format('Y-m-d H:i:s');
        $query->where('start_date', '<=', $now_formatted) // start date passed today
            ->where('end_date', '>=', $now_formatted); // end date not passed today
    }

    public function scopeDateNotComeYet($query)
    {
        $now_formatted = Carbon::now()->format('Y-m-d H:i:s');
        $query->where('start_date', '>=', $now_formatted) // today not come yet
            ->orWhere('end_date', '<=', $now_formatted); // today is passed
    }

    public function setStartDateAttribute($date)
    {
        return $this->attributes['start_date'] = Carbon::parse($date);
    }

    public function setEndDateAttribute($date)
    {
        return $this->attributes['end_date'] =  Carbon::parse($date);
    }

    public function getStartDateAttribute($date)
    {
//        $date = Carbon::parse($date);
//        $days = $date->diffInDays($date);
//        dd($days);
//        $hours = $date->copy()->addDays($days)->diffInHours($date);
//        $minutes = $date->copy()->addDays($days)->addHours($hours)->diffInMinutes($date);
//        return $minutes;
        return Carbon::parse($date)->diffForHumans();
    }

    public function getEndDateAttribute($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}
