@extends('layouts.adminlayout')
@section('title','Purchase History')

@section('content')

  <div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
              <div class="row">


                <div class="col-lg-2">
                  <a href="{{route('stock.index')}}" class="btn btn-info btn-sm"><i class="fa fa-angle-left"></i> Back</a>
                </div>
                <div class="col-lg-10">
                  <h5 class="text-right"> ( {{$product->product_name}} ) -  PURCHASE HISTORY </h5>
                </div>
              </div>
            </div>
            <div class="card-body">


              <table class="table" id="jq_datatables">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"># </th>
                    <th scope="col">Date </th>
                    <th scope="col">Purchase ID</th>
                    <th scope="col">Product Name </th>
                    <th scope="col">Supplier </th>
                    <th scope="col">Qty</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                      $i=1;
                      $sum = 0;
                  @endphp
                  @foreach ($purchase_history as $item)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{Carbon\Carbon::parse($item->purchased_at)->format('d-m-y')}}</td>
                      <td>#{{$item->id}}</td>
                        <td>{{$item->product_name}}</td>

                        <td>{{$item->name}}</td>
                        <td><b>{{$item->qty}}</b></td>
                    </tr>

                    @php
                      $sum += $item->qty;
                    @endphp
                  @endforeach
                </tbody>
              </table>
              <div class="links float-right">
                  <b>Total Purchase Qty : {{$sum}}</b>
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

<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
$('#jq_datatables').DataTable();
</script>
@endpush


