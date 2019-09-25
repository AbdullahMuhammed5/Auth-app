@extends('layouts.dashboard')

@section('content')
    <h2>{{ ucfirst($staff->user->first_name).' '. ucfirst($staff->user->first_name)}}
        @if($staff->isActive)
            <span class="glyphicon glyphicon-ok-sign glyphicon" style="color: green"></span> <span>Active</span>
        @else
            <span class="glyphicon glyphicon-remove-sign glyphicon" style="color: darkred"></span> <span>Inactive</span>
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
            <th>job</th>
            <th>Role</th>
            <th>City</th>
            <th>Country</th>
            <th>Gender</th>
            @canany(['staff-edit', 'staff-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $staff->id }}</td>
                <td><img src="{{ Storage::url("images/$staff->image") }}" style='width: 50px'></td>
                <td>{{ ucfirst($staff->user->first_name).' '. ucfirst($staff->user->first_name)}}</td>
                <td>{{ $staff->user->email }}</td>
                <td>{{ $staff->user->phone }}</td>
                <td>{{ $staff->job->name }}</td>
                <td>{{ $staff->user->roles[0]->name }}</td>
                <td>{{ $staff->city->name }}</td>
                <td>{{ $staff->country->name }}</td>
                <td>{{ $staff->gender }}</td>
                @canany(['staff-edit', 'staff-delete'])
                    <td>
                        @can('staff-edit')
                            <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('staff-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['staffs.destroy', $staff->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        </tbody>
    </table>

@stop
