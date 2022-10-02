@extends('layouts.adminlayout')
@section('title','Product Deals')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
          <h5 class="card-title">Comments</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover table-striped">
            <tr>
                <td>#</td>
                <td>Product</td>
                <td>User Name</td>
                <td>Email</td>
                <td>Comments</td>
                <td>Action</td>
            </tr>
            @foreach ($comments as $key => $item)
            <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->product->product_name}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td><small> {{Str::limit($item->comments,40)}}</small></td>
            <td>
                @if($item->status == 1)
                    <span class="badge badge-success">approved</span>
                @else

                <form action="{{route('comments.approve',$item->id)}}" method="post" style="display: inline-block">
                @csrf
                <button onclick="return confirm('Are Tou Sure You want to confirm Comment')" type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
            </form>
            | <form action="{{route('comments.destroy',$item->id)}}" method="post" style="display: inline-block">
                @csrf
            <button onclick="return confirm('Are Tou Sure You want to Cancel Comment')"   type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
        </form>
        @endif
        </td>
            </tr>
            @endforeach

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
