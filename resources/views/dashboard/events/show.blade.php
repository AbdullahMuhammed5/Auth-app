@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>Main Title</th>
            <th>Second Title</th>
            <th>location</th>
            <th>Content</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Visitors</th>
            @canany(['event-edit', 'event-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $event->main_title }}</td>
                <td>{{ $event->secondary_title }}</td>
                <td>{{ $event->location}}</td>
                <td>{{ $event->start_Date }}</td>
                <td>{{ $event->end_Date }}</td>
                <td>{{ $event->content }}</td>
                <td>
                    <ul>
                        @foreach ($event->invitedVisitors as $visitor )
                            <li class="badge badge-success">
                                <a href="{{url('/events', $visitor->event->id)}}" style="color: white">{{ $visitor->event->main_title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </td>
                @canany(['event-edit', 'event-delete'])
                    <td>
                        @can('event-edit')
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('event-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['events.destroy', $event->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        </tbody>
    </table>

@stop
