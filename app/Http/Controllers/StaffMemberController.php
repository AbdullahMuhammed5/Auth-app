<?php


namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\StaffMember;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class StaffMemberController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:staff-list|staff-create|staff-edit|staff-delete', ['only' => ['index','store']]);
        $this->middleware('permission:staff-create', ['only' => ['create','store']]);
        $this->middleware('permission:staff-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:staff-delete', ['only' => ['destroy']]);
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
        $staffs = StaffMember::latest()->with('user', 'country', 'roles', 'job')->get();
//        dd($staffs);
//        if ($request->ajax()) {
//            return Datatables::of($data)
//                ->addIndexColumn()
//                ->addColumn('permissions', function ($row){
//                    return view('dashboard.staffs.permissions', compact('row'));
//                })
//                ->addColumn('action', function ($row){
//                    return view('dashboard.staffs.ActionButtons', compact('row'));
//                })
//                ->rawColumns(['action', 'permissions'])
//                ->make(true);
//        }
        return view('dashboard.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $permission = Permission::all();
        return view('dashboard.staffs.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  staffRequest $request
     * @return Response
     */
    public function store(staffRequest $request)
    {
        $staff = staff::create(['name' => $request->name, 'description' => $request->description]);
        $staff->syncPermissions($request->input('permissions'));

        return redirect()->route('staffs.index')
            ->with('success', 'staff created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param StaffMember $staff
     * @return Response
     */
    public function show(StaffMember $staff)
    {
        return view('dashboard.staffs.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaffMember $staff
     * @return Response
     */
    public function edit(StaffMember $staff)
    {
        $permissions = Permission::all();
        $staffPermissions = $staff->permissions->pluck('id','id')->all();

        return view('dashboard.staffs.edit', compact('staff', 'permissions', 'staffPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param staffRequest $request staff $staff
     * @param StaffMember $staff
     * @return Response
     */
    public function update(staffRequest $request, StaffMember $staff)
    {
        $staff->name = $request->input('name');
        $staff->description = $request->input('description');
        $staff->save();

        $staff->syncPermissions($request->input('permissions'));

        return redirect()->route('staffs.index')
            ->with('success', 'staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param StaffMember $staff
     * @return  Response
     * @throws Exception
     */
    public function destroy(StaffMember $staff)
    {
        $staff->delete();
        return redirect()->route('staffs.index')
            ->with('error', 'staff deleted successfully');
    }
}
