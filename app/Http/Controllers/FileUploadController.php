<?php

namespace App\Http\Controllers;

use App\File as FileModel;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    protected $imagesAcceptedTypes = ['jpeg', 'jpg', 'png'];

    public function fileStore(?Request $request, ?UploadedFile $fileData = null)
    {
        $file = $fileData ? $fileData : $request['file'];
        $fileName = $fileData ? time().$file->getClientOriginalName() : $file->getClientOriginalName();
        Storage::disk('local')->put('public/uploads/'.$fileName,  File::get($file));
        return $fileName;
    }

    public function fileDestroy(Request $request)
    {
        $filename =  $request->get('filename');
        $fileType =  $request->get('type');
        // first check for type
        if (in_array($fileType, $this->imagesAcceptedTypes)){ // if file is image delete from DB if exist
            Image::where('path', $filename)->delete();
        } else{ // if file not image, delete from DB if exist
            FileModel::where('path', $filename)->delete();
        }
        $exists = Storage::disk('local')->exists("public/uploads/$filename");
        if ($exists) {
            Storage::delete("public/uploads/$filename"); // delete from storage if exist
        }
        return $filename;
    }

    public function getById(Request $request){ // get data for dropzone init function
        $newsId = $request['id'];
        $images = Image::where('imageable_id', $newsId)->get('path');
        $files = FileModel::where('fileble_id', $newsId)->get('path');
        $files = array_merge($files->toArray(), $images->toArray());
        $result = [];
        foreach ($files as $file){
            $size = Storage::size("public/uploads/".$file['path']);
            $type = pathinfo(Storage::url("public/uploads/".$file['path']), PATHINFO_EXTENSION);
            array_push($result, ['name' => $file['path'], 'size' => $size, 'type' => $type]);
        }
        return response()->json($result);
    }

}
