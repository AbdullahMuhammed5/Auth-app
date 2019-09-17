@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover" >
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Permissions</th>
            @canany(['role-edit', 'role-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            <tr class="gradeX">
                <td>{{ $role->name }}</td>
                <td>{{ $role->description }}</td>
                <td>
                    <ul>
                        @foreach ($role->permissions as $permission )
                            <li class="badge badge-success">{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </td>
                @canany(['role-edit', 'role-delete'])
                    <td>
                        @can('role-edit')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        </tbody>
    </table>

@stop
