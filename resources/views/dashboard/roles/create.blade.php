@extends('layouts.dashboard')

@section('content')
    <h1>Create new Role</h1>
    <hr>
    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Name:</label>
                {!! Form::text('name', null, array('placeholder' => 'Role Name','class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Description:</label>
                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control', 'rows'=>3)) !!}
            </div>
        </div>
        <div class="col-sm-12  col-md-6">
            <div class="form-group">
                <label>Permission:</label>
                <div class="row">
                    @foreach($permissions as $key => $value)
                        <div class="i-checks col-sm-4">
                            {{ Form::checkbox('permissions[]', $key, false, array('id'=>$value )) }}
                            <label for="{{ $value }}" style="margin-left: 10px;">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
