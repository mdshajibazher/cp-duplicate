@extends('layouts.adminlayout')
@section('title','Ecommerce Sizes')

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
<div class="row justify-content-center">
<div class="col-lg-6">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-8">
          <h5 class="card-title text-left">Product Sizes</h5>
        </div>
        <div class="col-lg-4">
          <button type="button" onclick="SizePopup('{{route('sizes.store')}}')" class="btn btn-info btn-sm  float-right"><i class="fas fa-plus"> Add New</i></button>

        </div>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped table-hover mt-3">

        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Size Name</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($sizes as $key => $size)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$size['name']}}</td>
            <td>
            <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditSizePopup('{{route('sizes.edit',$size['id'])}}','{{route('sizes.update',$size['id'])}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button>

              </td>
            </tr>
        @endforeach



        </tbody>
      </table>
    </div>
  </div>
</div>
</div>



@endsection

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script>

  function SizePopup(url){
  $("#productModalLabel").text('Add Size');
  $("#modal-data").html(`<form id="size_form"> <div class="form-group">
        <label for="size_name">Tag Name</label>
      <input type="text" class="form-control" name="size_name" id="size_name" placeholder="Enter Size" required>
      <small class="text-danger size_name_err"></small>
      </div> <div class="form-group"><button type="button" id="send_form" onclick="addSize('${url}')" class="btn btn-success">+ Add</button></div> </form>`);
  $('#productModal').modal('show');
}

function EditSizePopup(editurl,updateurl){
  // Make a request for a user with a given ID
axios.get(editurl)
  .then(function (response) {
    $("#productModalLabel").text('Edit '+response.data.name);
    $("#modal-data").html(`<form id="size_form"> <div class="form-group">
        <label for="size_name">Brand Name</label>
      <input type="text" class="form-control" name="size_name" id="size_name" placeholder="Enter Size" value="${response.data.name}" required>
      <small class="text-danger size_name_err"></small>
      </div> <div class="form-group"><button type="button" id="send_form" onclick="updateSize('${updateurl}')" class="btn btn-success">Update</button></div> </form>`);
  $('#productModal').modal('show');
  })
  .catch(function (error) {
    // handle error
    console.log(error);
    toastr.error(error.response.data.message,error.response.status);
  })



}





function updateSize(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let data = $("#size_form").serialize();
  axios.put(url,data)
		.then(res => {
		  $('#productModal').modal('hide');
     toastr.success(res.data);
     $('#send_form').text('Update').attr('disabled',false);
     location.reload();
		})

		.catch(err => {
        toastr.error(err.response.data.message,err.response.status)
        let errors = err.response.data.errors;
        Object.keys(errors).forEach(function(value){
          $("#"+value+"").addClass("red-border");
          $("."+value+"_err").text(errors[value][0]);
        })
        $('#send_form').text('Update').attr('disabled',false);
			});
			$(".text-danger").show();
 }



  function addSize(url){
  $(".text-danger").hide().text("");
	$(".red-border").removeClass("red-border");
	$('#send_form').html('<i class="fas fa-spinner fa-spin"></i> Please Wait...').attr('disabled',true);
	let data = $("#size_form").serialize();
  axios.post(url,data)
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
