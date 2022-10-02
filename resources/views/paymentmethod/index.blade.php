@extends('layouts.adminlayout')
@section('title','Payment Method')
@section('modal')
<!--Insert Modal -->
@component('component.common.modal')

    @slot('modal_id')
        PaymentModal
    @endslot
    @slot('modal_size')
    modal-md
    @endslot


    @slot('submit_button')
    add_modal_submit
    @endslot
    @slot('modal_title')
      Add Payment Method
    @endslot

    @slot('modal_form')
       <form action="{{route('paymentmethod.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    @endslot



    @slot('modal_body')

          <div class="form-group">
            <label for="name">Paymentmethod Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Paymentmethod Name" value="{{old('name')}}">
            @error('name')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>
          <div class="form-group">
            <label for="ac_number">Account Number</label>
            <input class="form-control @error('ac_number') is-invalid @enderror" type="text" name="ac_number" id="ac_number" value="{{old('ac_number')}}" placeholder="Enter A/C Number">
            @error('ac_number')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description')}}" placeholder="Enter Description" rows="8"></textarea>

            @error('description')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>
          <div class="form-group">
            <label for="image"></label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <small class="form-error">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <img style="padding: 10px;display:none;width: 200px" class="img-thumbnail rounded" src="" id="pd_image" alt="">
          </div>

    @endslot
@endcomponent
<!--End Insert Modal -->







@endsection
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-body table-responsive">
      <h5 class="card-title text-center">Payment Methods</h5>
    <button type="button" onclick="addMode('{{route('paymentmethod.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>
      <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">A/C Number</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
              $i=1;
          @endphp
          @foreach ($paymentmethods as $paymentmethod)
          <tr>
              <td>{{$i++}}</td>
              <td>{{$paymentmethod->name}}</td>
              <td><img style="height: 50px" src="{{asset('uploads/paymentmethod/original/'.$paymentmethod->image)}}" alt=""></td>
              <td>{{$paymentmethod->ac_number}}</td>
              <td>{!!$paymentmethod->description!!}</td>
              <td>
                <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess('{{route('paymentmethod.edit',$paymentmethod->id)}}','{{route('paymentmethod.update',$paymentmethod->id)}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button>


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

@push('css')


@endpush

@push('js')


@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>

if(sessionStorage.getItem("editMode") === 'true'){
    $('#PaymentModal').modal('show');
    $('#addForm').attr('action', sessionStorage.getItem("update_url"));

  }else{
    $('#PaymentModal').modal('show');
    $('#addForm').attr('action', sessionStorage.getItem("store_url"));
    putremove = $('input[value="PUT"]').detach();

  }

</script>
@endif



<script>
var putremove;


// Exit The Edit Mode

function addMode(store_url){
  $(".modal-title").text('Add Payment Method');
  $('#pd_image').hide();
  $('#PaymentModal').modal('show');
  if (typeof(Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("editMode",false);
    sessionStorage.setItem("store_url",store_url);
  }
  $('#addForm').attr('action', store_url);
  $('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
  if(putremove == undefined){
    putremove = $('input[value="PUT"]').detach();
  }

}

function addProductreadURL(input) {
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
  $('#pd_image').show();
});

</script>



<script>

var base_url = '{{url('/')}}';
function EditProcess(edit_url,update_url){
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
$.get(edit_url, function (data) {
    //Change Form Action
    $('#addForm').attr('action', update_url);
    $('.modal-title').text('Edit Payment Method');
    //assign data
    $('#name').val(data.name);
    $('#ac_number').val(data.ac_number);
    $('#description').val(data.description);
    $('#pd_image').attr('src',base_url+'/public/uploads/paymentmethod/original/'+data.image).show();
    $('#name').val(data.name);
    if(putremove != undefined){
      $("#addForm").prepend(putremove);
      putremove = undefined;
    }
    $('#PaymentModal').modal('show');
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
