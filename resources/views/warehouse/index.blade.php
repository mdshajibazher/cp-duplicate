@extends('layouts.adminlayout')

@section('title','Warehouses')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="card-title">Warehouses</h5>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{route('warehouse.create')}}" class="btn btn-info btn-sm">+ Add New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped table-hover mt-3" id="jq_datatables">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">In charge</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($warehouses as $key =>  $warehouse)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$warehouse->name}}</td>
                                <td>{{$warehouse->in_charge}}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="{{route('warehouse.edit',$warehouse->id)}}"><i
                                            class="fas fa-edit"></i></a>
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
    <link href="{{asset('assets/css/spectrum.min.css')}}" rel="stylesheet"/>
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

        function deleteItem(id) {
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
                    document.getElementById('delete-from-' + id).submit();
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
