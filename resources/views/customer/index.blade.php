@extends('layouts.adminlayout')

@section('title','Inventory Customer')
@section('content')
    @php
        function getSMSAlertStatus($status){
            if($status){
                return '<small class="badge badge-success">enabled</small>';
            }else{
                 return '<small class="badge badge-danger">disabled</small>';
            }
        }
    @endphp
<div class="row">
<div class="col-lg-12">
	<div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-6">
          <h5 class="card-title">MPO  Customer </h5>
        </div>
        <div class="col-lg-6 text-right">
        <form action="{{route('user.export')}}" method="POST" style="display: inline">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">Export</button>
        </form>
            @can('mpo_customers.create')
            <a  href="{{Request::is('admin/pos/customers') ? route('customers.create') : route('pharmacy_customers.create')}}" class="btn btn-info btn-sm">+ Add New Customer</a>
            @endcan
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
            <th scope="col">SMS Alert</th>
              @if(Request::is('admin/pos/customers'))
              @can('Customer Login Control')
            <th scope="col">Login access</th>
              @endcan
              @endif
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
              <td>{!!getSMSAlertStatus($customer->sms_alert)!!}</td>
                @if(Request::is('admin/pos/customers'))
                @can('Customer Login Control')
                <td>
                    @if($customer->login_access)
                        <p class="badge badge-success">enabled</p>
                        @else
                        <form action="{{route('customer.login.access')}}" method="post" id="login-approval-form" onsubmit="confirmBeforeSubmit(event,{{$customer->id}})">
                            @csrf
                            <input type="hidden" name="id" value="{{$customer->id}}" />
                        <button id="submit-button-{{$customer->id}}" type="submit" class="btn btn-warning" >Enable Login</button>
                        </form>
                    @endif
                </td>
            @endcan
                @endif
            <td style="width: 100px;">
                @can('mpo_customers.edit')
            <a href="{{Request::is('admin/pos/customers') ? route('customers.edit',$customer['id']) :  route('pharmacy_customers.edit',$customer['id'])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                @endcan

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
    function confirmBeforeSubmit(event,id){
        let get_confirmation = confirm('Are you sure?')
        if(get_confirmation){
                $("#submit-button-"+id).html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
        }else{
            event.preventDefault();
        }

    }
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
