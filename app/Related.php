<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Related extends Model
{
    protected $table = "related";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'news_id', 'related_id'
    ];

    public function news(){
        return $this->belongsTo(News::class, 'related_id');
    }
}
