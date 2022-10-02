
@extends('layouts.adminlayout')
@section('title','Raw Materials')

@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-4">
          <h5 class="card-title text-left">Raw Materials</h5>
        </div>
        <div class="col-lg-8">

        <a href="{{route('raw.create')}}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus">ADD NEW</i></a>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered  table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Purchase Price</th>
            <th>Type</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

        @foreach ($rawmaterials as $key => $raw)

            <tr @if($raw->type == 'ecom') style="background: #f7f1e3" @endif>
            <td>{{$key+1}}</td>
                <td style="width: 180px;">{{$raw->product_name}}</td>
                <td>{{$raw->price}}</td>
                <td>{!!showProductTypes($raw->type)!!}</td>

            <td>
            <a href="{{route('raw.edit',$raw->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>

              <a class="btn btn-info btn-sm"  href="{{route('raw.show',$raw['id'])}}"><i class="fas fa-eye"></i></a>

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
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush

@push('js')





<script>
function deleteProduct(id){
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
</script>


<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$('#jq_datatables').DataTable();
</script>

@endpush
