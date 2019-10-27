<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>INSPINIA | Dashboard </title>

    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
{{--    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/toggleButton.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet">

</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{asset('img/profile_small.jpg')}}" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        {{ ucfirst(auth()->user()->first_name) . ' ' . ucfirst(auth()->user()->last_name)}}
                                    </strong>
                             </span>
                                <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="{{ asset('profile.html') }}">Profile</a></li>
                            <li><a href="{{ asset('contacts.html') }}">Contacts</a></li>
                            <li><a href="{{ asset('mailbox.html') }}">Mailbox</a></li>
                            <li class="divider"></li>
                            <li><a class="fa fa-sign-out dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                @can('role-list')
                <li class="{{ Request::is('roles', 'roles/*') ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Roles</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('roles.index') }}">All</a></li>
                        @can('role-create')
                        <li><a href="{{ route('roles.create') }}">Add Role</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('city-list')
                <li class="{{ Request::is('cities', 'cities/*') ? 'active' : '' }}">
                    <a href="{{ route('cities.index') }}"><i class="fa fa-building"></i> <span class="nav-label">Cities</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('cities.index') }}">All</a></li>
                        @can('city-create')
                            <li><a href="{{ route('cities.create') }}">Add City</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('job-list')
                <li class="{{ Request::is('jobs', 'jobs/*') ? 'active' : '' }}">
                    <a href="{{ route('jobs.index') }}"><i class="fa fa-briefcase"></i> <span class="nav-label">Jobs</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('jobs.index') }}">All</a></li>
                        @can('job-create')
                            <li><a href="{{ route('jobs.create') }}">Add Job</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('staff-list')
                <li class="{{ Request::is('staffs', 'staffs/*') ? 'active' : '' }}">
                    <a href="{{ route('staffs.index') }}"><i class="fa fa-users"></i><span class="nav-label">Staff</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('staffs.index') }}">All</a></li>
                        @can('job-create')
                            <li><a href="{{ route('staffs.create') }}">Add Staff</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('visitor-list')
                <li class="{{ Request::is('visitors', 'visitors/*') ? 'active' : '' }}">
                    <a href="{{ route('visitors.index') }}"><i class="fa fa-users"></i><span class="nav-label">Visitors</span>
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('visitors.index') }}">All</a></li>
                        @can('visitor-create')
                            <li><a href="{{ route('visitors.create') }}">Add Visitor</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('news-list')
                    <li class="{{ Request::is('news', 'news/*') ? 'active' : '' }}">
                        <a href="{{ route('news.index') }}"><i class="fa fa-code"></i><span class="nav-label">News</span>
                            <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('news.index') }}">All</a></li>
                            @can('news-create')
                                <li><a href="{{ route('news.create') }}">Add news</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('event-list')
                    <li class="{{ Request::is('events', 'events/*') ? 'active' : '' }}">
                        <a href="{{ route('events.index') }}"><i class="fa fa-calendar"></i><span class="nav-label">Events</span>
                            <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('events.index') }}">All</a></li>
                            @can('event-create')
                                <li><a href="{{ route('events.create') }}">Add Event</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('folder-list')
                    <li class="{{ Request::is('folders', 'folders/*') ? 'active' : '' }}">
                        <a href="{{ route('folders.index') }}"><i class="fa fa-files-o"></i><span class="nav-label">Library</span>
                            <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{ route('folders.index') }}">All</a></li>
                            @can('folder-create')
                                <li><a href="{{ route('folders.create') }}">Add Folder</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{ asset('img/a7.jpg') }}">
                                    </a>
                                    <div>
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{ asset('img/a4.jpg') }}">
                                    </a>
                                    <div>
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{ asset('img/profile.jpg') }}">
                                    </a>
                                    <div>
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li><a class="fa fa-sign-out dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li>
                        <a class="right-sidebar-toggle">
                            <i class="fa fa-tasks"></i>
                        </a>
                    </li>
                </ul>

            </nav>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Data Tables</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ url('/dashboard') }}">Home</a>
                    </li>
                    <?php
                        use Illuminate\Support\Facades\DB;
                        $segments = '';
                        ?>
                    @if (!Request::is('staffs/*') && !Request::is('visitors/*')
                        && !Request::is('news/*') && !Request::is('events/*')
                        && !Request::is('folders/*') && !Request::is('library'))
                        @foreach(Request::segments() as $segment)
                            <?php $segments .= '/'.$segment;?>
                            <li>
                                @if(is_numeric($segment))
                                    <?php $name = DB::table(Request::segments()[0])->select('name')->whereId($segment)->first()->name?>
                                    <a href="{{ $segments }}" class="active">{{ucfirst($name)}}</a>
                                @else
                                    <a href="{{ $segments }}" class="active">{{ucfirst($segment)}}</a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            @yield('content')
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2017
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->

<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('js/inspinia.js')}}"></script>
<script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>

<!-- jQuery UI -->
<script src="{{asset('js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Jvectormap -->
<script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

<script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

<!-- ckeditor -->
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<!-- Data picker -->
{{--<script src="{{asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>--}}

<!-- Date range use moment.js same as full calendar plugin -->
<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

<!-- Date range picker -->
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- DROPZONE -->
<script src="{{ asset('js/plugins/dropzone/dropzone.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>--}}



<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script src="{{ asset('js/mapInput.js') }}"></script>

<!-- Custom Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Page-Level Scripts -->
<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(function () {
        if($('.data-table').length > 0  ) {
            let table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                @if(Request::segments()[0] != "dashboard")
                ajax: "{{ route(Request::segments()[0].'.index') }}",
                @endif
                columns: JSON.parse(@json($columns ?? "default")),
                dom: 'lfrtipB',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                responsive: true
            });
        }
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
        });
    });

</script>
@stack('dropzone-config')
@stack('JSValidatorScript')
</body>
</html>
