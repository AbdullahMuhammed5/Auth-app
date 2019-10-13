@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Country</th>
            @canany(['city-edit', 'city-delete', 'city-list'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
@stop
