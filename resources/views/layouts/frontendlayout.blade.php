
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="{{$companyInfo->company_name}} - {{$companyInfo->tagline}}" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url" content="{{$_SERVER['SERVER_NAME']}}" />
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$companyInfo->company_name}} - {{$companyInfo->tagline}}" />
    <meta property="og:description" content="{{$companyInfo->company_name}} -  {{Str::limit($companyInfo->short_description,200)}}" />
    <meta property="og:image" content="{{asset('uploads/favicon/cropped/'.$companyInfo->og_image)}}">


    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('uploads/favicon/cropped/'.$companyInfo->favicon)}}">


    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700|Roboto:300,400,500,700&display=swap" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/swiper.css')}}" type="text/css" />

    <!-- One Page Module Specific Stylesheet -->
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/one-page/onepage.css')}}" type="text/css" />
    <!-- / -->

    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/one-page/css/et-line.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/one-page/css/fonts.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('assets/frontend/corporate-design/css/custom.css')}}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>

    </style>
    <!-- Document Title
    ============================================= -->
    <title>@yield('title') - {{$companyInfo->company_name}}</title>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

        @yield('content')

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- JavaScripts
============================================= -->
<script src="{{asset('assets/frontend/corporate-design/js/jquery.js')}}"></script>
<script src="{{asset('assets/frontend/corporate-design/js/plugins.min.js')}}"></script>

<!-- Footer Scripts
============================================= -->
<script src="{{asset('assets/frontend/corporate-design/js/functions.js')}}"></script>

</body>
</html>

