@extends('layouts.dashboard')

@section('content')
    <h1>Update {{ $news->main_title }}</h1>
    <hr>
    {!! Form::model($news, ['method' => 'PATCH','route' => ['news.update', $news->id], 'files' => true]) !!}
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
                {!! Form::select('type', [ 'Article' => 'Article', 'News' => 'News' ], null, array('placeholder' => 'Select Type','class' => 'form-control', 'id'=>'news-type')) !!}
            </div>
            <div class="form-group" id="author-wrapper">
                <label>Author:</label>
                {!! Form::select('author_id', $authors , $news->staff->id, array('class' => 'form-control', 'id'=>'author')) !!}
            </div>
        </div>
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
            <div class="col-sm-4" style="display: flex; flex-direction: column; align-items: flex-end;">
                <div>Choose Images: {!! Form::file('images[]', ['multiple']) !!}</div>
                <div>Choose files: {!! Form::file('files[]', ['multiple']) !!}</div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Related News:</label>
                    <select data-placeholder="Select related news ..." name="related[]" multiple class="chosen-select">
                        @foreach($allNews as $key => $value)
                            @if(in_array($key, $relatedNews))
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}" >{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="invalid-feedback" id="maxValueFeedback"
                          style="display: @if(count($relatedNews) > 10) block @else none @endif">
                        You just hit the maximum length of related news.</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

