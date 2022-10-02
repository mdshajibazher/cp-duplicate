@extends('layouts.adminlayout')
@section('title','Delivery')
@section('modal')

<!--Edit Modal -->
@component('component.common.modal')

    @slot('modal_id')
    editDataModal
    @endslot
    @slot('submit_button')
        edit_modal_submit
    @endslot
    @slot('modal_title')
      Edit Size
    @endslot

    @slot('modal_form') 
       <form action="" method="POST" id="editForm">
        @csrf
        @method('PUT')
    @endslot

    

    @slot('modal_body')
    <div class="form-group">
      <label for="edit_delay">Delivery Delay In  Days</label>
    <input type="number" class="form-control @error('edit_delay') is-invalid @enderror" name="edit_delay" id="edit_delay" placeholder="Enter Delay eg: 3 days" value="{{old('edit_delay')}}">
      @error('edit_delay')
     <small class="form-error">{{ $message }}</small>
     @enderror
    </div>
      
    @endslot
@endcomponent
<!--Edit  Modal -->








@endsection
@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-8">
          <h5 class="card-title text-left">Ecommerce Delivery Information</h5>
        </div>
        <div class="col-lg-4">
         
          
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-striped table-hover mt-3">
     

          <tr>
            <th scope="col">Delivery Delays</th>
            <td>{{$deliveryinfo['delay']}} Days</td>
          </tr>
          <tr>
            <th scope="col">Action</th>
            <td> <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess({{$deliveryinfo['id']}},'{{route('deliveryinfo.update',$deliveryinfo['id'])}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button> </td>
          </tr>


      </table>
    </div>
  </div>
</div>
</div>



@endsection

@push('js')


@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>

  if(sessionStorage.getItem("editMode") === 'true'){
    $('#editDataModal').modal('show');
    $('#editForm').attr('action', sessionStorage.getItem("update_url"));
    

  }else{
    $('#DataModal').modal('show');
    console.log(sessionStorage.getItem("editMode"));
  }

</script>
@endif




<script>
// Exit The Edit Mode 
function EditProcess(s_id, update_url){
  $('#editForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();


// Go to Edit Mode If Click Edit Button
if (typeof(sessionStorage) !== "undefined") {

  sessionStorage.setItem("editMode",true);
  sessionStorage.setItem("update_url",update_url);
  console.log(sessionStorage.getItem("editMode"));
}


var url = "deliveryinfo";
var base_url = $('#open_modal').attr("data-baseurl");
$.get(url + '/' + s_id+'/edit', function (data) {

    //Change Form Action
    $('#editForm').attr('action', update_url);
    //assign data
    $('#edit_delay').val(data.delay);
    $('#editDataModal').modal('show');
}) 

}

</script>




@endpush