<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadFile{
    /**
     * Custom Function to upload image
     *
     * @param $file
     * @return  string
     */
    public function upload(UploadedFile $file){
        return $file->store('public/uploads', 'local');
    }

}
