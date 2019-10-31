@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover data-table" style="width: 100%;">
        <thead>
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Main Title</th>
            <th>Secondary Title</th>
            <th>Type</th>
            <th>content</th>
            <th>Published</th>
        @canany(['news-edit', 'news-delete', 'news-list'])
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
