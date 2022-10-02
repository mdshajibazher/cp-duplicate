
@extends('layouts.adminlayout')
@section('title','Create Inventory Customer')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('employee.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="card-title float-right">Employee Information</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <table class="table table-bordered">
                <tr>
                    <td>Name:</td>
                <td>{{$employee->name}}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>{{$employee->email}}</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>{{$employee->phone}}</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>{{$employee->address}}</td>
                </tr>
                <tr>
                    <td>Joining Date:</td>
                    <td>{{$employee->joining_date}}</td>
                </tr>
                <tr>
                    <td>Salary:</td>
                    <td>{{$employee->salary}}</td>
                </tr>
                <tr>
                    <td>NID:</td>
                    <td>{{$employee->nid}}</td>
                </tr>
                <tr>
                    <td>Employee Type:</td>
                    <td>{{$employee->employee_type->name}}</td>
                </tr>
            </table>
        </div>
    </div>
    </div>
  </div>
</div>
</div>


@endsection


