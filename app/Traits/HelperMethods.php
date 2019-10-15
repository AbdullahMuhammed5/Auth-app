<?php

namespace App\Traits;

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

}
