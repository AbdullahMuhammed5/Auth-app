<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    protected $table = 'folders';

    protected $fillable = [
        'name' ,'description'
    ];

    public function library()
    {
        return $this->hasMany(Library::class);
    }

    public function authorizedUsers(){
        return $this->belongsToMany(Staff::class);
    }
}
