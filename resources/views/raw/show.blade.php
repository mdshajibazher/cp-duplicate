
@extends('layouts.adminlayout')
@section('title','Raw Materials')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
    <h5 class="card-title text-left">{{$rawmaterial->product_name}}</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table">
          <tr>
            <td>Name: </td>
            <td>{{$rawmaterial->product_name}}</td>
          </tr>
          <tr>
            <td>Price: </td>
            <td>{{$rawmaterial->price}}</td>
          </tr>
          <tr>
            <td>Unit: </td>
            <td>{{$rawmaterial->unit->name}}</td>
          </tr>
        </table>
     

    </div>
  </div>
</div>
</div>

@endsection

