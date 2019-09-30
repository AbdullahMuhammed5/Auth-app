<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model{

    use SoftDeletes;
    protected $table = 'staffs';

    public static function boot()
    {
        parent::boot();

        static::deleting(function($staff)
        {
            $staff->user()->delete();
        });
    }

    public function getIsActiveAttribute($value)
    {
        return $value == 0 ? 'Inactive' : 'Active';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'image', 'job_id', 'country_id', 'city_id', 'gender', 'is_active'
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
}
