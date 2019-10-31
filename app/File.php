<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
//    use SoftDeletes;

    protected $fillable = [
        'path'
    ];

    /**
     * Get the owning imageable model.
     */
    public function fileble()
    {
        return $this->morphTo();
    }

}
