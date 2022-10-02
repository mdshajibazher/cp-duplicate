@extends('layouts.adminlayout')
@section('title','Create Inventory Customer')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('ecomcustomer.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <p class="card-title float-right">Add New Customer For Ecommerce Module</p>
                </div>
            </div>
        </div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h4 class="text-center">Ecommerce Module Customer</h4>
    <form action="{{route('ecomcustomer.store')}}" method="POST" style="border: 1px solid #ddd;padding: 20px;border-radius: 5px">
        @csrf
        <div class="row">
       
        <div class="col-lg-6">
            
            <div class="form-group">
                <label for="name">Customer Name<span>*</span></label>
            <input type="text" id="name" placeholder="Enter Your Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
      
                @error('name')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


      
            <div class="form-group">
                <label for="email">Email<span>(optional)</span></label>
                <input type="text" id="email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                @error('email')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>
      
            <div class="form-group">
                <label for="phone">Phone</label>
            <input type="text" id="phone" placeholder="Enter Your phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}">
                @error('phone')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

      

        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="address">Address<span>*</span></label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address"  rows="4" placeholder="Enter Your Addres" required>{{old('address')}}</textarea>
                
                @error('address')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            
            <div class="form-group">
                <label for="division">Division<span>*</span></label>
                <select name="division" id="division" class="form-control @error('division') is-invalid @enderror" required>
                    <option value="">Select Division</option>
                    @foreach ($divisions as $item)
                        <option value="{{$item->id}}" {{ (old("division") == $item->id ? "selected": "") }}>{{$item->name}}</option>
                    @endforeach
                    
                </select>
                @error('division')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            

        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Create</button>
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

@push('css')

@endpush


@push('js')
<script>

$('#division').select2({
    width: '100%',
    theme: "bootstrap",
    placeholder: "Select a Division",
});

</script>
@endpush