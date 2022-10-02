@extends('layouts.adminlayout')

@section('title','Inventory Customer')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
          <h5 class="card-title">Price Request</h5>
    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Product</th>
            <th scope="col">Purpose</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>

          @foreach ($priceRequests as $key =>  $p_req)
            <tr>
            <td>{{$key+1}}</td>
              <td>{{$p_req->created_at->format('d-m-Y g:i a')}}</td>
              <td>{{$p_req->cust_name}}</td>
              <td>{{$p_req->cust_phone}}</td>
              <td>{{$p_req->product->product_name}}</td>
              <td>
                @if($p_req->purpose == 'wholesale')
                <span class="badge badge-danger">{{$p_req->purpose}}</span>
                @else
                <span class="badge badge-success">{{$p_req->purpose}}</span>
                @endif
              </td>

            <td>
              @if($p_req->status == false)
                <form action="{{route('pricerequestmanage.done',$p_req->id)}}" method="POST">
                  @csrf
                  <button type="submit" onclick="return confirm('Are you sure to mark this as done?')" class="btn btn-warning btn-sm"><i class="fas fa-check"></i></button>
                </form>

              @else
                <span class="badge badge-success">done</span>
              @endif
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
