@extends('layouts.dashboard')

@section('content')
    <h2>{{ ucfirst($visitor->user->first_name).' '. ucfirst($visitor->user->last_name)}}
        @if($visitor->is_active)
            <span class="fa fa-circle" style="color: green"></span> <span>Active</span>
        @else
            <span class="fa fa-circle" style="color: red"></span> <span>Inactive</span>
        @endif
    </h2>
    <br>
    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Country</th>
            <th>Gender</th>
            @canany(['visitor-edit', 'visitor-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $visitor->id }}</td>
                <td><img src="{{ Storage::url("images/".$visitor->image->path) }}" style='width: 50px'></td>
                <td>{{ ucfirst($visitor->user->first_name).' '. ucfirst($visitor->user->last_name)}}</td>
                <td>{{ $visitor->user->email }}</td>
                <td>{{ $visitor->user->phone }}</td>
                <td>{{ $visitor->city->name }}</td>
                <td>{{ $visitor->country->name }}</td>
                <td>{{ $visitor->gender }}</td>
                @canany(['visitor-edit', 'visitor-delete'])
                    <td>
                        @can('visitor-edit')
                            <a href="{{ route('visitors.edit', $visitor->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('visitor-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['visitors.destroy', $visitor->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        </tbody>
    </table>

@stop
