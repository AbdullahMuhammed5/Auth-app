@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover dataTables-example" >
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
        @foreach($roles as $role)
        <tr class="gradeX">
            <td><a href="{{ route('roles.show', $role->id) }}">{{ $role->name }}</a></td>
            <td>{{ $role->description }}</td>
            <td style="width: 350px">
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
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure you want to delete this item?');"]) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
            @endcanany
        </tr>
        @endforeach
        </tbody>
    </table>

@stop
