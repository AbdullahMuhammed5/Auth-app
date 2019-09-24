<?php


namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\StaffRequest;
use App\Job;
use App\StaffMember;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
        $data = StaffMember::latest()->with('user', 'country', 'roles', 'job')->get();
//        dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    return view('dashboard.staffs.ActionButtons', compact('row'));
                })
                ->rawColumns(['action', 'permissions'])
                ->make(true);
        }
        return view('dashboard.staffs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        return view('dashboard.staffs.create', compact('countries', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StaffRequest $request
     * @return Response
     */
    public function store(StaffRequest $request)
    {
        $usersInputs = $request->only('first_name', 'last_name', 'phone');
        $usersInputs['email'] = $request->first_name.'.'.$request->last_name.'@'.'email.com';
        $usersInputs['password'] = Hash::make('secret');
        $user = User::create($usersInputs);

        $staffInputs = $request->only('job_id', 'country_id', 'city', 'image', 'gender');
        $staffInputs['user_id'] = $user->id;
        StaffMember::create($staffInputs);

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
        dd($staff);
        $countries = Country::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        return view('dashboard.staffs.edit', compact('countries', 'jobs', 'staff'));
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
