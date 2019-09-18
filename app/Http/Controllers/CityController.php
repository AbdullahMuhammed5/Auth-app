<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Http\Requests\CityRequest;
use Illuminate\Http\Response;

class CityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:city-list|city-create|city-edit|city-delete', ['only' => ['index','store']]);
        $this->middleware('permission:city-create', ['only' => ['create','store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::all();
        return view('dashboard.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countries = Country::pluck("name","id");
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
            ->with('success','City created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return void
     */
    public function show(City $city)
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
        $countries = Country::pluck("name","id");
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
            ->with('success','City Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Response
     */
    public function destroy($id)
    {
        City::findOrFail($id)->delete();
        return redirect()->route('cities.index')
            ->with('error','City Deleted successfully');
    }
}
