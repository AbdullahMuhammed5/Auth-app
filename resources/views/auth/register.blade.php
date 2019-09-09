@extends('layouts.app')

@section('content')

    <div class="card text-center w-50 my-0 mx-auto animated fadeInDown">
        <div class="card-header">
            <h3>Register</h3>
        </div>
        <div class="card-body">
            <div class="text-center">
            <form class="m-t" role="form" action="">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Phone" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Address" required="">
                </div>
                <div class="form-group">
                    <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="">Login</a>
            </form>
        </div>
    </div>


@stop
