@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>Author</th>
            <th>Main Title</th>
            <th>Second Title</th>
            <th>Type</th>
            <th>Content</th>
            <th>Related News</th>
            @canany(['news-edit', 'news-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $news->staff->user->full_name }}</td>
                <td>{{ $news->main_title }}</td>
                <td>{{ $news->secondary_title }}</td>
                <td>{{ $news->type }}</td>
                <td>{{ $news->content }}</td>
                <td>
                    <ul>
                        @foreach ($news->related as $related )
                            <li class="badge badge-success">{{ $related->news->main_title }}</li>
                        @endforeach
                    </ul>
                </td>
                @canany(['news-edit', 'news-delete'])
                    <td>
                        @can('news-edit')
                            <a href="{{ route('news.edit', $news->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('news-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['news.destroy', $news->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        </tbody>
    </table>

@stop
