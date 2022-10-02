@extends('layouts.adminlayout')
@section('title','Edit Advertisement')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('advertisement.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="text-right">EDIT - "<small>{{$adv->title}}</small>"</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <form action="{{route('advertisement.update',$adv->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
          <div class="col-lg-4">

            <div class="form-group">
                <label for="title">Ad Title<span>*</span></label>
            <input type="text" id="title" placeholder="Enter Ad Title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{old('title',$adv->title)}}">

                @error('title')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>



            <div class="form-group">
              <label for="image">Advertise Image</label>
              <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
              <small>Note: Please Keep Image Size 470x620 px </small>
              @error('image')
              <small class="form-error">{{ $message }}</small>
              @enderror

            </div>

            <div class="form-group">
            <img  class="img-thumbnail rounded" src="{{asset('uploads/ad/cropped/'.$adv->image)}}" id="pd_image" alt="">
            </div>



            <div class="form-group">
              <label for="button_text">Button Text<span>*</span></label>
          <input type="text" id="button_text" placeholder="Enter Button Text" class="form-control @error('button_text') is-invalid @enderror" name="button_text" value="{{old('button_text',$adv->button_text)}}">

              @error('button_text')
              <small class="form-error">{{ $message }}</small>
              @enderror
          </div>


          <div class="form-group">
            <label for="button_link">Button Link<span>*</span></label>
        <input type="text" id="button_link" placeholder="Enter Button Text" class="form-control @error('button_link') is-invalid @enderror" name="button_link" value="{{old('button_link',$adv->button_link)}}">

            @error('button_link')
            <small class="form-error">{{ $message }}</small>
            @enderror
        </div>


        <div class="form-group">
          <button type="submit" class="btn btn-success">Update</button>
      </div>


        </div>

        </div>


    </div>
</form>
    </div>
  </div>
</div>
</div>


@endsection

@push('css')

@endpush


@push('js')
<script>


function addProductreadURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#pd_image2').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

function imageURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#pd_image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}


$("#image").change(function() {
  addProductreadURL(this);
  $('#pd_image2').show();
});
$("#image").change(function() {
  imageURL(this);
  $('#pd_image').show();
});

$.get('{{route('social.api')}}', function (data, status) {
    if(status === 'success'){
    var social_json = JSON.parse(data.social);
    $('#facebook').val(social_json.facebook[0]);
    $('#twitter').val(social_json.twitter[0]);
    $('#pinterest').val(social_json.pinterest[0]);
    $('#linkedin').val(social_json.linkedin[0]);
    if(social_json.facebook[1] == 0){
      $('#visibility1').prop("checked",false );
    }
    if(social_json.twitter[1] == 0){
      $('#visibility2').prop("checked",false );
    }
    if(social_json.pinterest[1] == 0){
      $('#visibility4').prop("checked",false );
    }
    if(social_json.linkedin[1] == 0){
      $('#visibility3').prop("checked",false );
    }
    }
});





</script>
@endpush
