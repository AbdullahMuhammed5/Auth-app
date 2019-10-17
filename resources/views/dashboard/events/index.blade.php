@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" >
        <thead>
        <tr>
            <th>ID</th>
            <th>Main Title</th>
            <th>Secondary Title</th>
            <th>Location</th>
            <th>content</th>
            <th>Published</th>
        @canany(['event-edit', 'event-delete', 'event-list'])
            <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@stop
