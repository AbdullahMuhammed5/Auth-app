<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Library;
use App\LibraryFile;
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
//        dd($request->all());
        $file = Library::create($request->all());

        if($request->hasFile('file')){
            $path = $this->upload($request['file']);
            $file->file()->create(['path' => $path]);
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
        $file = LibraryFile::whereId($id)->first();
        return view('dashboard.library.files.edit', compact('file'));
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
        $file = LibraryFile::whereId($id)->first();
        $file->update($request->all());

        if($request->hasFile('file')){
            $path = $this->upload($request['file']);
            $file->file()->update(['path' => $path]);
        }

        return redirect()->route('folders.show', $file->folder->id)
            ->with('success', 'File created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $file = LibraryFile::whereId($id)->first();
        $file->delete();
        return redirect()->route('folders.show', $file->folder->id)
            ->with('success', 'File deleted successfully');
    }
}
