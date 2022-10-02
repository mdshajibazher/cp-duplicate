@extends('layouts.adminlayout')
@section('title','Product Type')
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
<div class="col-lg-8">
	<div class="card">
    <div class="card-body table-responsive">
      <h5 class="card-title text-center">Type</h5>
      <button type="button" onclick="SubCategoryPopup('{{route('product_types.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>
      <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Image</th>
            <th>Show In Frontend</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($product_types_eloquent_collections as $key => $single_type)
            <tr>
                <th scope="row">{{$product_types_eloquent_collections->firstItem() + $key}}</th>

                <td>{{$single_type['name']}}</td>
                <td><img style="width: 100px" src="{{asset('uploads/product_type/frontend/'.$single_type->image)}}" alt=""></td>
                <td>@if($single_type->frontend) <span class="badge badge-success">true</span> @else  <span class="badge badge-danger">false</span> @endif</td>
            <td>

            <button class="btn btn-primary btn-sm" onclick="EditSubCategoryPopup('{{route('product_types.edit',$single_type['id'])}}','{{route('product_types.update',$single_type['id'])}}')"><i class="fas fa-edit"></i></button>
              </td>
            </tr>
        @endforeach



        </tbody>
      </table>
      <div class="links">
        {{$product_types_eloquent_collections->links()}}
      </div>
    </div>
  </div>
</div>




@endsection

@push('js')

<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script>


let baseurl = '{{url('/')}}';
function CategoryImageShow(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#cat_image').attr('src', e.target.result).show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}



function SubCategoryImageShow(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#subcat_image').attr('src', e.target.result).show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}

  function SubCategoryPopup(url){
  $("#productModalLabel").text('Add Product Types');
  $("#modal-data").html(`<form id="subcategory_form">
  <div class="form-group">
        <label for="name">Product Types</label>
      <input type="text"  class="form-control" name="name" id="name" placeholder="Enter Product Types" required>
      <small class="text-danger name_err"></small>
      </div>
      <div class="form-group">
        <label for="image">Product Type Image</label>
        <input onchange="SubCategoryImageShow(this)" type="file" class="form-control" name="image" id="image" required>
        <small class="text-danger image_err"></small>
        <img  style="padding: 10px;display:none" class="img-thumbnail rounded" src="" id="subcat_image" alt="">


      </div>
      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" >
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
        </div>
      <button type="button" id="subcategory_form_button" onclick="addSubcateogry('${url}')" class="btn btn-success">+ Add</button></div> </form>`);
  $('#productModal').modal('show');
}






function EditSubCategoryPopup(editurl,updateurl){
  // Make a request for a user with a given ID
axios.get(editurl)
  .then(function (response) {
    let show_in_frontend = "";
    if(response.data.frontend == true){
       show_in_frontend = "checked"
    }
    $("#productModalLabel").text('Edit '+response.data.name);
    $("#modal-data").html(`<form id="subcategory_form">
  <div class="form-group">
        <label for="name">Product Types</label>
      <input type="text"  class="form-control" name="name" id="name" placeholder="Enter Product Types" value="${response.data.name}" required>
      <small class="text-danger name_err"></small>
      </div>
      <div class="form-group">
        <label for="image">Product Type Image</label>
        <input onchange="SubCategoryImageShow(this)" type="file" class="form-control" name="image" id="image" required>
        <small class="text-danger image_err"></small>
        <img  style="padding: 10px;" class="img-thumbnail rounded" src="${baseurl}/public/uploads/product_type/frontend/${response.data.image}" id="subcat_image" alt="">


      </div>
      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" ${show_in_frontend}>
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
        </div>

      <button type="button" id="subcategory_form_button" onclick="updateSubCategory('${updateurl}')" class="btn btn-success">Update</button></div> </form>`);
  $('#productModal').modal('show');
  })
  .catch(function (error) {
    // handle error
    console.log(error);
    toastr.error(error.response.data.message,error.response.status);
  })



}



  function addSubcateogry(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#subcategory_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let frm  = $("#subcategory_form");
  let formData = new FormData(frm[0]);
  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#subcategory_form_button').text('+ Add').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#subcategory_form_button').text('+ Add').attr('disabled',false);



			});
			$(".text-danger").show();


 }



function updateSubCategory(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#subcategory_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let frm  = $("#subcategory_form");
  let formData = new FormData(frm[0]);
  console.log(formData);
  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#subcategory_form_button').text('update').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#subcategory_form_button').text('update').attr('disabled',false);



			});


			$(".text-danger").show();


 }

</script>
@endpush
