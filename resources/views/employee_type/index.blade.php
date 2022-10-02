@extends('layouts.adminlayout')

@section('title','Inventory Customer')
@section('content')
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <h5 class="card-title">Employee Type</h5>
        </div>
        <div class="col-lg-6 text-right">
          <a  href="{{route('emp_type.create')}}" class="btn btn-info btn-sm">+ Add New Employee Type</a>
        </div>

      </div>



    </div>
    <div class="card-body table-responsive">


      <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
         @foreach ($emp_types as $key => $item)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$item->name}}</td>
          <td><a class="btn btn-sm btn-primary" href="{{route('emp_type.edit',$item->id)}}"><i class="fas fa-edit"></i></a>
          {{-- <form style="display: inline-block" action="{{route('emp_type.destroy',$item->id)}}" method="POST">
              @csrf
              @method('DELETE')
              <button onclick="return confirm('Are you sure you want to delete this page?')" type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
            </form>
             --}}
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
