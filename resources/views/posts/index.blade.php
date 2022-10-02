@extends('layouts.adminlayout')
@section('title','Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Posts <a href="{{route('posts.create')}}" class="btn btn-dark float-right">+ Add New</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>sl</td>
                        <td>Title</td>
                        <td>Image</td>
                        <td>Category</td>
                        <td>Action</td>
                    </tr>

                    @foreach ($posts as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->title}}</td>
                        <td><img style="height: 100px" src="{{asset('uploads/posts/single/cropped/'.$item->image)}}" alt=""></td>
                        <td>Category</td>
                        <td><a class="btn btn-sm btn-warning" href="{{route('posts.edit',$item->id)}}"><i class="fas fa-edit"></i></a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
