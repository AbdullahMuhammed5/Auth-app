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
    protected $columns = [

        'roles' => [
            ['data' => 'id', 'name' => 'id'],
            ['data'=> 'name', 'name'=> 'name'],
            ['data'=> 'description', 'name'=> 'description'],
            ['data'=> 'permissions', 'name'=> 'permissions'],
            ['data'=> 'action', 'name'=> 'action', 'orderable'=> false, 'searchable'=> false],
        ],
        'cities' => [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'country.name', 'name' => 'country'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false],
        ],
        'jobs' => [
            ['data' => 'id', 'name' => 'id'],
            ['data'=> 'name', 'name'=> 'name'],
            ['data'=> 'description', 'name'=> 'description'],
            ['data'=> 'action', 'name'=> 'action', 'orderable'=> false, 'searchable'=> false],
        ],
        'staff' => [
            ['data' => 'user.id', 'name' => 'id'],
            ['data' => 'image', 'name' => 'image'],
            ['data' => 'user.first_name', 'name' => 'name'],
            ['data' => 'user.email', 'name' => 'email'],
            ['data' => 'user.phone', 'name' => 'phone'],
            ['data' => 'job.name', 'name' => 'job'],
            ['data' => 'user.roles[0].name', 'name' => 'roles'],
            ['data' => 'city.name', 'name' => 'city'],
            ['data' => 'country.name', 'name' => 'country'],
            ['data' => 'gender', 'name' => 'gender'],
            ['data' => 'is_active', 'name' => 'is_active'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ],
        'visitors' => [
            ['data' => 'user.id', 'name' => 'id'],
            ['data' => 'image', 'name' => 'image'],
            ['data' => 'user.first_name', 'name' => 'name'],
            ['data' => 'user.email', 'name' => 'email'],
            ['data' => 'user.phone', 'name' => 'phone'],
            ['data' => 'city.name', 'name' => 'city'],
            ['data' => 'country.name', 'name' => 'country'],
            ['data' => 'gender', 'name' => 'gender'],
            ['data' => 'is_active', 'name' => 'is_active'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ],
        'news' => [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'staff.user.first_name', 'name' => 'image'],
            ['data' => 'main_title', 'name' => 'main_title'],
            ['data' => 'secondary_title', 'name' => 'secondary_title'],
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'content', 'name' => 'content'],
            ['data' => 'published', 'name' => 'published'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ]
    ];

    public function getColumns($name){
        return json_encode($this->columns[$name]);
    }

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
