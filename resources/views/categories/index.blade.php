@extends('layouts.adminlayout')
@section('title','Categories')
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
      <h5 class="card-title text-center">CATEGORIES</h5>
      <button type="button" onclick="CategoryPopup('{{route('categories.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>
      @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

      <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th>Show In Frontend</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($categories as $key => $category)
            <tr>
                <th scope="row">{{$categories->firstItem() + $key}}</th>
                <td>{{$category['category_name']}}</td>
                <td> <img style="height: 50px;" class="img-responsive img-thumbnail" src="{{asset('uploads/category/thumb/'.$category['image'])}}" alt=""></td>
                <td>@if($category->frontend) <span class="badge badge-success">true</span> @else  <span class="badge badge-danger">false</span> @endif</td>
            <td>
            <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditCategoryPopup('{{route('categories.edit',$category['id'])}}','{{route('categories.update',$category['id'])}}')" ><i class="fas fa-edit"></i></button>

              </td>
            </tr>
        @endforeach



        </tbody>
      </table>
      <div class="links">
        {{$categories->links()}}
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





  function CategoryPopup(url){
  $("#productModalLabel").text('Add Category');
  $("#modal-data").html(`
<form enctype="multipart/form-data" id="category_form"><div class="form-group">
        <label for="category_name">Category Name</label>
      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name">

      <small class="text-danger category_name_err"></small>

      </div>

      <div class="form-group">
        <label for="category_image">Category Image</label>
        <input onchange="CategoryImageShow(this)" type="file" class="form-control" name="category_image" id="category_image">
        <img  style="padding: 10px;display:none" class="img-thumbnail rounded" src="" id="cat_image" alt="">
        <small class="text-danger category_image_err"></small>
      </div>

      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" >
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
        </div>

         <button type="button" id="category_form_button" onclick="addCategory('${url}')" class="btn btn-success">+ Add</button></div> </form>`);
  $('#productModal').modal('show');
}






function EditCategoryPopup(editurl,updateurl){
  // Make a request for a user with a given ID
axios.get(editurl)
  .then(function (response) {
    let show_in_frontend = "";
    if(response.data.frontend == true){
       show_in_frontend = "checked"
    }
    $("#productModalLabel").text('Edit '+response.data.category_name);
    $("#modal-data").html(`<form id="category_form" enctype="multipart/form-data"  method="POST">
    <div class="form-group">
        <label for="category_name">Category Name</label>
      <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" value="${response.data.category_name}">

      <small class="text-danger category_name_err"></small>

      </div>

      <div class="form-group">
        <label for="category_image">Category Image</label>
        <input onchange="CategoryImageShow(this)" type="file" class="form-control" name="category_image" id="category_image">
        <img  style="padding: 10px;" class="img-thumbnail rounded" src="${baseurl}/public/uploads/category/thumb/${response.data.image}" id="cat_image" alt="">
        <small class="text-danger category_image_err"></small>
      </div>

      <h5 class="mb-3">Show In Frontend</h5>
      <div class="onoffswitch">
                <input type="checkbox" name="frontend" class="onoffswitch-checkbox" id="frontend" value="1" ${show_in_frontend} >
                <label class="onoffswitch-label" for="frontend">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
        </div> <button type="button" id="category_form_button" onclick="updateCategory('${updateurl}')" class="btn btn-success"> update</button></div> </form>`);
  $('#productModal').modal('show');
  })
  .catch(function (error) {
    // handle error
    console.log(error);
    toastr.error(error.response.data.message,error.response.status);
  })



}



  function addCategory(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#category_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let frm  = $("#category_form");
  let formData = new FormData(frm[0]);
  console.log(formData);
  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#category_form_button').text('+ Add').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#category_form_button').text('+ Add').attr('disabled',false);



			});


			$(".text-danger").show();


 }



function updateCategory(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#category_form_button').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let frm  = $("#category_form");
  let formData = new FormData(frm[0]);
  axios.post(url,formData)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#category_form_button').text('update').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
      toastr.error(err.response.data.message,err.response.status)
			let errors = err.response.data.errors;
			Object.keys(errors).forEach(function(value){
				$("#"+value+"").addClass("red-border");
				$("."+value+"_err").text(errors[value][0]);
      })
      $('#category_form_button').text('update').attr('disabled',false);



			});


			$(".text-danger").show();


 }

</script>

@endpush
