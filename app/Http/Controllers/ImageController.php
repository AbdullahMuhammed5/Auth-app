<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Library;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    use UploadFile;

    public $type = 'Image';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
        return view('dashboard.library.images.create', compact('folderId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LibraryRequest $request
     * @return Response
     */
    public function store(LibraryRequest $request)
    {
        $image = Library::create(array_merge($request->all(), ['type' => $this->type]));

        if($request->hasFile('image')){
            $path = $this->upload($request['image']);
            $image->folder->images()->create(['path' => $path]);
        }

        return redirect()->route('folders.index')
            ->with('success', 'Image created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
