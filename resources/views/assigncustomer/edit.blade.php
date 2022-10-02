@extends('layouts.adminlayout')

@section('title','Edit Inventory Customer')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('assigncustomers.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="text-right">Edit Assign Customers</h5>
                </div>
            </div>
        </div>


        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
          <form action="{{route('assigncustomers.update',$assigncustomer->id)}}" method="POST">
              @method('PUT')
              @csrf
              <div class="form-group">
                <label for="from">From</label>
                <input type="text" class="form-control @error('from') is-invalid @enderror" name="from" id="from" placeholder="Select  Date" value="{{old('from',$assigncustomer->from)}}">
                    @error('from')
                    <small class="form-error">{{ $message }}</small>
                    @enderror
              </div>


              <div class="form-group">
                <label for="to">To</label>
                <input type="text" class="form-control @error('to') is-invalid @enderror" name="to" id="to" placeholder="Select  Date" value="{{old('to',$assigncustomer->to)}}">
                @error('to')
                <small class="form-error">{{ $message }}</small>
                @enderror
              </div>


              <div class="form-group">
                <label for="employee">employee</label>
                <select name="employee" id="employee" class="form-control @error('employee') is-invalid @enderror" >
                    <option value="">Select employee</option>

                    @foreach ($employees as $item)
                    <option value="{{$item->id}}"
                      @if($item->id == $assigncustomer->employee_id) selected @endif >{{$item->name}}</option>
                    @endforeach


                </select>
                @error('employee')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>



            <div class="form-group">
              <label for="assigned_customers">Assign Customer/Distributor</label>
              <select  data-placeholder="Select Some Customer" class="js-example-responsive" multiple="multiple" name="assigned_customers[]" id="assigned_customers" class="form-control @error('assigned_customers') is-invalid @enderror" >
                <option></option>
                @foreach ($customers as $customer)
              <option value="{{$customer->id}}" @if($assigncustomer->customers_arr != NULL) @foreach(unserialize($assigncustomer->customers_arr) as $single_customer) @if($single_customer == $customer->id) selected @endif  @endforeach @endif>{{$customer->name}}</option>
                @endforeach
              </select>
              @error('assigned_customers')
              <small class="form-error">{{ $message }}</small>
              @enderror
            </div>





            <input type="hidden" id="productinfo" name="productinfo" value="">

          <div class="form-group">
              <button onclick="reportSubmit()" type="submit" class="btn btn-success">Update</button>
          </div>

        </form>

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
