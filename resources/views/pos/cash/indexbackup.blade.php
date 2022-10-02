@extends('layouts.adminlayout')
@section('title','Inventory Cash')

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="cashSubmissionModal" tabindex="-1" role="dialog" aria-labelledby="cashSubmissionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashSubmissionModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="expense-form">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



{{--@section('modal')--}}
{{--<!--Insert Modal -->--}}
{{--@component('component.common.modal')--}}

{{--    @slot('modal_id')--}}
{{--        addDataModal--}}
{{--    @endslot--}}
{{--    @slot('modal_size')--}}
{{--    modal-md--}}
{{--    @endslot--}}


{{--    @slot('submit_button')--}}
{{--    cash_modal_submit--}}
{{--    @endslot--}}
{{--    @slot('modal_title')--}}
{{--      Cash--}}
{{--    @endslot--}}

{{--    @slot('modal_form')--}}
{{--       <form action="{{route('cash.store')}}" method="POST" id="cashForm">--}}
{{--        @csrf--}}
{{--        @method('PUT')--}}
{{--    @endslot--}}



{{--    @slot('modal_body')--}}
{{--        <div class="form-group">--}}
{{--           <h5 id="due" style="color: red;text-align: right"></h5>--}}
{{--        </div>--}}
{{--          <div class="form-group">--}}
{{--            <label for="received_at">Cash Receive Date</label>--}}
{{--            @php--}}
{{--                $mytime = Carbon\Carbon::now();--}}
{{--            @endphp--}}
{{--            <input type="text" class="form-control @error('received_at') is-invalid @enderror" name="received_at" id="received_at" value="{{old('received_at',$mytime->toDateString())}}">--}}
{{--            @error('received_at')--}}
{{--            <small class="form-error">{{ $message }}</small>--}}
{{--            @enderror--}}
{{--          </div>--}}
{{--          <div class="form-group">--}}
{{--            <label for="user">Customer</label>--}}
{{--            <select data-placeholder="Select a User" name="user" id="user" class="form-control @error('user') is-invalid @enderror" required>--}}
{{--              <option></option>--}}
{{--              @foreach ($users as $user)--}}
{{--                <option value="{{$user->id}}" @if (old('user') == $user->id) selected  @endif>{{$user->name}}</option>--}}
{{--              @endforeach--}}
{{--            </select>--}}
{{--            @error('user')--}}
{{--            <small class="form-error">{{ $message }}</small>--}}
{{--            @enderror--}}
{{--            <div id="user-details"></div>--}}
{{--          </div>--}}
{{--          <div class="form-group">--}}
{{--            <label for="amount">Amount</label>--}}
{{--          <input oninput="resetDiscount()" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="actual_amount" placeholder="Enter Amount" value="{{old('amount')}}" required>--}}
{{--            @error('amount')--}}
{{--           <small class="form-error">{{ $message }}</small>--}}
{{--           @enderror--}}
{{--          </div>--}}

