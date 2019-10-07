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
            $data = Staff::latest()->with(['user', 'city', 'country', 'job', 'user.roles', 'image']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.staffs.ActionButtons')
                ->addColumn('is_active', function ($row){
                   return view('dashboard.staffs.toggleButton', compact('row'));
                })
                ->addColumn('image', 'dashboard.staffs.image')
                ->rawColumns(['action', 'image', 'is_active'])
                ->make(true);
        }
        return view('dashboard.staffs.index', compact('columns'));
    }

    public function getAuthorsByJob($id)
    {
        $authors = Staff::with('user')
            ->where('job_id', $id)->get()
            ->pluck('user.full_name', 'id');
        return $authors;
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
        $usersInputs = $request->only('first_name', 'last_name', 'phone', 'email');
        $staffInputs = $request->except('first_name', 'last_name', 'phone', 'email', 'image');
        $imgPath = $request['image'] ?  $this->uploadImage($request['image']) : "default-user.png";
        $usersInputs['password'] = Hash::make('secret');

        $staff = Staff::create($staffInputs);
        $staff->image()->create(['path' => $imgPath]);

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
        $staffInputs = $request->except('first_name', 'last_name', 'phone', 'email', 'image');

        if ($image = $request['image']){
            $imgPath = $this->uploadImage($image);
            $staff->image()->update(['path' => $imgPath]);
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

    public function toggleActivity(Staff $staff){
        $status = $staff->is_active ? 0 : 1;
        $staff->update(['is_active' => $status]);
        return "success";
    }
}
