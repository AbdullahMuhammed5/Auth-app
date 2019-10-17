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
{{--        <div class="col-sm-12  col-md-6">--}}
{{--            <div class="form-group">--}}
{{--                <label>Type:</label>--}}
{{--                {!! Form::select('type', $types, null,--}}
{{--                array('placeholder' => 'Select Type','class' => 'form-control get-data-ajax-request', 'id'=>'news-type')) !!}--}}
{{--            </div>--}}
{{--            <div class="form-group" style="display: none" id="author-wrapper">--}}
{{--                <label>Author:</label>--}}
{{--                {!! Form::select('location', [] , null, --}}
{{--                array('placeholder' => 'Secondary Title','class' => 'form-control', 'id'=>'author')) !!}--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-sm-12 ">
            <div class="form-group">
                <label>Content:</label>
                {!! Form::textarea('content',  null,
                array('placeholder' => 'Content goes here','class' => 'form-control', 'id'=>'editor')) !!}
            </div>
        </div>
        <div class="col-sm-12" style=" margin-bottom: 30px;">
{{--            <div class="col-sm-6">--}}
{{--                <div class="form-group">--}}
{{--                    <label>{!! Form::radio('published' , 0, true, ['class'=>'i-checks']) !!} Draft</label>--}}
{{--                    <label>{!! Form::radio('published', 1, false, ['class'=>'i-checks']) !!} Publish</label>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Invited users: </label>
                    <select data-placeholder="Select Invited Users ..." name="visitors[]" multiple class="chosen-select">

                    </select>
                    <span class="invalid-feedback" id="maxValueFeedback"
                          style="display: none">You just hit the maximum length of Invited users</span>
                </div>
            </div>

            <div class="col-sm-12">
                <label for="document">Documents</label>
                <div class="dropzone" id="dropzone">

                </div>
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
