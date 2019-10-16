<?php


namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\VisitorRequest;
use App\Job;
use App\Visitor;
use App\Country;
use App\Traits\HelperMethods;
use Exception;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;


class VisitorController extends Controller
{
    use SendsPasswordResetEmails, HelperMethods;

    public function __construct()
    {
        $this->authorizeResource(Visitor::class);
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
            $data = Visitor::latest()->with(['user', 'city', 'country', 'user.roles', 'image']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'includes.ActionButtons')
                ->addColumn('is_active', function($row){
                    return view('includes.toggleButton', compact('row'));
                })
                ->addColumn('image', 'dashboard.visitors.image')
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('dashboard.visitors.index', compact('columns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');
        return view('dashboard.visitors.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VisitorRequest $request
     * @return Response
     * @throws Exception
     */
    public function store(VisitorRequest $request)
    {
        $inputs = $request->all();

        // prepare image path to be stored in database as path
        // if has file image then upload - else assign to default image
        $imgPath = $request->hasFile('file') ?
            app('App\Http\Controllers\FileUploadController')->fileStore(null, $request['file']) :
            "default-user.png";

        $inputs['password'] = Hash::make('secret'); // set initial password

        $visitor = Visitor::create($inputs);
        $visitor->image()->create(['path' => $imgPath]);

        $user = $visitor->user()->create($inputs);
        $visitor->update(['user_id' => $user->id]);

        $this->broker()->sendResetLink(['email' => $user->email]);
        return redirect()->route('visitors.index')
            ->with('success', 'visitor created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param visitor $visitor
     * @return Response
     */
    public function show(Visitor $visitor)
    {
        return view('dashboard.visitors.show', compact('visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param visitor $visitor
     * @return Response
     */
    public function edit(Visitor $visitor)
    {
        $countries = Country::pluck('name', 'id');
        $jobs = Job::pluck('name', 'id');
        $cities = City::where('country_id', $visitor->country_id)->pluck('name', 'id');
        return view('dashboard.visitors.edit', compact('countries', 'jobs', 'visitor', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param visitorRequest $request
     * @param visitor $visitor
     * @return Response
     * @throws Exception
     */
    public function update(VisitorRequest $request, Visitor $visitor)
    {
        $inputs = $request->all();

        if ($image = $request['file']){
            $imgPath = app('App\Http\Controllers\FileUploadController')->fileStore(null, $image);
            $visitor->image()->update(['path' => $imgPath]);
        }
        $visitor->fill($inputs)->save();
        $visitor->user->fill($inputs)->save();

        return redirect()->route('visitors.index')
            ->with('success', 'visitor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param visitor $visitor
     * @return  Response
     * @throws Exception
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')
            ->with('error', 'visitor deleted successfully');
    }

    public function toggleActivity(Visitor $visitor){
        $visitor->update(['is_active' => !$visitor->is_active ]);
        return response()->json("success");
    }

    public function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id'],
            ['data' => 'image', 'name' => 'image'],
            ['data' => 'user.first_name', 'name' => 'name'],
            ['data' => 'user.email', 'name' => 'email'],
            ['data' => 'user.phone', 'name' => 'phone'],
            ['data' => 'city.name', 'name' => 'city'],
            ['data' => 'country.name', 'name' => 'country'],
            ['data' => 'gender', 'name' => 'gender'],
            ['data' => 'is_active', 'name' => 'is_active'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }
}
