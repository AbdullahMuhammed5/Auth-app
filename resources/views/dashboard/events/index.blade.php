@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" style="width: 100%;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Cover</th>
            <th>Main Title</th>
            <th>Secondary Title</th>
            <th>Location</th>
            <th>content</th>
            <th>Start Date</th>
            <th>End Date</th>
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

@push('datatable-css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endpush

@push('datatable')
    @include('includes/datatable')
@endpush
