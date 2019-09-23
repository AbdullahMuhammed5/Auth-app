@extends('layouts.dashboard')

@section('content')

    <table class="table table-striped table-bordered table-hover" >
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
            @canany(['staff-edit', 'staff-delete'])
            <th>Options</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach($staffs as $staff)
            <tr>
                <td>{{$staff->user->id}}</td>
                <td>{{$staff->image}}</td>
                <td>{{ucfirst($staff->user->first_name).' '. $staff->user->last_name}}</td>
                <td>{{$staff->user->email}}</td>
                <td>{{$staff->user->phone}}</td>
                <td>{{$staff->job->name}}</td>
{{--                <td>{{$staff->roles->name}}</td>--}}
                <td>{{$staff->city}}</td>
{{--                <td>{{$staff->country->name}}</td>--}}
                <td>{{$staff->gender}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
