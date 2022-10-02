@extends('layouts.adminlayout')
@section('title','Payments')

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
      Cash
    @endslot

    @slot('modal_form')
       <form action="{{route('payment.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    @endslot



    @slot('modal_body')
          <div class="form-group">
            <label for="payments_at">Cash Receive Date</label>
            @php
                $mytime = Carbon\Carbon::now();
            @endphp
            <input type="text" class="form-control @error('payments_at') is-invalid @enderror" name="payments_at" id="payments_at" value="{{$mytime->toDateString()}}">
            @error('payments_at')
            <small class="form-error">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="supplier">Supplier</label>
            <select data-placeholder="Select a Supplier" name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror">
              <option></option>
              @foreach ($suppliers as $supplier)
                <option value="{{$supplier->id}}" @if (old('supplier') == $supplier->id) selected  @endif>{{$supplier->name}}</option>
              @endforeach
            </select>
            @error('supplier')
            <small class="form-error">{{ $message }}</small>
            @enderror
            <div id="supplier-details"></div>
          </div>
          <div class="form-group">
            <label for="amount">Amount</label>
          <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" placeholder="Enter Amount" value="{{old('amount')}}">
            @error('amount')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>


          <div class="form-group">
            <label for="reference">Reference</label>
          <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" id="reference" placeholder="Enter Referance" value="{{old('reference')}}">
            @error('reference')
           <small class="form-error">{{ $message }}</small>
           @enderror
          </div>

    @endslot
@endcomponent
<!--End Insert Modal -->







@endsection
@section('content')

<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <button type="button" onclick="addMode('{{route('payment.store')}}')" class="btn btn-info btn-sm"><i class="fas fa-plus"> ADD NEW</i></button>

        </div>
        <div class="col-lg-6">
          <h5 class="card-title text-right">Payments</h5>
        </div>
      </div>


    </div>
    <div class="card-body table-responsive">

      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Suppliers</th>
            <th scope="col">Amount</th>
            <th scope="col">Reference</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @php
              $i =1;
          @endphp
          @foreach ($payments as $payment)
          <tr>
              <td>{{$i++}}</td>
              <td>{{$payment->payments_at->format('d-m-Y g:i a')}}</td>
              <td>{{$payment->supplier->name}}</td>
              <td>{{$payment->amount}}</td>
              <td>{{$payment->reference}}</td>
              <td>
                <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess('{{route('payment.edit',$payment->id)}}','{{route('payment.update',$payment->id)}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button>


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
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
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



<script>
$( "#supplier" ).change(function() {
    var supplier_id = $("#supplier option:selected").val();
    $.get("{{url('/')}}/api/supplierinfo/"+supplier_id, function(data, status){
      if(status === 'success'){
        $('#supplier-details').show();
        $("#supplier-details").html("<div class='supplier-deatils'><h4 class='text-center'> "+data.name+"</h4><br><b>Address :</b> "+data.address+"<br><b>Phone :</b> "+data.phone+"<br><b>Email :</b>"+data.email+"</div>");

      }
    });
});


var putremove;

// Exit The Edit Mode

function addMode(store_url){
  $('#addDataModal').modal('show');
  $('.modal-title').text('Add Payment Method');
  if (typeof(Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("editMode",false);
    sessionStorage.setItem("store_url",store_url);
  }
  $('#addForm').attr('action', store_url);
  $('#addForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
  $('#supplier').val('').trigger('change');
  $('#supplier-details').hide();
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


//Select 2

$('#supplier').select2({
width: '100%',
  theme: "bootstrap"
});
$('#payment_method').select2({
width: '100%',
  theme: "bootstrap"
});


function EditProcess(edit_url, update_url){
$(document).ready(function(){
  $('#supplier-details').show();
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
    $('#payments_at').val(data.payments_at.substring(0, 10)).trigger('change');
    $('#amount').val(data.amount);
    $('#supplier').val(data.supplier_id).trigger('change');
    $('#payment_method').val(data.paymentmethod_id).trigger('change');
    $('#reference').val(data.reference);
    if(putremove != undefined){
      $("#addForm").prepend(putremove);
      putremove = undefined;
    }
    $('#addDataModal').modal('show');
})
});
}
</script>



<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>

$("#payments_at").flatpickr({dateFormat: 'Y-m-d'});

$('#jq_datatables').DataTable({
  "order": [ [1, 'desc'] ],
  // "columnDefs": [
  //       { "targets": [4,5,6,7,8], "searchable": false }
  //   ],
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
               return nRow;
    },
});

</script>
@endpush
