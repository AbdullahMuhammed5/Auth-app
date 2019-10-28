@extends('layouts.dashboard')

@section('content')
    <h1>Create new File</h1>
    <hr>
    {!! Form::open(array('route' => 'images.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Image Name:</label>
                {!! Form::text('name', null, ['class' => "form-control", 'placeholder'=>'Name']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Select Image:</label>
                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                    <div class="form-control" data-trigger="fileinput">
                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <span class="input-group-addon btn btn-default btn-file">
                    <span class="fileinput-new">Select Image</span>
                    <span class="fileinput-exists">Change</span>
                    {!! Form::file('image') !!}
                </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Description:</label>
                {!! Form::textarea('description', null, ['class' => "form-control", 'placeholder'=>'Description', 'rows'=>3]) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('folder_id', $folderId, ['class' => "form-control"]) !!}
            </div>
        </div>
        <div class="col-sm-12 text-center">
            {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('JSValidatorScript')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LibraryImageRequest') !!}
@endpush
