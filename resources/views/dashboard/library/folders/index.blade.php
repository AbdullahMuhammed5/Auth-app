@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" style="width: 100%;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Folder Name</th>
            <th>Description</th>
            <th>Users</th>
            @canany(['folder-edit', 'folder-delete', 'folder-list'])
                <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@stop
