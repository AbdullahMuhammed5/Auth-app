<?php


namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


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
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('dashboard.roles.index', compact('roles'));
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

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return  Response
     */
    public function destroy(int $id)
    {
        Role::findById($id)->delete();
        return redirect()->route('roles.index')
            ->with('error', 'Role deleted successfully');
    }
}
