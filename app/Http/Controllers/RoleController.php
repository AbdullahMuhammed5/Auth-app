<?php


namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
//        $asd = [
//            (object)['data' => 'id', 'name' => 'id'],
//            (object)['data'=> 'name', 'name'=> 'name'],
//            (object)['data'=> 'description', 'name'=> 'description'],
//            (object)['data'=> 'permissions', 'name'=> 'permissions'],
//            (object)['data'=> 'action', 'name'=> 'action', 'orderable'=> false, 'searchable'=> false],
//        ];
//        dd(json_encode($asd));
        $this->authorize('viewAny', Role::class);
        $data = Role::latest()->with('permissions')->get();
//        $data[3] = json_encode($asd);
//        dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', function ($row){
                    return view('dashboard.roles.permissions', compact('row'));
                })
                ->addColumn('action', 'dashboard.roles.ActionButtons')
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }
        return view('dashboard.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $permissions = Permission::pluck('name', 'id')->all();
        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);
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
     * @throws AuthorizationException
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);
        return view('dashboard.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

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
     * @throws AuthorizationException
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

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
        $this->authorize('delete', $role);

        $role->delete();
        return redirect()->route('roles.index')
            ->with('error', 'Role deleted successfully');
    }
}
