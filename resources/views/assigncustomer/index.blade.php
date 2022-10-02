@extends('layouts.adminlayout')

@section('title','Edit Inventory Customer')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <h5>Assign Customer</h5>
                </div>
                <div class="col-lg-8">
                    <a href="{{route('assigncustomers.create')}}" class="btn btn-sm btn-success float-right">Add New</a>
                </div>
            </div>
        </div>


        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">

              <table class="table">
                  <tr>
                    <td>Sl</td>
                    <td>Employee</td>
                    <td>Date Range</td>
                    <td>Customers</td>
                    <td>Action</td>
                  </tr>

                  @foreach ($assigncustomers as $key =>  $item)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$item->employee->name}}</td>
                      <td>{{$item->from->format('d-M-Y')}} To {{$item->to->format('d-M-Y')}}</td>
                      <td>@if($item->customers_arr != NULL)
                          @foreach (unserialize($item->customers_arr) as $customer_id)
                          @php
                            $customerinfo = DB::table('users')->where('id',$customer_id)->first()
                          @endphp
                                <span class="badge badge-success">{{  $customerinfo->name }}</span>
                          @endforeach
                        @endif</td>
                        <td><a class="btn btn-warning btn-sm" href="{{route('assigncustomers.edit',$item->id)}}"><i class="fas fa-edit"></i></a></td>
                    </tr>
                  @endforeach
              </table>

            </div>



   </div>
      </div>
    </div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
<style>
.select2-container--bootstrap .select2-selection--multiple .select2-selection__choice__remove{
  color: red !important;
}
.select2-container--bootstrap .select2-results__option[aria-selected="true"]{
  background: #FFC312 !important;
}
.select2-container--bootstrap .select2-selection--multiple .select2-selection__choice{
    border: none !important
}
</style>

@endpush

@push('js')
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
$("#from").flatpickr({dateFormat: 'Y-m-d'});
$("#to").flatpickr({dateFormat: 'Y-m-d'});

function reportSubmit(){
    sessionStorage.clear();
}


$('#employee').select2({
    width: '100%',
    theme: "bootstrap",
    placeholder: "Select a Employee",
});


$('#assigned_customers').select2({
      width: '100%',
      closeOnSelect: false,
      theme: "bootstrap",templateSelection: function (data, container) {
    $(container).css("background-color", "#4cd137");
    $(container).css("color", "#ffffff");
    return data.text;
}
});



    var base_url = '{{url('/')}}';


function isNumber(n) { return !isNaN(parseFloat(n)) && !isNaN(n - 0) }

    // Toaster
  //Toater Alert
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })




</script>
@endpush
