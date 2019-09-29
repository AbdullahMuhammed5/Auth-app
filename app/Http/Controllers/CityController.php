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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', City::class);

        if ($request->ajax()) {
            $data = City::latest()->with('country');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    return view('dashboard.cities.ActionButtons', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.cities.index');
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
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', City::class);

        $countries = Country::pluck("name", "id");
        return view('dashboard.cities.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityRequest $request
     * @return Response
     * @throws AuthorizationException
     */
    public function store(CityRequest $request)
    {
        $this->authorize('create', City::class);
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
     * @throws AuthorizationException
     */
    public function edit(City $city)
    {
        $this->authorize('update', $city);
        $countries = Country::pluck("name", "id");
        return view('dashboard.cities.edit', compact('city', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest $request
     * @param City $city
     * @return Response
     * @throws AuthorizationException
     */
    public function update(CityRequest $request, City $city)
    {
        $this->authorize('update', $city);
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
        $this->authorize('delete', $city);
        $city->delete();
        return redirect()->route('cities.index')
            ->with('error', 'City Deleted successfully');
    }
}
