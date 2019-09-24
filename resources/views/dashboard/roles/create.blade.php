@extends('layouts.dashboard')

@section('content')
    <h1>Create new Role</h1>
    <hr>
    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Name:</label>
                {!! Form::text('name', null, array('placeholder' => 'Role Name','class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Description:</label>
                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Permission:</label>
                <div class="row">
                    @foreach($permissions as $key => $value)
                        <div class="checkbox col-sm-4">
                            {{ Form::checkbox('permissions[]', $key, false, array('class' => 'checkbox', 'id'=>$value )) }}
                            <label for="{{ $value }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
