<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Favicon-->
     <link rel="shortcut icon" href="{{asset('uploads/favicon/cropped/'.$CompanyInfo->favicon)}}">

    <title>@yield('title') {{ config('app.name',$CompanyInfo->company_name  ) }}</title>

    @stack('css')
    <!-- Font Awesome css -->
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet">
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/icheck-bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <div class="container">
            <main class="py-2">
                @yield('content')
            </main>
        </div>

    </div>
        <!-- jqeury -->
        <script src="{{ asset('assets/js/jquery.js') }}" defer></script>
        <!-- Bootstrap js -->
       <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script>
       @stack('js')
</body>
</html>
