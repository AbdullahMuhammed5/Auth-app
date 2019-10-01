<?php


namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Job;
use App\Staff;
use App\Country;
use App\Traits\HelperMethods;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    use SendsPasswordResetEmails, HelperMethods;

    public function __construct()
    {
        $this->authorizeResource(Staff::class);
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
        $columns = $this->getColumns('staff');
        if ($request->ajax()) {
            $data = Staff::latest()->with(['user', 'city', 'country', 'job', 'user.roles']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.staffs.ActionButtons')
                ->addColumn('image', 'dashboard.staffs.image')
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('dashboard.staffs.index', compact('columns'));
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
     * @throws Exception
     */
    public function store(StaffRequest $request)
    {
        $staffInputs = $request->except('first_name', 'last_name', 'phone', 'email');
        $usersInputs = $request->only('first_name', 'last_name', 'phone', 'email');
        $staffInputs['image'] = $request['image'] ?  $this->uploadImage($request['image']) : "default-user.png";
        $usersInputs['password'] = Hash::make('secret');

        $staff = Staff::create($staffInputs);
        $user = $staff->user()->create($usersInputs);
        $staff->update(['user_id' => $user->id]);
        $user->assignRole('staff');

        $this->broker()->sendResetLink(['email' => $user->email]);
        return redirect()->route('staffs.index')
            ->with('success', 'staff created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Staff $staff
     * @return Response
     */
    public function show(Staff $staff)
    {
        return view('dashboard.staffs.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Staff $staff
     * @return Response
     */
    public function edit(Staff $staff)
    {
        $countries = Country::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        return view('dashboard.staffs.edit', compact('countries', 'jobs', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StaffRequest $request
     * @param Staff $staff
     * @return Response
     * @throws Exception
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $usersInputs = $request->only('first_name', 'last_name', 'phone', 'email');
        $staffInputs = $request->except('first_name', 'last_name', 'phone', 'email');

        if ($image = $request['image']){
            $staffInputs['image'] = $this->uploadImage($image);
        }
        $staff->update($staffInputs);
        $staff->user()->update($usersInputs);

        return redirect()->route('staffs.index')
            ->with('success', 'staff updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Staff $staff
     * @return  Response
     * @throws Exception
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staffs.index')
            ->with('error', 'staff deleted successfully');
    }
}
