@extends('layouts.dashboard')

@section('content')
    <h1>Edit {{$staff->user->first_name.' '.$staff->user->last_name}}</h1>
    <hr>
    {!! Form::model($staff, array('route' => ['staffs.update', $staff->id],'method'=>'PATCH', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>First Name:</label>
                {!! Form::text('first_name', $staff->user->first_name, array('placeholder' => 'First Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Last Name:</label>
                {!! Form::text('last_name', $staff->user->last_name, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email:</label>
                {!! Form::email('email', $staff->user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Phone:</label>
                {!! Form::text('phone', $staff->user->phone, array('placeholder' => 'Phone','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <label>Job:</label>
            <div class="form-group">
                {{ Form::select('job_id', [0 => 'Select Job', $jobs], $staff->job_id, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Country:</label>
                {{ Form::select('country_id', [0 => 'Select Country', $countries], $staff->country_id, array('class' => 'form-control', 'id' => 'country')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" id="city-wrapper">
                <label>City:</label>
                {{ Form::select('city_id', [$staff->city_id => $staff->city->name], $staff->city_id, array('class' => 'form-control', 'id' => 'city')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Gender:</label>
                {!! Form::select('gender', ['Male'=>'Male', 'Female'=>'Female'], $staff->gender, array('placeholder' => 'Select Gender','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>{!! Form::radio('is_active' , 0, null) !!} Inactive</label>
                <label>{!! Form::radio('is_active', 1, null) !!} Active</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Image:</label>
                {!! Form::file('image', null, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="text-center">
        {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection
