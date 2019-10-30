<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;

    protected $table = 'library';
    protected $with = ['files', 'images', 'videos'];

    protected $fillable = [
        'name' ,'description', 'type', 'folder_id'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function files(){
        return $this->morphMany(File::class, 'fileble');
    }

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos(){
        return $this->morphMany(Video::class, 'videoable');
    }
}
