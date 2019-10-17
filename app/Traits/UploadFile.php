<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Custom Function to remove image
     *
     * @param $filePath
     * @return  string
     */
    public function remove($filePath){
        return Storage::delete($filePath);
    }



}
