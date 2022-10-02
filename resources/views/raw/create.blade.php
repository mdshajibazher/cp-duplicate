
@extends('layouts.adminlayout')
@section('title','Raw Materials')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
          <h5 class="card-title text-left">Create Raw Materials</h5>
    </div>
    <div class="card-body table-responsive">
      
     
      <div class="row justify-content-center">
          <div class="col-lg-4">
          <form action="{{route('raw.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Raw Materials Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Name" value="{{old('name')}}">
              @error('name')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>

            <div class="form-group">
              <label for="price">Purchase Price</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" placeholder="Enter Purchase Price" value="{{old('price')}}">
              @error('price')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>



            <div class="form-group">
              <label for="unit">Unit</label>
              <select name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror">
                @foreach ($units as $item)
                  <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
              @error('unit')
             <small class="form-error">{{ $message }}</small>
             @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Create</button>
            </div>

          </form>

          </div>
      </div>

    </div>
  </div>
</div>
</div>

@endsection

