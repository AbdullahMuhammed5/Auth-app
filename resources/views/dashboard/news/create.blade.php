@extends('layouts.dashboard')

@section('content')
    <h1>Create Post</h1>
    <hr>
    {!! Form::open(array('route' => 'news.store','method'=>'POST', 'files' => true)) !!}
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label>Main Title:</label>
                {!! Form::text('main_title', null, array('placeholder' => 'Main Title','class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Secondary Title:</label>
                {!! Form::text('secondary_title', null, array('placeholder' => 'Secondary Title','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-sm-12  col-md-6">
            <div class="form-group">
                <label>Type:</label>
                {!! Form::select('type', [ 'Article' => 'Article', 'News' => 'News' ], null,
                array('placeholder' => 'Select Type','class' => 'form-control get-data-ajax-request', 'id'=>'news-type')) !!}
            </div>
            <div class="form-group" style="display: none" id="author-wrapper">
                <label>Author:</label>
                {!! Form::select('author_id', [] , null, array('placeholder' => 'Secondary Title','class' => 'form-control', 'id'=>'author')) !!}
            </div>
        </div>
        <div class="col-sm-12 ">
            <div class="form-group">
                <label>Content:</label>
                {!! Form::textarea('content',  null, array('placeholder' => 'Content goes here','class' => 'form-control', 'id'=>'editor')) !!}
            </div>
        </div>
        <div class="col-sm-12" style=" margin-bottom: 30px;">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>{!! Form::radio('published' , 0, true, ['class'=>'i-checks']) !!} Draft</label>
                    <label>{!! Form::radio('published', 1, false, ['class'=>'i-checks']) !!} Publish</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Related News:</label>
                    <select data-placeholder="Select related news ..." name="related[]" multiple class="chosen-select">
                        @foreach($relatedNews as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback" id="maxValueFeedback"
                          style="display: none">You just hit the maximum length of related news.</span>
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
