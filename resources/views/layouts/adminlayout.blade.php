@if(Auth::user()->status == 0)
@php
    Auth::logout();
    Session::flush();
@endphp
@endif
@php
    runBackupCommand();
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
     <!-- Favicon-->
     <link rel="shortcut icon" href="{{asset('uploads/favicon/cropped/'.$CompanyInfo->favicon)}}">

    <title>@yield('title')</title>




    @stack('css')

     <!-- Select 2 min  Css -->
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" />
    <!-- Select 2 Bootstrap  Css -->
    <link href="{{asset('assets/css/select2-bootstrap.min.css')}}" rel="stylesheet" />
     <!-- Sweetalert 2 Css -->
     <link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" />
     <!-- iCheck Bootstrap -->
     <link  href="{{asset('assets/css/icheck-bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- Font Awesome css -->
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet"/>
     <!-- Sidebar css -->
     <link href="{{ asset('assets/css/sidebar.css') }}?v={{time()}}" rel="stylesheet"/>
     <!-- Tostr Css -->
    <link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('assets/css/style.css').'?v=1'}}" rel="stylesheet"/>
     <!-- Poppins Font -->
     <link href="{{ asset('assets/css/poppins-font.css') }}" rel="stylesheet"/>
</head>
<body>
    @yield('modal')
    <div class="wrapper" id="app">
    @include('component.common.sidebar')

        <div id="content" class="container">
            <div class="row">
            <div class="col-lg-12">
        <nav class="navbar navbar-expand-md navbar-light bg-white">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto main-menu">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __(' Login') }}</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.login') }}">Admin Login</a>
                        </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              My Account <i class="fa fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile')}}">My Profile</a>
                                    <a class="dropdown-item" href="{{ route('admin.changepassword')}}">Change Password</a>



                            </div>
                          </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.logout') }}">Logout</a>
                            </li>




                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    </div>
        <!-- jqeury -->
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
         <!-- Popper js -->
         <script src="{{ asset('assets/js/popper.js') }}"></script>
        <!-- Bootstrap js -->
       <script src="{{ asset('assets/js/bootstrap.min.js') }}" ></script>

         <!-- Sweetalert2  js -->
         <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
         <!-- Toastr js -->
        <script src="{{asset('assets/js/toastr.min.js')}}"></script>

        <script type="text/javascript">toastr.options = {"closeButton":true,"debug":false,"newestOnTop":true,"progressBar":true,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1500","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"};
        </script>
        {!! Toastr::message() !!}

         <!-- Collapse js -->
          <!-- Select 2 js -->
        <script src="{{asset('assets/js/select2.min.js')}}"></script>

         <!-- Toastr js -->
        <script src="{{asset('assets/js/main.js')}}"></script>

       @stack('js')
</body>
</html>
