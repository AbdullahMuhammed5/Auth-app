<?php


namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Traits\HelperMethods;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    use HelperMethods;

    public function __construct()
    {
        $this->authorizeResource(Role::class);
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
        $columns = $this->getColumns('roles');
        if ($request->ajax()) {
            $data = Role::latest()->with('permissions');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', 'dashboard.roles.permissions')
                ->addColumn('action', 'dashboard.roles.ActionButtons')
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }
        return view('dashboard.roles.index', compact('columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = Permission::pluck('name', 'id')->all();
        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->only('name', 'description'));
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
     * @param Role $role
     * @return Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::pluck('name', 'id')->all();
        $rolePermissions = $role['permissions']->pluck('id','id')->all();

        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->only('name', 'description'));
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
