
@extends('layouts.adminlayout')
@section('title','Create Inventory Customer')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('emp_type.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="card-title float-right">Edit Employee Types</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-lg-6">
    <form action="{{route('emp_type.update',$emp_type->id)}}" method="POST" style="border: 1px solid #ddd;padding: 20px;border-radius: 5px">
        @csrf
        @method('PUT')
        <div class="row">
        
        <div class="col-lg-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            
            <div class="form-group">
                <label for="emp_type">Employee Type<span>*</span></label>
            <input type="text" id="emp_type" placeholder="Enter Employee Types" class="form-control @error('emp_type') is-invalid @enderror" name="emp_type" value="{{old('emp_type',$emp_type->name)}}"required>
      
                @error('emp_type')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    
    </div>
</form>
</div>
</div>
    </div>
  </div>
</div>
</div>


@endsection

