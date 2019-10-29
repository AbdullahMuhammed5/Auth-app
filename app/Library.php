<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;

    protected $table = 'library';
    protected $with = ['file', 'image', 'video'];

    protected $fillable = [
        'name' ,'description', 'type', 'folder_id'
    ];

    public function folders()
    {
        return $this->belongsTo(Folder::class);
    }

    public function file(){
        return $this->morphOne(File::class, 'fileble');
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function video(){
        return $this->morphOne(Video::class, 'videoable');
    }
}
