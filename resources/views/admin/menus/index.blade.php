@extends('layouts.adminlayout')


@section('content')
{!! Menu::render() !!}
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('vendor/harimayco-menu/style.css')}}">
@endpush
@push('js')
{!! Menu::scripts() !!}
@endpush
