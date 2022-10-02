@extends('layouts.admin-vue-layout')
@section('title','Stock Details')
@section('content')
  <stock-component
      csrf="{{csrf_token()}}"
      hidden_count="{{$hidden_count}}"
      todays_date="{{Carbon\Carbon::now()->toDateString()}}"
      :products="{{json_encode($products)}}"
       base_url="{{url('/')}}"
      :stockinfo="{{json_encode($stock_info)}}"
      :warehouse="false"
      :auth_user_permissions="{{json_encode($authUserPermissions)}}"
  />
@endsection




