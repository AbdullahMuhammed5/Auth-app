<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id'
    ];

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function countryName()
    {
        return $this->belongsTo('App\Country')->select( 'name');
    }
}
