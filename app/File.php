<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
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
