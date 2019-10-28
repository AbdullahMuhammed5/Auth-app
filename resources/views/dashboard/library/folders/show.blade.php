@extends('layouts.dashboard')

@section('content')

    <a href="{{ route('files.create', ['folder_id' => $folder->id]) }}" class="btn btn-success btn-sm"><i class="fa fa-file-o"></i> Add File</a>
    <a href="{{ route('images.create', ['folder_id' => $folder->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-photo"></i> Add Image</a>
    <a href="{{ route('videos.create', ['folder_id' => $folder->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-video-camera"></i> Add Video</a>

    <br>

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Icon</th>
            <th>File Name</th>
            <th>Description</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($files as $file)
            <tr class="gradeX">
                <td>{{ $file->id }}</td>
                @if($file->type == 'Image')
                <td><img src="{{Storage::url( $paths['imgPath'] )}}" style="width: 40px" alt=""></td>
                @elseif($file->type == 'File')
                <td><img src="{{asset('img/file.png')}}" alt="" style="width: 40px"></td>
                @elseif($file->type == 'Video')
                <td><img src="{{asset('img/video.jpg')}}" alt="" style="width: 40px"></td>
                @endif
                <td>{{ $file->name }}</td>
                <td>{{ $file->description }}</td>
                <td>
                    <a href="{{ route('file.edit', $city->id) }}" class="btn btn-primary">edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['cities.destroy', $city->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
