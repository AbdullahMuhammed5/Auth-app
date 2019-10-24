<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $columns = json_encode($this->getColumns());
//        dd($data);
        if ($request->ajax()) {
            $data = Folder::latest()->with('authorizedUsers.user')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', 'includes.ActionButtons')
                ->addColumn('authorized_users', 'dashboard.library.folders.authorizedUsers')
                ->rawColumns(['actions', 'authorized_users'])
                ->make(true);
        }
        return view('dashboard.library.folders.index', compact('columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard.library.folders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $folder = Folder::create($request->all());

        if ($users = $request['users']){
            $folder->authorizedUsers()->attach($users);
        }
        return redirect()->route('library.folders.index')
            ->with('success', 'Folder created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Folder $folder
     * @return void
     */
    public function show(Folder $folder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Folder  $folder
     * @return Response
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder  $folder
     * @return Response
     */
    public function destroy(Folder $folder)
    {
        //
    }

    public function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data'=> 'name', 'name'=> 'name'],
            ['data'=> 'authorized_users', 'name'=> 'authorized_users'],
            ['data'=> 'actions', 'name'=> 'actions', 'orderable'=> false, 'searchable'=> false],
        ];
    }

    // get staff based on search
    public function getAuthorized(Request $request){
        $term = trim($request['search']);

        if (empty($term)) {
            return \Response::json([]);
        }

        $result = Staff::active()->whereHas('user' , function ($q) use ($term){
            $q->where('first_name', 'like', "%$term%")
                ->orWhere('last_name', 'like', "%$term%")
                ->select(DB::raw("CONCAT(first_name,' ',last_name) as full_name"));
        })->get();
        $result = $result->pluck("user.full_name", "id");

        $response = [];

        foreach ($result as $id => $name) {
            $response[] = ['id' => $id, 'text' => $name];
        }

        return \Response::json($response);
    }
}
