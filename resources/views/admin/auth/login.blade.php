@php
    runBackupCommand();
@endphp
<!doctype html>
<html lang="en">
<head>
    <title>{{$CompanyInfo->company_name}}</title>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{asset('uploads/favicon/cropped/'.$CompanyInfo->favicon)}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/login_new.css')}}">
</head>
<body>
<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="wrap">
                    <div class="img" style="background-image:url('{{asset('static/handshake.jpg')}}')"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Sign In</h3>
                            </div>
                            <img src="{{asset('uploads/logo/cropped/'.$CompanyInfo->logo)}}" alt="">
                        </div>
                        <form action="{{route('admin.loginsubmit')}}" method="post" id="login-form">
                            @csrf
                            @if(Session::has('success'))
                                <div class="form-group row">
                                    <span class="alert alert-success">{{Session::get('success')}}</span>
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <p class="alert alert-danger my-3 d-inline-block w-100">{{ Session::get('error') }}</p>
                            @endif
                            <div class="form-group mt-3">
                                <input type="text" name="email_or_phone" class="form-control @error('email_or_phone') is-invalid @enderror" value="{{old('email_or_phone')}}">
                                <label class="form-control-placeholder" for="username">Email Or Phone</label>
                                @error('email_or_phone')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control  @error('password') is-invalid @enderror">
                                <label class="form-control-placeholder" for="password">Password</label>
                                @error('password')
                                <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button id="login-button" type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                        <input  name="remember" type="checkbox" >
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- jqeury -->
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script>
    $('#login-form').submit(function(){
        $("#login-button").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
    });
</script>
</body>
</html>
