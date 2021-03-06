<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\FolderRequest;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Folder::class);
    }
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
        $isAdmin = auth()->user()->hasRole('Admin');
        if ($request->ajax()) {
            $data = $isAdmin ? Folder::latest() : auth()->user()->staff->folders;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', 'dashboard.library.folders.image')
                ->addColumn('actions', 'includes.ActionButtons')
                ->rawColumns(['name', 'actions', 'authorized_users'])
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
     * @param FolderRequest $request
     * @return void
     */
    public function store(FolderRequest $request)
    {
        $folder = Folder::create($request->all());
        if ($users = $request['users']){
            $folder->authorizedUsers()->attach($users);
        }
        return redirect()->route('folders.index')
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
        $files = $folder->library()->get();
        return view('dashboard.library.folders.show', compact( 'folder', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Folder $folder
     * @return Response
     */
    public function edit(Folder $folder)
    {
        $authorizedUsers = $folder->authorizedUsers()
            ->with('user:id,first_name,last_name')->get()
            ->pluck('user.full_name', 'id');
        $selected = $folder->authorizedUsers->pluck('id')->all();
        return view('dashboard.library.folders.edit', compact('folder', 'authorizedUsers', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FolderRequest $request
     * @param Folder $folder
     * @return Response
     */
    public function update(FolderRequest $request, Folder $folder)
    {
        $folder->update($request->all());
        $folder->authorizedUsers()->sync($request['users']);
        return redirect()->route('folders.index')
            ->with('success', 'Folder updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Folder $folder
     * @return Response
     * @throws \Exception
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return redirect()->route('folders.index')
            ->with('error', 'Folder deleted successfully');
    }

    public function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data'=> 'name', 'name'=> 'name'],
            ['data'=> 'description', 'name'=> 'description'],
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
