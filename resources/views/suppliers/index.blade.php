@extends('layouts.adminlayout')
@section('title','Suppliers')
@section('modal')
<!--Insert Modal -->
@component('component.common.modal')

    @slot('modal_id')
        addDataModal
    @endslot
    @slot('modal_size')
    modal-md
    @endslot


    @slot('submit_button')
    add_modal_submit
    @endslot
    @slot('modal_title')
      Add Suppliers
    @endslot

    @slot('modal_form')
       <form action="{{route('suppliers.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    @endslot



    @slot('modal_body')
          <div class="form-group">
            <label for="name">Supplier Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Supplier Name" value="{{old('name')}}">
            @error('name')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>
          <div class="form-group">
            <label for="company">Company Name</label>
          <input type="text" class="form-control @error('company') is-invalid @enderror" name="company" id="company" placeholder="Enter company Name" value="{{old('company')}}">
            @error('company')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>

          <div class="form-group">
            <label for="email">Email</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email" value="{{old('email')}}">
            @error('email')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Enter phone" value="{{old('phone')}}">
            @error('phone')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>
          <div class="form-group">
            <label for="address">Address</label>
          <textarea rows="6"  class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Enter address">{{old('address')}}</textarea>
            @error('address')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>






    @endslot
@endcomponent
<!--End Insert Modal -->







@endsection
@section('content')
<div class="col-lg-12">
	<div class="card">
    <div class="card-body table-responsive">
      <h5 class="card-title text-center">Suppliers</h5>
    <button type="button" onclick="addMode('{{route('suppliers.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>
      <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Company Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address Box</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($suppliers as $key => $supplier)
            <tr>
                <th scope="row">{{$suppliers->firstItem() + $key}}</th>
                <td>{{$supplier['name']}}</td>
                <td>{{$supplier['company']}}</td>
                <td>{{$supplier['phone']}}</td>
                <td>{{$supplier['address']}}</td>

            <td>
            <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess({{$supplier['id']}},'{{route('suppliers.update',$supplier['id'])}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button>


              <form id="delete-from-{{$supplier['id']}}" style="display: inline-block" action="{{route('suppliers.destroy',$supplier['id'])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deleteItem({{$supplier['id']}})"  class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>

                </form>
              </td>
            </tr>
        @endforeach



        </tbody>
      </table>
      <div class="links">
        {{$suppliers->links()}}
      </div>
    </div>
  </div>
</div>



@endsection

@push('css')
  <!-- Spectrum Css -->
  <link href="{{asset('assets/css/spectrum.min.css')}}" rel="stylesheet" />
@endpush

@push('js')
@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>

if(sessionStorage.getItem("editMode") === 'true'){
    $('#addDataModal').modal('show');
    $('#addForm').attr('action', sessionStorage.getItem("update_url"));

  }else{
    $('#addDataModal').modal('show');
    $('#addForm').attr('action', sessionStorage.getItem("store_url"));
    putremove = $('input[value="PUT"]').detach();

  }

</script>
@endif

<!-- Spectrum js -->
<script src="{{asset('assets/js/spectrum.min.js')}}"></script>

<script>
var putremove;
$(document).ready(function() {
// Spectrum colorpicker code


//For Addmodal


});




// Discount Box Toggle

function showInfo(){
  var element = document.getElementById("discount_info");
   element.classList.toggle('showInfo');
}
function editInfo(){
  var element = document.getElementById("edit_discount_info");
   element.classList.toggle('showInfo');
}
</script>





<script>
// Exit The Edit Mode

function addMode(store_url){
  $('#addDataModal').modal('show');
  if (typeof(Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("editMode",false);
    sessionStorage.setItem("store_url",store_url);
  }
  $('#addForm').attr('action', store_url);
  $('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
  $('#pd_image2').hide().attr('src',' ');
  $('#discount_status').prop("checked",false );
  $('#discount_info').removeClass("showInfo");
  if(putremove == undefined){
    putremove = $('input[value="PUT"]').detach();
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


$("#image").change(function() {
  addProductreadURL(this);
  $('#pd_image2').show();
});

</script>



<script>


function EditProcess(s_id, update_url){
$(document).ready(function(){
//reset form
$('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
// Go to Edit Mode If Click Edit Button
if (typeof(Storage) !== "undefined") {
  sessionStorage.setItem("editMode",true);
  sessionStorage.setItem("update_url",update_url);
}


var url = "suppliers";
var base_url = $('#open_modal').attr("data-baseurl");
$.get(url + '/' + s_id+'/edit', function (data) {
    //Change Form Action
    $('#addForm').attr('action', update_url);
    $('.modal-title').text('Edit Suppliers');
    //assign data
    $('#name').val(data.name);
    $('#company').val(data.company);
    $('#email').val(data.email);
    $('#phone').val(data.phone);
    $('#address').val(data.address);
    if(putremove != undefined){
      $("#addForm").prepend(putremove);
      putremove = undefined;
    }
    $('#addDataModal').modal('show');
})
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



<script>
function deleteItem(id){
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
@endpush
