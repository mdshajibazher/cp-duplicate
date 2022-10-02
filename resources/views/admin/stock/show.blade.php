@extends('layouts.adminlayout')

@section('title','Stock Report')

@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-6">
                  <a href="{{route('stockreport.report')}}" class="btn btn-info btn-sm">back</a>
                </div>
                <div class="col-lg-6">
                  <p class="text-right">Stock Report FROM {{$request->start}} TO {{$request->end}}</p>
                </div>
              </div>

            </div>
            <div class="card-body">

              <form action="{{route('stockreport.show')}}" method="POST">
                @csrf
                  <div class="row justify-content-center">
                    <div class="col-lg-2">
                      <div class="form-group">
                        <span>Start Date : </span>
                      </div>
                    </div>
                    <div class="col-lg-3">

                      <div class="form-group">
                        <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{$request['start']}}">
                            @error('start')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <span>End Date : </span>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                      <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" value="{{$request['end']}}" placeholder="Select End Date">
                        @error('end')
                        <small class="form-error">{{ $message }}</small>
                        @enderror
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div>
                        <button type="submit" class="btn btn-info">submit</button>
                      </div>

                    </div>
                  </div>
                </form>

              <table class="table table-striped" id="jq_datatables">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product_name</th>
                    <th scope="col">Prev Qty</th>
                    <th scope="col">Purchase Qty</th>
                    <th scope="col">Return Qty</th>
                    <th scope="col">Ecom Qty</th>
                    <th scope="col">Sale Qty</th>
                    <th scope="col">Damage Qty</th>
                    <th scope="col">Free Qty</th>
                    <th scope="col">Adjust Qty</th>
                    <th scope="col">Current Stock</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i=1;
                  @endphp
                  @foreach ($stock as $item)
                  <tr>
                  <td scope="row">{{$i++}}</td>
                    <td>{{$item['product_name']}}</td>
                    <td>{{$item['prev_qty']}}</td>
                    <td>{{$item['purchase_qty']}}</td>
                    <td>{{$item['return_qty']}}</td>
                    <td>{{$item['order_qty']}}</td>
                    <td>{{$item['sell_qty']}}</td>
                    <td>{{$item['damage_qty']}}</td>
                    <td>{{$item['free_qty']}}</td>
                    <td>{{$item['adjust_qty']}}</td>
                    <td>{{$item['current_stock']}}</td>
                  </tr>
                  @endforeach


                </tbody>
              </table>
              <div class="mt-5 float-right">
                <form action="{{route('stockreport.pdf')}}" method="POST">
                  @csrf
                    <input type="hidden" name="start" value="{{$request->start}}">
                    <input type="hidden" name="end" value="{{$request->end}}">
                    <button type="submit" class="btn btn-danger">Export As Pdf</button>
                </form>
              </div>


            </div>
        </div>





    </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endpush

@push('js')
<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>

<script>
$("#start").flatpickr({dateFormat: 'Y-m-d'});
$("#end").flatpickr({dateFormat: 'Y-m-d'});
$('#jq_datatables').DataTable();
</script>

@endpush


