@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            @if($job->name != 'Writer' && $job->name != 'Reporter')
                @canany(['job-edit', 'job-delete'])
                    <th>Options</th>
                @endcanany
            @endif
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $job->id }}</td>
                <td>{{ $job->name }}</td>
                <td>{{ $job->description }}</td>

                @if($job->name != 'Writer' && $job->name != 'Reporter')
                @canany(['job-edit', 'job-delete'])
                    <td>
                        @can('job-edit')
                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('job-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['jobs.destroy', $job],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
                @endif
            </tr>
        </tbody>
    </table>

@stop
