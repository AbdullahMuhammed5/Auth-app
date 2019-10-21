<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invited extends Model
{
    protected $table = "invited";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'invited_id'
    ];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function visitors(){
        return $this->hasMany(Visitor::class, 'invited_id');
    }
}
