<?php


namespace App\Http\Controllers;

use App\City;
use App\Http\Controllers\FileUploadController;
use App\Http\Requests\StaffRequest;
use App\Job;
use App\Staff;
use App\Country;
use App\Traits\UploadFile;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    use SendsPasswordResetEmails, UploadFile;

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
        $columns = json_encode($this->getColumns());
        if ($request->ajax()) {
            $data = Staff::latest()->with(['user', 'city', 'country', 'job', 'user.roles', 'image']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'includes.ActionButtons')
                ->addColumn('is_active', function ($row){
                   return view('includes.toggleButton', compact('row'));
                })
                ->addColumn('image', 'dashboard.staffs.image')
                ->rawColumns(['action', 'image', 'is_active'])
                ->make(true);
        }
        return view('dashboard.staffs.index', compact('columns'));
    }

    public function getAuthorsByJob($job)
    {
        $job = $job == "News" ? "Reporter" : "Writer";
        $authors = Staff::with('user', 'job')->get()
            ->where('job.name', $job)
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
        $genders = Staff::$acceptedGender;
        return view('dashboard.staffs.create', compact('countries', 'jobs', 'genders'));
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
        $inputs = $request->all();

        // prepare image path to be stored in database as path
        // if has file image then upload - else assign to default image
        $imgPath = $request->hasFile('file') ?  $this->upload($request['file']) :  "default-user.png";

        $inputs['password'] = Hash::make('secret'); // set initial password

        $staff = Staff::create($inputs);
        $staff->image()->create(['path' => $imgPath]);

        $user = $staff->user()->create($inputs);
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
        $cities = City::where('country_id', $staff->country_id)->pluck('name', 'id');
        return view('dashboard.staffs.edit', compact('countries', 'jobs', 'staff', 'cities'));
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
        $inputs = $request->all();

        if ($image = $request['file']){
            $imgPath = $this->upload($image);
            $staff->image()->update(['path' => $imgPath]);
        }
        $staff->fill($inputs)->save();
        $staff->user->fill($inputs)->save();

        return redirect()->route('staffs.index')
            ->with('success', 'Staff updated successfully');
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
            ->with('error', 'Staff deleted successfully');
    }

    public function toggleActivity(Staff $staff){
        $staff->update(['is_active' => !$staff->is_active]);
        return response()->json("success");
    }

    public function getColumns()
    {
        return  [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'image', 'name' => 'image'],
            ['data' => 'user.first_name', 'name' => 'name'],
            ['data' => 'user.email', 'name' => 'email'],
            ['data' => 'user.phone', 'name' => 'phone'],
            ['data' => 'job.name', 'name' => 'job'],
            ['data' => 'user.roles[0].name', 'name' => 'roles'],
            ['data' => 'city.name', 'name' => 'city'],
            ['data' => 'country.name', 'name' => 'country'],
            ['data' => 'gender', 'name' => 'gender'],
            ['data' => 'is_active', 'name' => 'is_active'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }
}
