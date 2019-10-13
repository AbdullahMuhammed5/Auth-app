<?php

namespace App\Traits;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait HelperMethods{
    /**
     * Custom Function to upload image
     *
     * @param File $image
     * @return  string
     */
    public function uploadImage($image){
        $imageName = time().$image->getClientOriginalName();
        Storage::disk('local')->put('public/images/'.$imageName,  File::get($image));
        return $imageName;
    }

    // additional methods for News module

    public function togglePublishing(News $news){ // publish news or un publish it
        $news->update(['published' => !$news->published ]);
        return "success";
    }

    public function createRelation(News $news, $items, $relation){ // add relation to News like (related news, images, files)
        foreach ($items as $item){
            $news->$relation()->create(['path' => time().$item->getClientOriginalName()]);
        }
    }

    public function uploadToServer(Request $request){ // upload images or files to server before send the request
        foreach ($request['files'] as $file){
            $this->uploadImage($file);
        }
        return "success";
    }

}
