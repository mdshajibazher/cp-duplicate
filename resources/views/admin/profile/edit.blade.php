@extends('layouts.adminlayout')
@section('title','Admin Dashboard')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
            <a class="btn btn-info btn-sm" href="{{route('admin.profile')}}">back</a>
            </div>
            <div class="card-body">

            <form action="{{route('admin.updateprofile')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
<div class="form-group">
    <label for="name">Name<span>*</span></label>
<input type="text" id="name" placeholder="Enter Your Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name',Auth::user()->name)}}">

    @error('name')
    <small class="form-error">{{ $message }}</small>
    @enderror
</div>



<div class="form-group">
    <label for="email">Email<span>*</span></label>
    <input type="text" id="email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email',Auth::user()->email)}}">
    @error('email')
    <small class="form-error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="phone">Phone<span>*</span></label>
<input type="text" id="phone" placeholder="Enter Your phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone',Auth::user()->phone)}}">
    @error('phone')
    <small class="form-error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
  <label for="image">Image (optional)</label>
<input type="file" id="image" placeholder="Upload Your Profile Avatar" class="form-control @error('image') is-invalid @enderror" name="image">
  @error('image')
  <small class="form-error">{{ $message }}</small>
  @enderror


  <img class="mt-3 mb-3 img-thumbnail" src="{{asset('uploads/user/thumb/'.Auth::user()->image)}}" id="user_image" alt="">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">Update</button>
</div>

</form>
</div>
</div>
</div>
</div>
@endsection
