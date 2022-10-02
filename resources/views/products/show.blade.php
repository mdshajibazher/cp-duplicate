@extends('layouts.adminlayout')
@section('title','Show Product')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-5">

  <div class="card">
    <div class="card-header">
    <a href="{{route('products.index')}}" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> back</a>
    </div>

    <img style="text-align: center;margin: 0 auto;padding: 20px" class="card-img-top img-thumbnail img-responsive" src="{{asset('uploads/products/original/'.$product['image'])}}" alt="Card image cap">
    <div class="card-body">
      <h3 class="card-title">{{$product['product_name']}}</h3><hr>
      <p>Price : <span class="badge badge-warning">{{$product['price']}} Tk</span>  </p>
      <p>Discount Price : <span class="badge badge-success">{{$product['discount_price']}} Tk</span>  </p>
      <p>Category : <span class="badge badge-danger">{{$product->category->category_name }}</span></p>
      <p>Subcategory : <span class="badge badge-primary">{{$product->product_type->name }}</span>  </p>
      <p>Brand : <span class="badge badge-secondary">{{$product->brand->brand_name }}</span>  </p>
      <p>Tags : @foreach ($product->tags as $tag)
        <span class="badge badge-warning">{{$tag->tag_name}}</span>
    @endforeach</td>  </p>
    <h5>Description: </h5>
      <p class="card-text">{{$product['description']}}</p>
    </div>
  </div>

</div>
</div>
@endsection
