<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'country_id'
    ];

    public function country(){
        return $this->belongsTo(Country::Class);
    }

    public function countryName()
    {
        return $this->belongsTo(Country::Class)->select( 'name');
    }
}
