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
                @if(count($file->images) && $rowRoute = 'images')
                <td style="text-align: center"><img src="{{Storage::url( $file->images[0]['path'] )}}" style="width: 40px" alt=""></td>
                @elseif(count($file->files) && $rowRoute = 'files')
                    <td style="text-align: center"><img src="{{asset('img/file.png')}}" alt="" style="width: 40px"></td>
                @elseif(count($file->videos) && $rowRoute = 'videos')
                    <td style="text-align: center"><img src="{{asset('img/video.jpg')}}" alt="" style="width: 40px"></td>
                @endif
                <td>{{ $file->name }}</td>
                <td>{{ $file->description }}</td>
                <td>
                    <a href="{{ route($rowRoute.'.edit', $file->id) }}" class="btn btn-primary">edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => [$rowRoute.'.destroy', $file->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
