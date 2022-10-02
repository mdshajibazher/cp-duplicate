
@extends('layouts.adminlayout')
@section('title','Raw Materials')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
    <h5 class="card-title text-left">Edit "{{$rawmaterial->product_name}}"</h5>
    </div>
    <div class="card-body table-responsive">
      
     
      <div class="row justify-content-center">
          <div class="col-lg-4">
          <form action="{{route('raw.update',$rawmaterial->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name">Raw Materials Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Name" value="{{old('name',$rawmaterial->product_name)}}">
              @error('name')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>

            <div class="form-group">
              <label for="price">Purchase Price</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Enter Purchase Price" value="{{old('price',$rawmaterial->price)}}">
              @error('price')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>



            <div class="form-group">
              <label for="unit">Unit</label>
              <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror">
                @foreach ($units as $item)
                  <option value="{{$item->id}}" @if($rawmaterial->unit_id == $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
              </select>
              @error('unit')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>

          </form>

          </div>
      </div>

    </div>
  </div>
</div>
</div>

@endsection

