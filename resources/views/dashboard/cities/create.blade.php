@extends('layouts.dashboard')

@section('content')
    <h1>Create New City</h1>
    <hr>
    {!! Form::open(array('route' => 'cities.store','method'=>'POST')) !!}
    <div class="row">
        <div class="form-group col-md-4">
            <label for="city">Select City:</label>
            <input type="text" name="name" id="city" class="form-control" placeholder="City Name">
        </div>

        <div class="form-group col-md-4">
            <label for="country">Select Country:</label>
            <select id="country" name="country_id" class="form-control" >
                <option value="" selected disabled>Select Country</option>
                @foreach($countries as $key => $country)
                    <option value="{{$key}}"> {{$country}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <button class="btn btn-primary" type="submit" style="margin-top: 23px">Add</button>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
