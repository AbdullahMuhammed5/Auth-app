@extends('layouts.dashboard')

@section('content')
    <h1>Create new job</h1>
    <hr>
    {!! Form::open(array('route' => 'jobs.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-sm-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'job Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-12 col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
