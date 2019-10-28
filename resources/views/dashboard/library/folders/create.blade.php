@extends('layouts.dashboard')

@section('content')
    <h1>Create new File</h1>
    <hr>
    {!! Form::open(array('route' => 'folders.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">

        <div class="col-sm-6">
            <div class="form-group">
                <label>Folder Name:</label>
                {!! Form::text('name', null, ['class' => "form-control", 'placeholder'=>'Name']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Authorized Users:</label>
                {!! Form::select('users[]', [], null, ["data-placeholder"=>"Select Authorized Users ...", 'multiple', "class"=>"chosen-select"]) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Description:</label>
                {!! Form::textarea('description', null, ['class' => "form-control", 'placeholder'=>'Description','rows'=>3]) !!}
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
