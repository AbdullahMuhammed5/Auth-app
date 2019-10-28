<?php

namespace App\Http\Controllers;

use App\Library;
use App\Traits\UploadFile;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    use UploadFile;

    public $type = 'Video';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $folderId = $request['folder_id'];
        return view('dashboard.library.videos.create', compact('folderId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $video = Library::create(array_merge($request->all(), ['type' => $this->type]));

        if($request->hasFile('video')){
            $path = $this->upload($request['video']);
            $video->folder->videos()->create(['path' => $path]);
        }

        return redirect()->route('folders.index')
            ->with('success', 'Video created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Video  $video
     * @return Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return Response
     */
    public function destroy(Video $video)
    {
        //
    }
}
