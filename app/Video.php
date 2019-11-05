<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
//    use SoftDeletes;

    protected $fillable = [
        'path'
    ];

    /**
     * Get the owning videoable model.
     */
    public function videoable()
    {
        return $this->morphTo();
    }

}
