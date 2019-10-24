@extends('layouts.dashboard')

@section('content')
    <h1>Create new File</h1>
    <hr>
    {!! Form::open(array('route' => 'folders.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
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
                        {!! Form::file('name', null) !!}
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Authorized Users:</label>
                <select data-placeholder="Select Authorized Users ..." name="users[]" multiple class="chosen-select">

                </select>
            </div>
        </div>
        <div class="col-sm-12 text-center">
            {!! Form::submit('Submit!', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('code-mirror')
    <script href="{{ asset('js/plugins/codemirror/codemirror.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('js/plugins/codemirror/mode/xml/xml.js') }}"></script>
@endpush
