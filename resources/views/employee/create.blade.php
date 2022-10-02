
@extends('layouts.adminlayout')
@section('title','Create Inventory Customer')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                <a class="btn btn-info btn-sm" href="{{route('employee.index')}}"><i class="fa fa-angle-left"></i> back</a>
                </div>
                <div class="col-lg-8">
                    <h5 class="card-title float-right">Add New Employee</h5>
                </div>
            </div>
        </div>
    <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-lg-6">
    <form action="{{route('employee.store')}}" method="POST" style="border: 1px solid #ddd;padding: 20px;border-radius: 5px">
        @csrf
        <div class="row">

        <div class="col-lg-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <div class="form-group">
                <label for="name">Employee Name<span>*</span></label>
            <input type="text" id="name" placeholder="Enter Employee name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>

                @error('name')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email<span>*</span></label>
            <input type="text" id="email" placeholder="Enter Employee email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" required>

                @error('email')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label for="phone">Phone<span>*</span></label>
            <input type="text" id="phone" placeholder="Enter Employee phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" required>

                @error('phone')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

               <div class="form-group">
                <label for="address">Address<span>*</span></label>
            <textarea   rows="8" id="address" placeholder="Enter Employee address" class="form-control @error('address') is-invalid @enderror" name="address" required>{{old('address')}}</textarea>

                @error('address')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="joining_date">Joining Date<span>*</span></label>
            <input type="text" id="joining_date" placeholder="Enter Employee joining_date" class="form-control @error('joining_date') is-invalid @enderror" name="joining_date" value="{{old('joining_date')}}" required>

                @error('joining_date')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>




            <div class="form-group">
                <label for="salary">Salary<span>*</span></label>
            <input type="text" id="salary" placeholder="Enter Employee salary" class="form-control @error('salary') is-invalid @enderror" name="salary" value="{{old('salary')}}" required>

                @error('salary')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label for="nid">NID Number</label>
            <input type="text" id="nid" placeholder="Enter Employee nid" class="form-control @error('nid') is-invalid @enderror" name="nid" value="{{old('nid')}}">

                @error('nid')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>







            <div class="form-group">
                <label for="employee_type_id">Employee Type</label>

            <select id="employee_type_id" class="form-control @error('employee_type_id') is-invalid @enderror" name="employee_type_id" required>
            <option value="">-select employee type-</option>
            @foreach ($emp_types as $item)

            <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
            </select>

                @error('employee_type_id')
                <small class="form-error">{{ $message }}</small>
                @enderror
            </div>


            <div class="form-group">
                <label for="assigned_customers">Assign Customer/Distributor</label>
                <select  data-placeholder="Select Some Customer" class="js-example-responsive" multiple="multiple" name="assigned_customers[]" id="assigned_customers" class="form-control @error('assigned_customers') is-invalid @enderror" >
                  <option></option>
                  @foreach ($customers as $customer)
                <option value="{{$customer->id}}" @if(old('assigned_customers') != null) @foreach(old('assigned_customers') as $single_customer) @if($single_customer == $customer->id) selected @endif  @endforeach @endif>{{$customer->name}}</option>
                  @endforeach
                </select>
                @error('assigned_customers')
                <small class="form-error">{{ $message }}</small>
                @enderror
              </div>





        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <button type="submit" class="btn btn-success">Create</button>
            </div>
        </div>

    </div>
</form>
</div>
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
  $("#joining_date").flatpickr({dateFormat: 'Y-m-d', allowInput: true});
  $('#assigned_customers').select2({
      width: '100%',
      closeOnSelect: false,
      theme: "bootstrap",templateSelection: function (data, container) {
    $(container).css("background-color", "#4cd137");
    $(container).css("color", "#ffffff");
    return data.text;
}
});
</script>

@endpush

