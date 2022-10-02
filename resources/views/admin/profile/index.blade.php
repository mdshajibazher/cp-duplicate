@extends('layouts.adminlayout')
@section('title','Admin Dashboard')

@section('content')


<div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
        <table class="table table-striped table-borderless">
          <thead>
            <tr>
              <th>Photo</th>
            <td><img  width="100px" src="{{asset('uploads/user/thumb/'.Auth::user()->image)}}" alt=""></td>
            </tr>
            <tr>
              <th>Name : </th>
               <td>{{Auth::user()->name}}</td>
            </tr>
            <tr>
              <th>Email : </th>
              <td>{{Auth::user()->email}}</td>
            </tr>

            <tr>
              <th>Phone : </th>
              <td>{{Auth::user()->phone}}</td>
            </tr>
            <tr>
              <th>Role</th>
              <td>@foreach (Auth::user()->roles as $item)
                  <span class="badge badge-danger">{{$item->name}}</span>
              @endforeach</td>
            </tr>

            <tr>
            <th>Action</th>
            <th><a href="{{route('admin.editprofile')}}">Edit Profile</a></th>
            </tr>

          </thead>
          <tbody>


          </tbody>
        </table>
        @if(Auth::user()->hasAnyRole(Spatie\Permission\Models\Role::all()))
          <p>Permission Inherited Via Roles</p>
          @if(count(Auth::user()->getPermissionsViaRoles()) > 0)
          <table class="table">
            @foreach (Auth::user()->getPermissionsViaRoles() as $key =>  $item)
            <tr>
              <td>{{$key+1}}</td>
              <th>{{$item->name}}</th>
            </tr>
            @endforeach
            @else
            <p class="alert alert-danger">No Roles Permission Found</p>
            @endif
        </table>
        @endif

        <p>Direct Permission</p>
        <table class="table">
          @if(count(Auth::user()->getDirectPermissions()) > 0)
          @foreach (Auth::user()->getDirectPermissions() as $key =>  $item)
          <tr>
            <td>{{$key+1}}</td>
            <th>{{$item->name}}</th>
          </tr>
          @endforeach
          @else
          <p class="alert alert-danger">No Direct Permission Found</p>
          @endif


      </table>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection
