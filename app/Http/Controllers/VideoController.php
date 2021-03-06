<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Library;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    use UploadFile;

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
     * @param LibraryRequest $request
     * @return Response
     */
    public function store(LibraryRequest $request)
    {
        $video = Library::create($request->all());

        if($request->hasFile('video')){
            $path = $this->upload($request['video']);
            $video->videos()->create(['path' => $path]);
        } else if($request['youtube_video']){
            $path = $this->getYoutubeID($request['youtube_video']);
            $video->videos()->create(['path' => $path]);
        }

        return redirect()->route('folders.show', $video->folder->id)
            ->with('success', 'Video created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $video = Library::whereId($id)->first();
        return view('dashboard.library.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LibraryRequest $request
     * @param $id
     * @return Response
     */
    public function update(LibraryRequest $request, $id)
    {
        $video = Library::whereId($id)->first();
        $video->update($request->all());

        if($request->hasFile('video')){
            $path = $this->upload($request['video']);
            dd($path);
            $video->videos()->update(['path' => $path]);
        } else if($request->video){
            $path = $this->getYoutubeID($request['video']);
            $video->videos()->update(['path' => $path]);
        }

        return redirect()->route('folders.show', $video->folder->id)
            ->with('success', 'Video created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return void
     */
    public function destroy($id)
    {
        $video = Library::whereId($id)->first();
        $video->delete();
        return redirect()->route('folders.show', $video->folder->id)
            ->with('success', 'Video deleted successfully');
    }

    public function getYoutubeID($url)
    {
        if(strlen($url) > 11)
        {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
            {
                return $match[1];
            }
            else
                return false;
        }
        return $url;
    }

}
