<?php


namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Job;
use App\Staff;
use App\User;
use App\Country;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Staff::class);

        if ($request->ajax()) {
            $data = Staff::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.staffs.ActionButtons')
                ->addColumn('is_active', function ($row){
                    return $row->is_active == 0 ? 'Inactive' : 'Active';
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
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Staff::class);
        $countries = Country::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        return view('dashboard.staffs.create', compact('countries', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StaffRequest $request
     * @return Response
     * @throws AuthorizationException
     * @throws Exception
     */
    public function store(StaffRequest $request)
    {
        $this->authorize('create', Staff::class);

        $usersInputs = $request->only('first_name', 'last_name', 'phone');
        $usersInputs['email'] = $request['first_name'].'.'.$request['last_name'].'@'.'email.com';
        $usersInputs['password'] = Hash::make('secret');
        $user = User::create($usersInputs);

        $user->assignRole('staff');

        $staffInputs = $request->only('job_id', 'country_id', 'city_id', 'gender', 'is_active');
        $staffInputs['user_id'] = $user->id;
        if ($image = $request['image']){
            $staffInputs['image'] = $this->uploadImage($image);
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
     * @param Staff $staff
     * @return Response
     * @throws AuthorizationException
     */
    public function show(Staff $staff)
    {
        $this->authorize('view', $staff);
        return view('dashboard.staffs.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Staff $staff
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Staff $staff)
    {
        $this->authorize('viewAny', $staff);
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
     * @throws AuthorizationException
     * @throws Exception
     */
    public function update(StaffRequest $request, Staff $staff)
    {
        $this->authorize('viewAny', $staff);
        $user = User::findOrFail($staff['user_id']);
        $usersInputs = $request->only('first_name', 'last_name', 'phone', 'email');
        $user->update($usersInputs);

        $staffInputs = $request->only('job_id', 'country_id', 'city_id', 'gender', 'is_active');
        if ($image = $request['image']){
            $staffInputs['image'] = $this->uploadImage($image);
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
        $this->authorize('viewAny', $staff);
        User::findOrFail($staff->user_id)->delete();
        $staff->delete();
        Storage::delete("images/$staff->image");
        return redirect()->route('staffs.index')
            ->with('error', 'staff deleted successfully');
    }

    /**
     * Custom Function to upload image
     *
     * @param File $image
     * @return  string
     * @throws Exception
     */
    public function uploadImage($image){
        $imageName = time().$image->getClientOriginalName();
        Storage::disk('local')->put('public/images/'.$imageName,  File::get($image));
        return $imageName;
    }
}
