@extends('layouts.adminlayout')
@section('title','SMS Logs')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-left">SMS Logs</h5>
                </div>
                <div class="card-body table-responsive">


                    <table class="table table-bordered  table-hover mt-3" id="jq_datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Text</th>
                            <th>Phone</th>
                            <th>Status Code</th>
                            <th>Created At</th>
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
        $(function () {
            $('#jq_datatables').DataTable({
                "order": [[0, 'desc']],
                searchDelay: 1200,
                processing: true,
                serverSide: true,
                searching: true,
                ajax: '{!! route('sms_logs.index') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'text', name: 'text'},
                    {data: 'phones', name: 'phones'},
                    {data: 'status_code', name: 'status_code', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at',},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });


    </script>

@endpush
