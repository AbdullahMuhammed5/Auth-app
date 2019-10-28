@extends('layouts.dashboard')

@section('content')
    <h1>{{$folder->name}}</h1>
    <hr>
    {!! Form::model($folder, ['method' => 'PATCH','route' => ['folders.update', $folder->id]]) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Authorized Users:</label>
                {!! Form::select('users[]', $authorizedUsers, $selected, ["data-placeholder"=>"Select Authorized Users ...", 'multiple', "class"=>"chosen-select"]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Description:</label>
                {!! Form::textarea('description', null, ['class' => "form-control", 'placeholder'=>'Description']) !!}
            </div>
        </div>
        <div class="col-sm-12 text-center">
            {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection
