@extends('layouts.dashboard')

@section('content')
    <h1>Create news</h1>
    <hr>
    {!! Form::model($news, ['method' => 'PATCH','route' => ['news.update', $news->id]]) !!}
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
        <div class="col-sm-6">
            <div class="form-group">
                <label>{!! Form::radio('published' , 0, null, ['class'=>'i-checks']) !!} Draft</label>
                <label>{!! Form::radio('published', 1, null, ['class'=>'i-checks']) !!} Publish</label>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 text-center">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('ajax-get-authors')

    <script>
        $('#news-type').change(function(){
            let typeID = $(this).val() == 'News' ? 2 : 1;
            $.ajax({
                type:"get",
                url:" {{url('/getAuthorsByJob')}}/"+typeID,
                success:function(res){
                    if(res){
                        $('#author-wrapper').css('display', 'block')
                        $("#author").empty();
                        $("#author").append('<option value="">Select Author</option>');
                        $.each(res, function(key, value){
                            $("#author").append('<option value="'+key+'">'+value+'</option>');
                        });
                    }
                },
                error: (err)=>{
                    console.log(err)
                }
            });
        });

    </script>

@endpush
