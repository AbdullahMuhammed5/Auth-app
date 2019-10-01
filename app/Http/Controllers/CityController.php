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
use App\Traits\HelperMethods;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    use HelperMethods;

    public function __construct()
    {
        $this->authorizeResource(City::class);
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
        $columns = $this->getColumns('cities');
        if ($request->ajax()) {
            $data = City::latest()->with('country');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'dashboard.cities.ActionButtons')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.cities.index', compact('columns'));
    }

    public function getCities($id)
    {
        $cities= City::where("country_id", $id)
            ->pluck("name", "id");
        return response()->json($cities);
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
     * @param CityRequest $request
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
     * @param City $city
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
     * @param CityRequest $request
     * @param City $city
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
