<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Auth App | Login</title>

    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ url('css/animate.css')  }}" rel="stylesheet">
    <link href="{{url('css/style.css')}}" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('') }}">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('register') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
            </li>
        </ul>
    </nav>

    <div class="container">

        @yield('content')

    </div>

    <p class="m-t text-center mt-4"> <small>Made by Abdullah Muhammed. All right preserved &copy; 2019</small> </p>
</body>

</html>
