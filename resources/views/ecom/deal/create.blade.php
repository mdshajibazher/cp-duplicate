@extends('layouts.adminlayout')

@section('title','Create Product Deals')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('deals.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="card-title float-right">Add New Deal</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-lg-8">
    <form action="{{route('deals.store')}}" method="POST" style="border: 1px solid #ddd;padding: 20px;border-radius: 5px" enctype="multipart/form-data">
        @csrf
        <div class="row">

        <div class="col-lg-6">

            <div class="form-group">
                <label for="title">Deal Title<span>*</span></label>
            <input type="text" id="title" placeholder="Enter Deal Title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title')}}">

                @error('title')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deal Description<span>*</span></label>
            <input type="text" id="description" placeholder="Enter Deal Description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{old('description')}}">

                @error('description')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="product">Deal Product</label>
                <select data-placeholder="-select product-" class="js-example-responsive" name="product" id="product" class="form-control">
                <option></option>

                  @foreach ($products as $product)
                <option value="{{$product->id}}">{{$product->product_name}}</option>
                  @endforeach

                </select>
                <div class="product_err err_form"></div>

              </div>

            <div class="form-group">
                <label for="amount">Deal Amount<span>*</span></label>
                <input type="text" id="amount" placeholder="Enter Deal Amount" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{old('amount')}}">
                @error('amount')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Deal Image<span>*</span></label>
            <input type="file" id="image" placeholder="Upload Deal Image" class="form-control @error('image') is-invalid @enderror" name="image" value="{{old('image')}}">
                @error('image')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="expired_at">Expired At</label>
            <input type="text" class="form-control @error('expired_at') is-invalid @enderror" name="expired_at" placeholder="Enter Expirey  Date" id="expired_at" value="{{old('expired_at')}}">
            @error('expired_at')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="bg_color">Deal Background Color<span>*</span></label> <br>
            <input name="bg_color" class="form-control @error('bg_color') is-invalid @enderror" id="bg_color"  rows="4" placeholder="Enter Your Addres" value="{{old('bg_color','#dddddd')}}">

                @error('bg_color')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label for="btn_text">Deal Button Text<span>*</span></label>
            <input type="text" id="btn_text" placeholder="Enter Deal Button Text" class="form-control @error('btn_text') is-invalid @enderror" name="btn_text" value="{{old('btn_text','SHOP NOW')}}">
                @error('btn_text')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="btn_url">Deal Button Url<span>*</span></label>
            <input type="text" id="btn_url" placeholder="Enter Deal Button Text" class="form-control @error('btn_url') is-invalid @enderror" name="btn_url" value="{{old('btn_url')}}">
                @error('btn_url')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label for="button_color">Deal Button Color<span>*</span></label> <br>
            <input name="button_color" class="form-control @error('button_color') is-invalid @enderror" id="button_color"  placeholder="Enter Your Addres" value="{{old('button_color','#3498db')}}">

                @error('button_color')
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
<!-- Spectrum Css -->
<link href="{{asset('assets/css/spectrum.min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush


@push('js')
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script src="{{asset('assets/js/spectrum.min.js')}}"></script>
<script>
$("#product").select2({
    width: '100%',
    theme: "bootstrap",
    placeholder: "Select a Product",
});
$("#expired_at").flatpickr({enableTime: true});

$("#bg_color").spectrum({
    type: "color",
  showInput: "true",
  hideAfterPaletteSelect: "true"
});

$("#button_color").spectrum({
    type: "color",
  showInput: "true",
  hideAfterPaletteSelect: "true"
});



</script>
@endpush
