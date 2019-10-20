<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;
    public static $acceptedGender = ['Male' => 'Male', 'Female' => 'Female'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function($visitor)
        {
            $visitor->user()->delete();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'country_id', 'city_id', 'gender', 'is_active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::Class);
    }

    public function city(){
        return $this->belongsTo(City::Class);
    }

    /**
     * Get the Visitor's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * Scope a query to only include Active Visitors.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->whereIsActive(True);
    }
}
