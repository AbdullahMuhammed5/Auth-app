<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model{

    use SoftDeletes;
    protected $table = 'staffs';
    public static $acceptedGender = ['Male' => 'Male', 'Female' => 'Female'];

    /**
     * Override deleting behavior for parent
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($staff)
        {
            $staff->user()->delete();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'job_id', 'country_id', 'city_id', 'gender', 'is_active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){
        return $this->belongsTo(Country::Class);
    }

    public function job(){
        return $this->belongsTo(Job::Class);
    }

    public function city(){
        return $this->belongsTo(City::Class);
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

    /**
     * Get the Staff's image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function folders(){
        return $this->belongsToMany(Folder::class);
    }
}
