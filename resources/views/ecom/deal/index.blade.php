@extends('layouts.adminlayout')
@section('title','Product Deals')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <h5 class="card-title">Ecom Deal </h5>
        </div>
        <div class="col-lg-6 text-right">
          <a  href="{{route('deals.create')}}" class="btn btn-info btn-sm">+ Add New Deal</a>
        </div>

      </div>



    </div>
    <div class="card-body table-responsive">

      @if($deal == null)
      <div class="row">
        <div class="col-lg-12">
          <span class="alert alert-danger text-center">No Deal Found</span>
        </div>
      </div>

    @else
      <table class="table table-bordered  table-hover mt-3">



          <tr>
            <th>Deal Title</th>
             <td>{{$deal->title}}</td>
          </tr>
          <tr>
            <th>Deal Description</th>
             <td>{{$deal->description}}</td>
          </tr>
          <tr>
            <th>Deal Product</th>
             <td>{{$deal->dealproduct->product_name}}</td>
          </tr>
          <tr>
            <th>Deal Amount</th>
             <td>{{$deal->amount}}</td>
          </tr>
          <tr>
            <th>Deal Expires At</th>
             <td>{{$deal->expired_at}}</td>
          </tr>
          <tr>
            <th>Action</th>
          <td><a href="{{route('deals.edit',$deal->id)}}" class="btn btn-link">Edit Deal</a></td>
          </tr>

      </table>
      @endif

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


  $('#jq_datatables').DataTable();
</script>
@endpush
