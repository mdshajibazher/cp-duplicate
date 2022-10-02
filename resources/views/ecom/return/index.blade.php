@extends('layouts.adminlayout')
@section('title','Returns')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('return.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="card-body">


              <table class="table" id="jq_datatables">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">RID</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Net Amount</th>
                    <th scope="col">Returned At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                      $count=0;
                    @endphp
                    @foreach ($returns as $key => $item)
                    @php
                        $netamount = $item->amount;
                        $discount = $item->amount*($item->discount_percent/100);
                    @endphp

                    @if($item->deleted_at == NULL)
                    <tr>
                      <td scope="row"></td>
                      <td>#{{$item->id}}</td>
                      <td>{{$item->user->name}}</td>
                    <td>{{$item->amount}}</td>
                      <td>{{$item->returned_at->format('d-M-Y g:i a')}}</td>


                      <td>
                        <span class="badge badge-success">
                          Returned
                        </span>
                       </td>
                      <td ><a class="btn btn-info btn-sm" href="{{route('return.show',$item->id)}}"><i class="fa fa-eye"></i></a> | <a class="btn btn-primary btn-sm" href="{{route('return.edit',$item->id)}}"><i class="fa fa-edit"></i></a> |
                        <form id="delete-from-{{$item['id']}}" style="display: inline-block" action="{{route('return.destroy',$item->id)}}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="button" onclick="deleteItem({{$item['id']}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></button>
                        </form>
                      </td>

                    </tr>

                    @else
                    <tr class="bg-danger" style="color: #fff">
                      <td scope="row"></td>
                      <td>#{{$item->id}}</td>
                      <td>{{$item->user->name}}</td>
                      <td>{{$item->amount}}</td>
                      <td>{{$item->updated_at->format('d-M-Y g:i a')}}</td>
                      <td>
                        <span class="badge badge-warning">
                          Cancelled
                        </span>
                       </td>
                      <td>No Action</td>

                    </tr>

                    @endif

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
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
               return nRow;
    },
});

</script>

@endpush


