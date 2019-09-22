<?php
/**
 * CityController Class Doc Comment
 * PHP version 7.3
 * @category Class
 * @author   Abdullah Muhammed
 * @link    https://github.com/AbdullahMuhammed5/Auth-app
 *
 */
namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\CityRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    function __construct()
    {
        $this->middleware(
'permission:city-list|city-create|city-edit|city-delete',
            ['only' => ['index','store']]
        );
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
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
        if ($request->ajax()) {
            $data = DB::table('cities')
                ->join('countries', 'cities.country_id', '=', 'countries.id')
                ->select('cities.id', 'cities.name', 'countries.name as country')
                ->where('deleted_at', NULL)
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('dashboard.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::pluck("name", "id");
        return view('dashboard.cities.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CityRequest $request
     * @return Response
     */
    public function store(CityRequest $request)
    {
        City::create($request->all());
        return redirect()->route('cities.index')
            ->with('success', 'City created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function show()
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  City $city
     * @return Response
     */
    public function edit(City $city)
    {
        $countries = Country::pluck("name", "id");
        return view('dashboard.cities.edit', compact('city', 'countries'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  CityRequest $request City $city
     * @return Response
     */
    public function update(CityRequest $request, City $city)
    {
        $city->update($request->all());

        return redirect()->route('cities.index')
            ->with('success', 'City Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param City $city
     * @return Response
     * @throws Exception
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')
            ->with('error', 'City Deleted successfully');
    }
}
