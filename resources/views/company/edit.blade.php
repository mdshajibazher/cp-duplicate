@extends('layouts.adminlayout')
@section('title','Edit Company')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('company.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="text-right">EDIT - "<small>{{$company->company_name}}</small>"</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <form action="{{route('company.update',$company->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">

        <div class="col-lg-4">

            <div class="form-group">
                <label for="company_name">Company Name<span>*</span></label>
            <input type="text" id="company_name" placeholder="Enter Your Company name" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{old('company_name',$company->company_name)}}">

                @error('name')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="tagline">Tagline<span>*</span></label>
                <input type="text" id="tagline" placeholder="Enter Site tagline" class="form-control @error('tagline') is-invalid @enderror" name="tagline" value="{{old('tagline',$company->tagline)}}">

                @error('tagline')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="short_description">Short Description <span>*</span></label>
                <textarea class="form-control  @error('short_description') is-invalid @enderror" name="short_description" id="short_description" cols="30" rows="7">{{old('short_description',$company->short_description)}}</textarea>
                @error('short_description')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email<span>*</span></label>
                <input type="text" id="email" placeholder="Enter Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email',$company->email)}}">
                @error('email')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone<span>*</span></label>
            <input type="text" id="phone" placeholder="Enter Your phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone',$company->phone)}}">
                @error('phone')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>



            <div class="form-group facebook">
                <label for="facebook">Facebook Link: </label>
                <div class="row">


                <div class="col-lg-10">
                  <input type="hidden" name="facebook" value="facebook">
                  <input placeholder="Enter Facebook Link" type="text" class="form-control  @error('facebook') is-invalid @enderror" name="facebook" id="facebook" value="{{old('facebook')}}">
                </div>

                <div class="col-lg-2">
                  <input type='hidden' value='0' name='visibility1'>
                  <div class="icheck-emerland">
                    <input type="checkbox" id="visibility1" name="visibility1" value="1" @if(old('visibility1') == NULL) checked @elseif(old('visibility1') == 1) checked  @endif />
                    <label for="visibility1"></label>
                </div>
                </div>
              </div>

                @error('facebook')
               <small class="form-error">{{ $message }}</small>
               @enderror
              </div>


              <div class="form-group twitter">
                <label  for="twitter">Twitter Link: </label>
                <div class="row">

                <div class="col-lg-10">
              <input placeholder="Enter Twitter Link" type="text" class="@error('twitter') is-invalid @enderror form-control" name="twitter" id="twitter" value="{{old('twitter')}}">
            </div>
            <div class="col-lg-2">
              <input type='hidden' value='0' name='visibility2'>
              <div class="icheck-emerland">
                <input type="checkbox" id="visibility2" name="visibility2" value="1"  @if(old('visibility2') == NULL) checked @elseif(old('visibility2') == 1) checked @endif />
                <label for="visibility2"></label>
            </div>
            </div>
                </div>
                @error('twitter')
                <small class="form-error">{{ $message }}</small>
                @enderror

              </div>


            <div class="form-group linkedin">
                <label  for="linkedin">Linkedin Link: </label>
                <div class="row">

                <div class="col-lg-10">
              <input placeholder="Enter linkedin Link" type="text" class="@error('linkedin') is-invalid @enderror form-control" name="linkedin" id="linkedin" value="{{old('linkedin')}}">
            </div>
            <div class="col-lg-2">
              <input type='hidden' value='0' name='visibility3'>
              <div class="icheck-emerland">
                <input type="checkbox" id="visibility3" value="1" name="visibility3" @if(old('visibility3') == NULL) checked @elseif(old('visibility3') == 1) checked @endif />
                <label for="visibility3"></label>
            </div>
            </div>
                </div>

                @error('linkedin')
                <small class="form-error">{{ $message }}</small>
                @enderror
              </div>

            <div class="form-group">
              <label for="favicon">Favicon</label>
              <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" id="favicon">
              <small>Note: Please Keep Favicon Size 100x100 px </small>
              @error('favicon')
              <small class="form-error">{{ $message }}</small>
              @enderror

            </div>
            <div class="form-group">
                <img  class="img-thumbnail rounded" src="{{asset('uploads/favicon/cropped/'.$company->favicon)}}" id="pd_favicon" alt="">
            </div>

            <div class="form-group">
                <label for="og_image">Og Image <small>Social Media preview</small></label>
                <input type="file" class="form-control @error('og_image') is-invalid @enderror" name="og_image" id="og_image">
                <small>Note: Please Keep Og Image Size 200x200 px </small>
                @error('og_image')
                <small class="form-error">{{ $message }}</small>
                @enderror

            </div>

            <div class="form-group">
            <img  class="img-thumbnail rounded" src="{{asset('uploads/favicon/cropped/'.$company->og_image)}}" id="pd_og_image" alt="">
            </div>


        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="address">Address<span>*</span></label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address"  rows="4" placeholder="Enter Your Addres">{{old('address',$company->address)}}</textarea>

                @error('address')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="bin">BIN<span>*</span></label>
            <input type="text" name="bin" class="form-control @error('bin') is-invalid @enderror" id="bin"  placeholder="Enter BIN Number" value="{{old('bin',$company->bin)}}">

                @error('bin')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

          <div class="form-group">
            <label for="image">Logo</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
            <small>Note: Please Keep Logo Size 460x140 </small>
            @error('image')
            <small class="form-error">{{ $message }}</small>
            @enderror

          </div>

          <div class="form-group">
          <img  class="img-thumbnail rounded" src="{{asset('uploads/logo/cropped/'.$company->logo)}}" id="pd_image2" alt="">
          </div>





            <div class="form-group pinterest">
              <label  for="pinterest">Pinterest Link: </label>
              <div class="row">

              <div class="col-lg-10">
            <input placeholder="Enter pinterest Link" type="text" class="@error('pinterest') is-invalid @enderror form-control " name="pinterest" id="pinterest" value="{{old('pinterest')}}">
          </div>
          <div class="col-lg-2">
            <input type='hidden' value='0' name='visibility4'>
            <div class="icheck-emerland">
              <input type="checkbox" id="visibility4" value="1" name="visibility4" @if(old('visibility4') == NULL) checked @elseif(old('visibility4') == 1) checked @endif />
              <label for="visibility4"></label>
          </div>
          </div>
              </div>
              @error('pinterest')
              <small class="form-error">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label for="map_embed">Company Google Map Embed Code (optional)</label>
          <textarea id="map_embed" placeholder="Enter Google Map Embed Code" class="form-control @error('map_embed') is-invalid @enderror" name="map_embed" rows="8">{{old('map_embed',$company->map_embed)}}</textarea>

              @error('map_embed')
              <small class="form-error">{{ $message }}</small>
              @enderror
          </div>




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

function faviconURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#pd_favicon').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

function ogImageProcess(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#pd_og_image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}


$("#image").change(function() {
  addProductreadURL(this);
  $('#pd_image2').show();
});
$("#favicon").change(function() {
  faviconURL(this);
  $('#pd_favicon').show();
});
$("#og_image").change(function() {
    ogImageProcess(this);
    $('#pd_favicon').show();
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
