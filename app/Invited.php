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
        return $this->belongsTo(Event::class, 'invited_id');
    }
}
