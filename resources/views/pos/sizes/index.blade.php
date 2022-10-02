@extends('layouts.adminlayout')
@section('title','Inventory Product Sizes')
@section('modal')
<!--Insert Modal -->
@component('component.common.modal')

    @slot('modal_id')
        DataModal
    @endslot
    @slot('submit_button')
    add_modal_submit
    @endslot
    @slot('modal_title')
      Add Sizes
    @endslot

    @slot('modal_form') 
       <form action="{{route('productsizes.store')}}" method="POST" id="addForm">
        @csrf
    @endslot

    

    @slot('modal_body')
      <div class="form-group">
        <label for="name">Size Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Size Name" value="{{old('name')}}">
        @error('name')
       <small class="form-error">{{ $message }}</small>
       @enderror
      </div>
      
    @endslot
@endcomponent
<!--End Insert Modal -->





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
        <label for="edit_name">Size Name</label>
      <input type="text" class="form-control @error('edit_name') is-invalid @enderror" name="edit_name" id="edit_name" placeholder="Enter size Name" value="{{old('edit_name')}}">
        @error('edit_name')
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
          <h5 class="card-title text-left">Inventory Product Sizes</h5>
        </div>
        <div class="col-lg-4">
          <button type="button" onclick="addSize()" class="btn btn-info  float-right"><i class="fas fa-plus"> Add New</i></button>
          
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
            <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess({{$size['id']}},'{{route('productsizes.update',$size['id'])}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button> 
         
            
              <form id="delete-from-{{$size['id']}}" style="display: inline-block" action="{{route('productsizes.destroy',$size['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deleteProduct({{$size['id']}})"  class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
        
                </form> 
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

function addSize(){
  $('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
  $('#DataModal').modal('show');
  if (typeof(Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("editMode",false);
    // Retrieve
    console.log(sessionStorage.getItem("editMode"));
  }
}

// Show Current Image On the Form Before Upload

function addProductreadURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#pd_image2').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

function EditProductreadURL(input) {
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
$("#edit_image").change(function() {
  EditProductreadURL(this);
});




function EditProcess(s_id, update_url){
  $('#editForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
$(document).ready(function(){

// Go to Edit Mode If Click Edit Button
if (typeof(sessionStorage) !== "undefined") {

  sessionStorage.setItem("editMode",true);
  sessionStorage.setItem("update_url",update_url);
  console.log(sessionStorage.getItem("editMode"));
}


var url = "productsizes";
var base_url = $('#open_modal').attr("data-baseurl");
console.log(base_url);
$.get(url + '/' + s_id+'/edit', function (data) {

    //Change Form Action
    $('#editForm').attr('action', update_url);
    //assign data
    $('#edit_name').val(data.name);
    $('#editDataModal').modal('show');
}) 
});
}

function deleteProduct(id){
         const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success btn-sm',
                cancelButton: 'btn btn-danger btn-sm'
            },
            buttonsStyling: true
            })

    swalWithBootstrapButtons.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('delete-from-'+id).submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your Data  is safe :)',
                'error'
                )
            }
            });
        }
</script>


<!-- Success Alert After Product  Delete -->
@if(Session::has('delete_success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'Your Data has Been Deleted Successfully',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif

@endpush