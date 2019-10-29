@extends('layouts.dashboard')

@section('content')
    <h1>{{$file->name}}</h1>
    <hr>
    {!! Form::model($file, ['method' => 'PATCH','route' => ['files.update', $file->id], 'files' => true]) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <strong>File Name:</strong>
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Select File:</label>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">Select file</span>
                    <span class="fileinput-exists">Change</span>
                    {!! Form::file('file') !!}
                </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
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
