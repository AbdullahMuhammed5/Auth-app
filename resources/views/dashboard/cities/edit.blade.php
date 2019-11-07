@extends('layouts.dashboard')

@section('content')
    <h1>{{ $city->name }}</h1>
    <hr>
    {!! Form::model($city, ['method' => 'PATCH','route' => ['cities.update', $city->id]]) !!}
    <div class="row">
        <div class="form-group col-sm-4">
            <label for="city">Select City:</label>
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4">
            <label for="country">Select Country:</label>
            {!! Form::select('country_id', $countries, null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-sm-2">
            {!! Form::submit('Save Changes!', ['class' => 'btn btn-primary', 'style'=>'margin-top: 23px']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection
