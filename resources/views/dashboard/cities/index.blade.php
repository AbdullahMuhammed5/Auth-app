@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
        <tr>
            <th>Name</th>
            <th>Country</th>
            @canany(['city-edit', 'city-delete'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
            <tr class="gradeX">
                <td>{{ $city->name }}</td>
                <td>{{ $city->country->name }}</td>
                @canany(['city-edit', 'city-delete'])
                    <td>
                        @can('city-edit')
                            <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-primary">edit</a>
                        @endcan
                        @can('city-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['cities.destroy', $city->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                @endcanany
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
