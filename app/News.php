<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /**
     * Override deleting behavior for parent
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function($news)
        {
            $news->files()->delete();
            $news->images()->delete();
            $news->related()->delete();
        });
    }
    protected $fillable = [
        'main_title', 'secondary_title', 'author_id', 'type', 'content', 'published'
    ];

    public function staff(){
        return $this->belongsTo(Staff::class, 'author_id');
    }

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileble');
    }

    public function related(){
        return $this->hasMany(Related::class, 'news_id');
    }
}
