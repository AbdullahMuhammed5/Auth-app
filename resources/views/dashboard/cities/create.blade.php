@extends('layouts.dashboard')

@section('content')
    <h1>Create New City</h1>
    <hr>
    {!! Form::open(array('route' => 'cities.store','method'=>'POST')) !!}
    <div class="row">
        <div class="form-group col-sm-4">
            <label for="city">Select City:</label>
            {!! Form::text('name', null, ['placeholder' => 'City Name','class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-4">
            <label for="country">Select Country:</label>
            {!! Form::select('country_id', [''=> 'Select Country', $countries], null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group col-sm-2">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary', 'style'=>'margin-top: 23px']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection
