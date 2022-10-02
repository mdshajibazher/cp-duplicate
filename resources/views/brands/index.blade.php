@extends('layouts.adminlayout')
@section('title','Brands')

@section('modal')

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-data">

      </div>

    </div>
  </div>
</div>

@endsection
@section('content')
<div class="col-lg-6">
	<div class="card">
    <div class="card-body table-responsive">
      <h5 class="card-title text-center">BRANDS</h5>
      <button type="button" onclick="BrandPopup('{{route('brands.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>
      <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Show In Frontend</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($brands as $key => $brand)
            <tr>
                <th scope="row">{{$brands->firstItem() + $key}}</th>
                <td><img style="height: 50px" src="{{asset('uploads/brand/original/'.$brand->image)}}" alt=""></td>

                <td>{{$brand['brand_name']}}</td>
                <td>@if($brand->frontend) <span class="badge badge-success">true</span> @else  <span class="badge badge-danger">false</span> @endif</td>
            <td>
            <button class="btn btn-primary btn-sm" onclick="EditbrandPopup('{{route('brands.edit',$brand['id'])}}','{{route('brands.update',$brand['id'])}}')"><i class="fas fa-edit"></i></button>


              </td>
            </tr>
        @endforeach



        </tbody>
      </table>
      <div class="links">
        {{$brands->links()}}
      </div>
    </div>
  </div>
</div>




@endsection

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script>
let baseurl = '{{url('/')}}';

function BrandImageShow(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#brand_image').attr('src', e.target.result).show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}


function BrandPopup(url){
  $("#productModalLabel").text('Add Brand');
  $("#modal-data").html(`<form id="brand_form"> <div class="form-group">
        <label for="brand_name">Brand Name</label>
      <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Brand Name" required>
      <small class="text-danger brand_name_err"></small>
      </div>       <div class="form-group">
        <label for="image">Brand Image</label>
        <input onchange="BrandImageShow(this)" type="file" class="form-control" name="image" id="image" required>
        <small class="text-danger image_err"></small>
        <img  style="padding: 10px;display:none" class="img-thumbnail rounded" src="" id="brand_image" alt="">
      </div>
      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" >
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
      <div class="form-group mt-3"><button type="button" id="send_form" onclick="addBrand('${url}')" class="btn btn-success btn-block">+ Add</button></div> </form>`);
  $('#productModal').modal('show');
}

function EditbrandPopup(editurl,updateurl){
// Make a request for a user with a given ID

axios.get(editurl)
  .then(function (response) {
    let show_in_frontend = "";
    if(response.data.frontend == true){
       show_in_frontend = "checked"
    }
    $("#productModalLabel").text('Edit '+response.data.brand_name);
    $("#modal-data").html(`<form id="brand_form"> <div class="form-group">
        <label for="brand_name">Brand Name</label>
      <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Brand Name" value="${response.data.brand_name}" required>
      <small class="text-danger brand_name_err"></small>
      </div>        <div class="form-group">
        <label for="image">Brand Image</label>
        <input onchange="BrandImageShow(this)" type="file" class="form-control" name="image" id="image" required>
        <small class="text-danger image_err"></small>
        <img  style="padding: 10px;height: 100px" class="img-thumbnail rounded" src="${baseurl}/public/uploads/brand/original/${response.data.image}" id="brand_image" alt="">
      </div>
      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" ${show_in_frontend}>
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>

       <div class="form-group mt-3"><button type="button" id="send_form" onclick="updateBrand('${updateurl}')" class="btn btn-success btn-block">+ Update</button></div> </form>`);
  $('#productModal').modal('show');
  })
  .catch(function (error) {
    // handle error
    console.log(error);
    toastr.error(error.response.data.message,error.response.status);
  })



}





function updateBrand(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
  let frm  = $("#brand_form");
  let formData = new FormData(frm[0]);
  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#send_form').text('+ Add').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#send_form').text('+ Add').attr('disabled',false);



			});


			$(".text-danger").show();


 }



  function addBrand(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);

  let frm  = $("#brand_form");
  let formData = new FormData(frm[0]);

  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#send_form').text('+ Add').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#send_form').text('+ Add').attr('disabled',false);



			});


			$(".text-danger").show();


 }

</script>

@endpush
