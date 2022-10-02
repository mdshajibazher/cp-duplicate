@if(Session::has('OrderCompleted'))

@extends('layouts.frontendlayout')
@section('content')
<div class="jumbotron text-center" style="background: #fff">
    <h1 style="color: #4cd137">   <i class="icon_check_alt2"></i>  </h1> 
    <h1 class="display-3">Thank You!</h1>
    <div class="col-lg-4 offset-lg-4">

    <table class="table">
        <tr>
            <th> Order ID </th>
            <th>{{Session::get('OrderCompleted')['orderid']}}</th>
        </tr>
        <tr>
            <th>Status</th>
            <th>{{Session::get('OrderCompleted')['status']}}</th>
        </tr>
        <tr>
            <th>Estimated Delivery Date: </th>
            <th>Null</th>
        </tr>
        
    </table>
</div>
    <p class="lead"><strong>Please check your email</strong> for further instructions</p>
    <hr>
    <p>
      Having trouble? <a href="#">Contact us</a>
    </p>
    <p class="lead">
      <a class="btn btn-primary btn-sm" href="{{route('homepage.index')}}" role="button">Continue to homepage</a>
    </p>
  </div>
@endsection

@else
@php
    return false;
@endphp
@endif