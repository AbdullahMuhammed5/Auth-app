@extends('layouts.dashboard')

@section('content')
    <h1>Update {{ $news->main_title }}</h1>
    <hr>
    {!! Form::model($news, ['method' => 'PATCH','route' => ['news.update', $news->id], 'files' => true, 'id' => 'edit-news-form']) !!}
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
            <div class="form-group" id="author-wrapper">
                <label>Author:</label>
                {!! Form::select('author_id', $authors , $news->staff->id, array('class' => 'form-control', 'id'=>'author')) !!}
            </div>
        </div>a
        <div class="col-sm-12 ">
            <div class="form-group">
                <label>Content:</label>
                {!! Form::textarea('content',  null, array('placeholder' => 'Content goes here','class' => 'form-control', 'id'=>'editor')) !!}
            </div>
        </div>
        <div class="col-sm-12">
            <div class="col-sm-2">
                <div class="form-group">
                    <label>{!! Form::radio('published' , 0, null, ['class'=>'i-checks']) !!} Draft</label>
                    <label>{!! Form::radio('published', 1, null, ['class'=>'i-checks']) !!} Publish</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Related News:</label>

                    {!! Form::select('related[]', $allNews, null, ["data-placeholder"=>"Select related Users ...",
                    'multiple', "class"=>"chosen-select", 'id' => 'get-related']) !!}

                    <span class="invalid-feedback" id="maxValueFeedback"
                          style="display: @if(count($allNews) > 10) block @else none @endif">
                        You just hit the maximum length of related news.</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <label for="document">Documents</label>
            <div class="dropzone" id="dropzone">

            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('dropzone-config')
    @include('includes/dropzone-script')
@endpush

@push('ckeditor')
    <!-- ckeditor -->
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endpush

@push('icheck-css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endpush
