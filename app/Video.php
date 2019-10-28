<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'path'
    ];

    /**
     * Get the owning imageable model.
     */
    public function videoable()
    {
        return $this->morphTo();
    }
}
