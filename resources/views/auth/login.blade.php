@extends('layouts.app')

@section('content')
<div class="card text-center w-50 my-0 mx-auto animated fadeInDown">
    <div class="card-header">
        <h3>Login</h3>
    </div>
    <div class="card-body">
        <div class="text-center">
            <form class="m-t" role="form" action="">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <div class="card-footer text-muted">
        <a href="#"><small>Forgot password?</small></a>
        <p class="text-muted text-center"><small>Do not have an account?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="#">Create an account</a>
    </div>
</div>
@stop
