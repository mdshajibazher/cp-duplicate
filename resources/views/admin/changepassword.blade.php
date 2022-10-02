@extends('layouts.adminlayout')
@section('title','Admin Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <h4 class="mb-3">Change Password</h4>

        <form action="{{route('admin.passupdate')}}" method="POST" id="password-change-form">
        @csrf
        @method('PUT')
        @if (Session::has('success'))
        <span class="help-block" style="color: green">
            <strong>{{ Session::get('success') }}</strong>
        </span>
    @endif

            @if(Auth::user()->password_changed == true)
        <div class="form-group">
            <label for="old_password">Old Password</label>
        <input id="old_password" type="password" placeholder="Enter Old Password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" value="{{old('old_password')}}">

        @error('old_password') <small class="form-error"> {{$message}} </small> @enderror

            @if (Session::has('old_password'))
            <span class="help-block" style="color: red">
                <small>{{ Session::get('old_password') }}</small>
            </span>
        @endif
        </div>
            @else
                <p class="alert alert-danger"><b>Attaintion: you must change your password before continue</b></p>
            @endif
        <div class="form-group">
            <label for="password">New Password</label>
            <input id="password" placeholder="Enter New Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}" >


            @error('password') <small class="form-error"> {{$message}} </small> @enderror

            @if (Session::has('password'))
            <span class="help-block" style="color: red">
                <small>{{ Session::get('password') }}</small>
            </span>
        @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input placeholder="Retype Password" id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{old('password_confirmation')}}">

            @error('password_confirmation') <small class="form-error"> {{$message}} </small> @enderror
        </div>
        <button type="submit" class="btn btn-primary" id="submit-button">Update</button>
      </form>
    </div>
  </div>
    </div>
        </div>
</div>

  </div>
@endsection
@push('js')
    <script>
        $('#password-change-form').submit(function(){
            $("#submit-button").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
        });
    </script>
@endpush
