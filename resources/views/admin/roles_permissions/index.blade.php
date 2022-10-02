@extends('layouts.adminlayout')
@section('title','Roles')

@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h5 class="card-title text-left">Admin Role Module</h5>
                  </div>
                    <div class="col-lg-6">
                      <a href="{{route('roles.create')}}" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i>  Add New Roles</a>
                    </div>
                  </div>

            </div>
            <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <h3 class="mt-3 mb-5 text-uppercase text-center">Admin Roles</h3>
                        <table class="table table-bordered table-striped table-hover mt-3">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Role</th>
                              <th scope="col">Guard</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $i =1;
                            @endphp
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$role->name}}</td>
                                <td><span class="badge badge-danger">{{$role->guard_name}}</span></td>
                                <td>
                                <a class="btn btn-primary btn-sm" href="{{route('roles.edit',$role->id)}}"  ><i class="fas fa-edit"></i></a>
                                    </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
            </div>
        </div>
    </div>
  </div>

@endsection

