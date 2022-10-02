@extends('layouts.adminlayout')
@section('title','Orders')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('order.create')}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Create New  Order</a>
            </div>
            <div class="card-body">

              <div class="table-responsive">
              <table class="table" id="jq_datatables">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th style="width: 150px" scope="col">Date</th>
                    <th scope="col">OID</th>
                    <th scope="col">Customers</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Shipping Status</th>
                    <th style="width: 150px" scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $item)
                  <tr @if($item->order_status == 2) style="background: #f8a5c2" @endif>
                    <td></td>

                  <td style="width: 150px">{{\Carbon\Carbon::parse($item->ordered_at)->format('d-m-Y')}}</td>
                  <td>{{$item->id}}</td>
                  <td>{{$item->user->name}}</td>
                  <td>{{round($item->amount)}}</td>
                  <td>{!! FashiOrderStatus($item->order_status) !!}</td>
                  <td>{!! FashiPaymentStatus($item->payment_status) !!}</td>
                  <td>{!! FashiShippingStatus($item->shipping_status) !!}</td>
                  <td>
                    @if($item->order_status == 2) <span class="badge badge-danger">No Action Found</span>

                    @else
                     <a class="btn btn-primary btn-sm" href="{{route('order.edit',$item->id)}}"><i class="fa fa-edit"></i></a> | <a class="btn btn-info btn-sm" href="{{route('order.show',$item->id)}}"><i class="fa fa-eye"></i></a>
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
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">


@endpush

@push('js')

<script>
  sessionStorage.clear();
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
  confirmButtonText: 'Yes, Cancel it!'
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
$('#jq_datatables').DataTable({
  "order": [ [2, 'desc'] ],
  "columnDefs": [
        { "targets": [4,5,6,7,8], "searchable": false }
    ],
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
               return nRow;
    },
});

</script>
@endpush


