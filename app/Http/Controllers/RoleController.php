<?php


namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $data = Role::latest()->with('permissions')->get();
        dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', function ($row){
                    return view('dashboard.roles.permissions', compact('row'));
                })
                ->addColumn('action', function ($row){
                    return view('dashboard.roles.ActionButtons', compact('row'));
                })
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }
        return view('dashboard.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permission = Permission::all();
        return view('dashboard.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->name, 'description' => $request->description]);
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        return view('dashboard.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id','id')->all();

        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest $request Role $role
     * @return Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return  Response
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')
            ->with('error', 'Role deleted successfully');
    }
}
