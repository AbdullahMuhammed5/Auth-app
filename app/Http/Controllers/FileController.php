<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\LibraryRequest;
use App\Library;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FileController extends Controller
{
    use UploadFile;
    public $type = 'File';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
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
        return view('dashboard.library.files.create', compact('folderId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LibraryRequest $request
     * @return void
     */
    public function store(LibraryRequest $request)
    {
        $file = Library::create(array_merge($request->all(), ['type' => $this->type]));

        if($request->hasFile('file')){
            $path = $this->upload($request['file']);
            $file->folder->files()->create(['path' => $path]);
        }

        return redirect()->route('folders.index')
            ->with('success', 'File created successfully');
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
