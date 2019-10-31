@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" style="width: 100%">
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
            <th>Status</th>
            @canany(['staff-edit', 'staff-delete', 'staff-list'])
            <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

@stop

@push('datatable')
    @include('includes/datatable')
@endpush
