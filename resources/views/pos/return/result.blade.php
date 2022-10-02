@extends('layouts.adminlayout')
@section('title','Inventory Returns Result')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-4">
                    <h5 class="card-title">Inventory Return Result</h5>
                </div>
                <div class="col-lg-8">
                    <a href="{{route('returnproduct.create')}}" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New Return Invoice </a>
                </div>
            </div>
            </div>
            <div class="card-body">

              <form action="" method="POST">
                @csrf
                  <div class="row mb-3 justify-content-center">
                    <div class="col-lg-1">
                      <div class="form-group">
                        <strong>FROM : </strong>
                      </div>
                    </div>
                    <div class="col-lg-3">

                      <div class="form-group">
                        <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{$request->start}}">
                            @error('start')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                      </div>
                    </div>
                    <div class="col-lg-1">
                      <div class="form-group">
                        <strong>To : </strong>
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-group">
                        <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{$request->end}}">
                        @error('end')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                      </div>
                    </div>


                    <div class="col-lg-2">
                      <div class="form-group">
                        <button type="submit" class="btn btn-info">Filter</button>
                      </div>

                    </div>
                  </div>
                </form>


              <table class="table" id="jq_datatables">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">SID</th>
                    <th scope="col">Returned At</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Net Amount</th>
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


                    <tr @if($item->deleted_at != NULL) style="background: #ff7979;color: #fff"  @endif>
                      <td scope="row"></td>
                      <td>#{{$item->id}}</td>
                      <td>{{$item->returned_at->format('d-m-Y g:i a')}}</td>
                      <td>{{$item->user->name}}</td>
                      <td>{{round($item->amount)}}</td>
                      <td>{!!InvReturnStatus($item->return_status)!!}</td>

                    @if($item->deleted_at == NULL)
                      <td ><a target="_blank" class="btn btn-info btn-sm" href="{{route('returnproduct.show',$item->id)}}"><i class="fa fa-eye"></i></a> | <a target="_blank" class="btn btn-primary btn-sm" href="{{route('returnproduct.edit',$item->id)}}"><i class="fa fa-edit"></i></a> |

                      </td>
                    @else
                    <td><small>By: {{App\Admin::where('id',$item->approved_by)->first()->name }} </small> <br><small>At {{$item->updated_at->format('d M Y g: i a')}}</small></td>
                    @endif

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
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
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
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$("#start").flatpickr({dateFormat: 'Y-m-d'});
$("#end").flatpickr({dateFormat: 'Y-m-d'});

$('#jq_datatables').DataTable({
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
    },
});


</script>

@endpush


