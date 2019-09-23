@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            @canany(['job-edit', 'job-delete'])
            <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop
