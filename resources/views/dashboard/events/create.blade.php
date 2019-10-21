@extends('layouts.dashboard')

@section('content')
    <h1>Create Event</h1>
    <hr>
    {!! Form::open(array('route' => 'events.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Main Title:</label>
                {!! Form::text('main_title', null, array('placeholder' => 'Main Title','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Secondary Title:</label>
                {!! Form::text('secondary_title', null, array('placeholder' => 'Secondary Title','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-12 ">
            <div class="form-group">
                <label>Content:</label>
                {!! Form::textarea('content',  null,
                array('placeholder' => 'Content goes here','class' => 'form-control', 'id'=>'editor')) !!}
            </div>
        </div>
        <div class="col-sm-12" style=" margin-bottom: 30px;">
            <div class="col-sm-6">
                <div class="form-group" id="data_5">
                    <label class="font-normal">Range select</label>
                    <div class="input-daterange input-group" id="datepicker">
                        <div class='input-group date datetimepicker'>
                        {!! Form::text('start_date', null, array('class' => 'input-sm form-control')) !!}
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <span class="input-group-addon">to</span>
                        <div class='input-group date datetimepicker'>
                        {!! Form::text('end_date', null, array('class' => 'input-sm form-control')) !!}
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Invited users: </label>
                    <select data-placeholder="Select Invited Users ..." name="visitors[]" multiple class="chosen-select">

                    </select>
                    <span class="invalid-feedback" id="maxValueFeedback"
                          style="display: none">You just hit the maximum length of Invited users</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="address_address">Location</label>
                {!! Form::text('location', null, array('class' => 'map-input form-control', 'id'=>'address-input')) !!}
                {!! Form::hidden('address_latitude', null, array('class' => 'input-sm form-control', 'id' => "address-latitude")) !!}
                {!! Form::hidden('address_longitude', null, array('class' => 'input-sm form-control', 'id'=>'address-longitude')) !!}
            </div>
            <div id="address-map-container" style="width:100%;height:400px;margin-bottom: 40px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
        </div>
        <div class="col-sm-12">
            <label for="document">Documents</label>
            <div class="dropzone" id="dropzone">

            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('dropzone-config')

    @include('includes/dropzone-script')

@endpush
