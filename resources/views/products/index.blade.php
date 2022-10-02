
@extends('layouts.adminlayout')
@section('title','Product')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-4">
          <h5 class="card-title text-left">PRODUCTS</h5>
        </div>
        <div class="col-lg-8">
        <form action="{{route('product.export')}}" style="display: inline;float:right;margin: 0 5px;" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">Export Price List</button>
          </form>
        <a href="{{route('products.create')}}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus">ADD NEW</i></a>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered  table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th>Sl</th>
            <th>Name</th>
            <th>Image</th>
            <th>Trade Price</th>
            <th>Size</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>


        </tbody>
      </table>

    </div>
  </div>
</div>
</div>


@endsection
@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush

@push('js')

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

<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    function showOrderData(orderData){
        console.log(orderData);
    }
    $(function() {
        $('#jq_datatables').DataTable({
            "order": [[ 1, 'asc' ]],
            searchDelay: 1200,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: '{!! route('products.index') !!}',
            columns: [
                {data:'DT_RowIndex',name:'DT_RowIndex',orderable: false, searchable: false},
                { data: 'product_name', name: 'product_name' },
                { data: 'image', name: 'image',orderable: false, searchable: false },
                { data: 'tp', name: 'tp' },
                { data: 'size.name', name: 'size',orderable: false, searchable: false },
                {data:'action',name:'action',orderable:false, searchable:false},
            ]
        });
    });


</script>

@endpush
