@extends('layouts.dashboard')

@section('content')
    <h1>{{ $city->name }}</h1>
    <hr>
    {!! Form::model($city, ['method' => 'PATCH','route' => ['cities.update', $city->id]]) !!}
    <div class="row">
        <div class="form-group col-md-4">
            <label for="city">Select City:</label>
            {!! Form::text('name', null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col-md-4">
            <label for="country">Select Country:</label>
                {!! Form::select('country_id', $countries, null, array('class' => 'form-control')) !!}
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}

@endsection