{{--           <div class="form-group">--}}
{{--               <label for="amount">Discount</label>--}}
{{--               <input oninput="calcaulateAmount(event)" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" id="discount" placeholder="Enter Discount Amount" value="{{old('discount')}}" required>--}}
{{--               @error('discount')--}}
{{--               <small class="form-error">{{ $message }}</small>--}}
{{--               @enderror--}}
{{--           </div>--}}
{{--          <div class="form-group">--}}
{{--            <label for="payment_method">Payment Method</label>--}}
{{--            <select data-placeholder="Select Payment Method" name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>--}}
{{--              <option></option>--}}
{{--              @foreach ($payment_methods as $pmd)--}}
{{--                <option value="{{$pmd->id}}" @if (old('user') == $pmd->id) selected  @endif>{{$pmd->name}}</option>--}}
{{--              @endforeach--}}
{{--            </select>--}}
{{--            @error('payment_method')--}}
{{--            <small class="form-error">{{ $message }}</small>--}}
{{--            @enderror--}}
{{--          </div>--}}

{{--          <div class="form-group">--}}
{{--            <label for="reference">Reference</label>--}}
{{--          <input type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" id="reference" placeholder="Enter Referance" value="{{old('reference')}}">--}}
{{--            @error('reference')--}}
{{--           <small class="form-error">{{ $message }}</small>--}}
{{--           @enderror--}}
{{--          </div>--}}

{{--    @endslot--}}
{{--@endcomponent--}}
{{--<!--End Insert Modal -->--}}







@endsection

@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h5 class="card-title text-left">Inventory Cashes</h5>
                  </div>
                    <div class="col-lg-6">
                      <button type="button" onclick="addMode('{{route('cash.store')}}')" class="btn btn-info btn-sm float-right"><i class="fas fa-plus"></i>  Add New Cashes</button>

                    </div>

                  </div>

            </div>
            <div class="card-body">
                <form action="{{route('poscash.result')}}" method="POST">
                    @csrf
                      <div class="row mb-3 justify-content-center">
                        <div class="col-lg-1">
                          <div class="form-group">
                            <strong>FROM : </strong>
                          </div>
                        </div>
                        <div class="col-lg-3">

                          <div class="form-group">
                            <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                                @error('start')
                                <small class="form-error">{{ $message }}</small>
                                @enderror
                          </div>
                        </div>
                        <div class="col-lg-1">
                          <div class="form-group">
                            <strong>To : </strong>
                          </div>
                        </div>

                        <div class="col-lg-3">
                          <div class="form-group">
                            <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                            @error('end')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>


                        <div class="col-lg-2">
                          <div class="form-group">
                            <button type="submit" class="btn btn-info">filter</button>
                          </div>

                        </div>
                      </div>
                    </form>

                    <div class="row">
                      <div class="col-lg-12">
                        <h3 class="mt-3 mb-5 text-uppercase text-center">Last 10 Transection</h3>
                        <table class="table table-bordered table-striped table-hover mt-3">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Date</th>
                              <th scope="col">User</th>
                              <th scope="col">Payment Method</th>
                              <th scope="col">Amount</th>
                              <th scope="col">Status</th>
                              <th scope="col">Reference</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $i =1;
                            @endphp
                            @foreach ($cashes as $cash)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$cash->received_at->format('d-m-Y g:i a')}}</td>
                                <td>{{$cash->user->name}}</td>
                                <td>{{$cash->paymentmethod->name}}</td>
                                <td>{{$cash->amount}}</td>
                                <td>{!!InvCashStatus($cash->status)!!}</td>
                                <td>{{$cash->reference}}</td>
                                <td>
                                <button class="btn btn-primary btn-sm" id="open_modal" onclick="EditProcess('{{route('cash.edit',$cash->id)}}','{{route('cash.update',$cash->id)}}')"  data-baseurl="{{asset('')}}" ><i class="fas fa-edit"></i></button> | <a target="_blank" class="btn btn-sm btn-info" href="{{route('cash.show',$cash->id)}}"><i class="fas fa-eye"></i></a>

                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>

            </div>
        </div>





    </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
<script src="{{asset('assets/js/axios.min.js')}}"></script>

@if ($errors->any())
{{-- prevent The Modal Close If Any Error In the Form --}}
<script>

if(sessionStorage.getItem("editMode") === 'true'){
    $('#addDataModal').modal('show');
    $('#cashForm').attr('action', sessionStorage.getItem("update_url"));

  }else{
    $('#addDataModal').modal('show');
    $('#cashForm').attr('action', sessionStorage.getItem("store_url"));
    putremove = $('input[value="PUT"]').detach();
  }

</script>
@endif
<script>
$('form').on('focus', 'input[type=number]', function (e) {
    $(this).on('wheel.disableScroll', function (e) {
        e.preventDefault()
    })
})
$('form').on('blur', 'input[type=number]', function (e) {
    $(this).off('wheel.disableScroll')
})


$('#cashForm').submit(function(){
    $("#cash_modal_submit").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
});

function calcaulateAmount(event){
    let current_amount =  document.getElementById("actual_amount").value;
    let discount_amount = event.target.value;
    if(current_amount != "" && discount_amount != ""){
        let old_amount = sessionStorage.setItem('old_cash_amount',current_amount);
        let new_amount = parseFloat(current_amount) - parseFloat(discount_amount);
        console.log(new_amount);
        document.getElementById("actual_amount").value = new_amount;
    }
}

function resetDiscount(event){
    document.getElementById("discount").value = 0;
}



var baseurl = '{{url('/')}}';
$( "#user" ).change(function() {
    var user_id = $("#user option:selected").val();

  function getUserInfo() {
    return axios.get(baseurl+"/api/userinfo/"+user_id);
  }
  function getDueInfo() {
    return axios.get(baseurl+"/api/invdueinfo/"+user_id);
  }

  axios.all([getUserInfo(),getDueInfo()])
  .then(function (results) {
    const USERINFO = JSON.parse(results[0].request.response);
    $('#user-details').show();
    $("#user-details").html("<div class='user-deatils'><h4 class='text-center'> "+USERINFO.name+"</h4><br><b>Address :</b> "+USERINFO.address+"<br><b>Phone :</b> "+USERINFO.phone+"<br><b>Email :</b>"+USERINFO.inventory_email+"</div>");
    const DUEINFO = results[1].request.response;
    $("#due").html('Current Due: <span>'+DUEINFO+'</span>/-');
  });

});


var putremove;

// Exit The Edit Mode

function addMode(store_url){
  $('#addDataModal').modal('show');
  $('.modal-title').text('Posting Cash');
  if (typeof(Storage) !== "undefined") {
    // Store
    sessionStorage.setItem("editMode",false);
    sessionStorage.setItem("store_url",store_url);
  }
  $('#cashForm').attr('action', store_url);
  $('#cashForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
  //$('#user').val('').trigger('change');
  $('#user-details').hide();
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

$('#user').select2({
width: '100%',
  theme: "bootstrap"
});
$('#payment_method').select2({
width: '100%',
  theme: "bootstrap"
});


function EditProcess(edit_url, update_url){
$(document).ready(function(){
  $('#user-details').show();
//reset form
$('#cashForm').trigger("reset");
  $(".is-invalid").removeClass("is-invalid");
  $(".form-error").remove();
// Go to Edit Mode If Click Edit Button
if (typeof(Storage) !== "undefined") {
  sessionStorage.setItem("editMode",true);
  sessionStorage.setItem("update_url",update_url);
}
$.get(edit_url, function (data) {
    //Change Form Action
    $('#cashForm').attr('action', update_url);
    $('.modal-title').text('Edit Previously  Posted Cash');
    //assign data
    $('#received_at').val(data.received_at.substring(0, 10)).trigger('change');
    $('#amount').val(data.amount);
    $('#user').val(data.user_id).trigger('change');
    $('#payment_method').val(data.paymentmethod_id).trigger('change');
    $('#reference').val(data.reference);
    if(putremove != undefined){
      $("#cashForm").prepend(putremove);
      putremove = undefined;
    }
    $('#addDataModal').modal('show');
})
});
}
</script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
  $("#received_at").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


