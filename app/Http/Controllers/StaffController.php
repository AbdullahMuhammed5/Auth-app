<?php


namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Job;
use App\Staff;
use App\User;
use App\Country;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    use SendsPasswordResetEmails;

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
        $data = Staff::latest()->get();
//        dd($data);
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    return view('dashboard.staffs.ActionButtons', compact('row'));
                })
                ->addColumn('isActive', function ($row){
                    return $row->isActive == 0 ? 'InActive' : 'Active';
                })
                ->addColumn('image', function ($row){
                    $exists = Storage::disk('local')->exists("public/images/$row->image");
                    $url = $exists ? Storage::url("images/$row->image") : 'images/default-user.png';

                    return "<img src=".$url." style='width: 50px'>";
                })
                ->rawColumns(['action', 'image'])
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
        $usersInputs['email'] = $request['first_name'].'.'.$request['last_name'].'@'.'email.com';
        $usersInputs['password'] = Hash::make('secret');
        $user = User::create($usersInputs);

        $user->assignRole('staff');

        $staffInputs = $request->only('job_id', 'country_id', 'city_id', 'gender', 'isActive');
        $staffInputs['user_id'] = $user->id;
        if ($image = $request['image']){
            $imageName = time().$image->getClientOriginalName();
            Storage::disk('local')->put('public/images/'.$imageName,  File::get($image));
            $staffInputs['image'] = $imageName;
        }else{
            $staffInputs['image'] = "default-user.png";
        }
        Staff::create($staffInputs);
        $this->broker()->sendResetLink(['email' => $user->email]);
        return redirect()->route('staffs.index')
            ->with('success', 'staff created successfully');
    }

    /**
     * Display the specified resource.
     *
     * //     *
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
     * @param StaffRequest $request staff $staff
     * @param Staff $staff
     * @return Response
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $user = User::findOrFail($staff['user_id']);
        $usersInputs = $request->only('first_name', 'last_name', 'phone', 'email');
        $user->update($usersInputs);

        $staffInputs = $request->only('job_id', 'country_id', 'city_id', 'gender', 'isActive');
        if ($image = $request['image']){
            $imageName = time().$image->getClientOriginalName();
            Storage::disk('local')->put('public/images/'.$imageName,  File::get($image));
            $staffInputs['image'] = $imageName;
        }
        $staff->update($staffInputs);

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
        User::findOrFail($staff->user_id)->delete();
        $staff->delete();
        Storage::delete("images/$staff->image");
        return redirect()->route('staffs.index')
            ->with('error', 'staff deleted successfully');
    }
}
