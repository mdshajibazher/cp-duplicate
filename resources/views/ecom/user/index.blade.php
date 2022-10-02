@extends('layouts.adminlayout')

@section('title','Inventory Customer')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <h5 class="card-title">Ecommerce Customer </h5>
        </div>
        <div class="col-lg-6">
        <a href="{{route('ecomcustomer.create')}}" class="btn btn-info btn-sm float-right">Add New</a>
        </div>


      </div>



    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Section</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($customers as $key =>  $customer)
            <tr>
            <td>{{$key+1}}</td>
              <td>{{$customer->name}}</td>
              <td>{{$customer->phone}}</td>
              <td>{{$customer->address}}</td>
              <td>{!!CustomerSection($customer->section->name)!!}</td>
            <td><a class="btn btn-sm btn-warning" href="{{route('ecomcustomer.edit',$customer->id)}}"><i class="fas fa-edit"></i> Edit</a></td>


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
  <!-- Spectrum Css -->
  <link href="{{asset('assets/css/spectrum.min.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush


@push('js')
<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Success Alert After Product  Delete -->
@if(Session::has('success'))
<script>
Swal.fire({
  icon: 'success',
  title: '{{Session::get('success')}}',
  showConfirmButton: false,
  timer: 1500
})
</script>
@endif



<script>
  $('#jq_datatables').DataTable();
</script>
@endpush
