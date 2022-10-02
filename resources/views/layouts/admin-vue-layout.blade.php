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



    <!-- Font Awesome css -->
    <link href="{{ asset('assets/css/all.min.css?v='.config('custom_variable.asset_version')) }}" rel="stylesheet"/>
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css?v='.config('custom_variable.asset_version')) }}"
          rel="stylesheet"/>
    <!-- Sidebar css -->
    <link href="{{ asset('assets/css/sidebar.css?v='.config('custom_variable.asset_version')) }}?v={{time()}}"
          rel="stylesheet"/>
    <!-- Styles -->
    <link href="{{ asset('assets/css/style.css?v='.config('custom_variable.asset_version')) }}" rel="stylesheet"/>
    <!-- Poppins Font -->
    <link href="{{ asset('assets/css/poppins-font.css?v='.config('custom_variable.asset_version')) }}"
          rel="stylesheet"/>
    <!-- app css -->
    <link rel="stylesheet" href="{{asset('css/app.css?v='.config('custom_variable.asset_version'))}}">
</head>
<body>
@if(Auth::user()->status == 0)
    @php Session::flush() @endphp
@endif


<div class="wrapper" id="vue-app">
    @yield('modal')

    @include('component.common.sidebar')

    <div id="content" class="container-fluid">

        <nav class="navbar navbar-expand-md navbar-light bg-white mt-1">
            <button type="button" id="sidebarCollapse" class="navbar-btn">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
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
        </nav>

        <main class="py-2">
            @yield('content')
        </main>
    </div>


    <vue-progress-bar></vue-progress-bar>
</div>

<script src="{{asset('js/app.js?v='.config('custom_variable.asset_version'))}}"></script>
<!-- Bootstrap js -->
<script src="{{ asset('assets/js/bootstrap.min.js?v='.config('custom_variable.asset_version')) }}"></script>
<!-- Toastr js -->
<script src="{{asset('assets/js/main.js?v='.config('custom_variable.asset_version'))}}"></script>

@stack('js')
</body>
</html>
