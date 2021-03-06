<?php

namespace App\Http\Controllers;

use App\File;
use App\Image;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    use UploadFile;

    protected $imagesAcceptedTypes = ['jpeg', 'jpg', 'png'];

    public function fileStore(Request $request)
    {
        return $this->upload($request['file']);
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        $fileType =  $request->get('type');
        // first check for type
        if (in_array($fileType, $this->imagesAcceptedTypes)){ // if file is image delete from DB if exist
            Image::where('path', $filename)->delete();
        } else{ // if file not image, delete from DB if exist
            File::where('path', $filename)->delete();
        }
        return $filename;
    }

    public function getFiles($id, $type) // get data for dropzone init function
    {
        $images = Image::where('imageable_id', $id)->where('imageable_type', 'App\\'.$type)->get()->toArray();
        $files = File::where('fileble_id', $id)->where('fileble_type', 'App\\'.$type)->get()->toArray();

        $files = array_merge($files, $images);
        $result = [];

        foreach ($files as $file){
            $size = Storage::size($file['path']);
            $type = pathinfo(Storage::url($file['path']), PATHINFO_EXTENSION);
            array_push($result, ['name' => $file['path'], 'size' => $size, 'type' => $type]);
        }

        return response()->json($result);
    }

}
