<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryFile extends Model
{
    use SoftDeletes;

    protected $table = 'library';

    protected $fillable = [
        'name' ,'description', 'type', 'folder_id'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }


}
