@extends('layouts.dashboard')

@section('content')
    <h1>Edit {{$visitor->user->full_name}}</h1>
    <hr>
    {!! Form::model($visitor, array('route' => ['visitors.update', $visitor->id],'method'=>'PATCH', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>First Name:</label>
                {!! Form::text('first_name', $visitor->user->first_name, array('placeholder' => 'First Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Last Name:</label>
                {!! Form::text('last_name', $visitor->user->last_name, array('placeholder' => 'Last Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email:</label>
                {!! Form::email('email', $visitor->user->email, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Phone:</label>
                {!! Form::text('phone', $visitor->user->phone, array('placeholder' => 'Phone','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Country:</label>
                {{ Form::select('country_id', $countries, $visitor->country_id,
                array('class' => 'form-control get-data-ajax-request', 'id' => 'country', 'placeholder' => 'Select Country')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" id="city-wrapper">
                <label>City:</label>
                {{ Form::select('city_id', $cities, null,
                array('class' => 'form-control', 'id' => 'city')) }}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Gender:</label>
                {!! Form::select('gender', ['Male'=>'Male', 'Female'=>'Female'], $visitor->gender,
                array('placeholder' => 'Select Gender','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>{!! Form::radio('is_active' , 0, null, ['class'=>'i-checks']) !!} Inactive</label>
                <label>{!! Form::radio('is_active', 1, null, ['class'=>'i-checks']) !!} Active</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Image:</label>
                {!! Form::file('file', null, array('class' => 'form-control')) !!}
            </div>
        </div>
    </div>
    <div class="text-center">
        {!! Form::submit('Save Changes!', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@push('icheck-css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endpush
