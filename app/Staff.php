<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model{

    use SoftDeletes;
    protected $with = ['user', 'city', 'country', 'job', 'user.roles'];
    protected $table = 'staffs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'image', 'job_id', 'country_id', 'city_id', 'gender', 'is_active'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function job(){
        return $this->belongsTo('App\Job');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }
}
