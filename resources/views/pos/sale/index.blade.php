@extends('layouts.adminlayout')
@section('title','Inventory Sales')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="card-title">Sales Invoices</h5>
                    </div>
                    <div class="col-lg-8">
                        @can('sales_invoice.create')
                        <a href="{{route('sale.create')}}" class="btn btn-info btn-sm float-right"><i class="fa fa-plus"></i> New Sales Invoice</a>
                        @endcan
                    </div>
                </div>

            </div>
            <div class="card-body">
                <form action="{{route('sale.result')}}" method="POST">
                    @csrf
                      <div class="row mb-3 justify-content-center">
                        <div class="col-lg-1">
                          <div class="form-group">
                            <strong>FROM : </strong>
                          </div>
                        </div>
                        <div class="col-lg-3">

                          <div class="form-group">
                            <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{Carbon\Carbon::now()->toDateString()}}">
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
                            <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{Carbon\Carbon::now()->toDateString()}}">
                            @error('end')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>


                        <div class="col-lg-2">
                          <div class="form-group">
                            <button type="submit" class="btn btn-info">filter</button>
                          </div>

                        </div>
                      </div>
                    </form>

                    <div class="row">
                      <div class="col-lg-12">
                        <h3 class="mt-3 mb-5 text-uppercase text-center">Last 10 Sales Activity</h3>
                        <table class="table">
                          <thead class="thead-light">
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">SID</th>
                              <th scope="col">Sales Date</th>
                              <th scope="col">Customer</th>
                              <th scope="col">Net Amount</th>
                              <th scope="col">Status</th>
                              <th scope="col">Booking</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @php
                                $count=0;
                              @endphp
                              @foreach ($sales as $key => $item)
                              @php
                                  $netamount = $item->amount;
                                  $discount = $item->amount*($item->discount_percent/100);
                              @endphp


                              <tr @if($item->sales_status == 2) style="background: #ff7979;color: #fff"  @endif>
                                <td  class="align-middle">{{$key+1}}</td>
                                <td class="align-middle">#{{$item->id}}</td>
                                <td class="align-middle">{{$item->sales_at->format('d-m-Y')}}</td>
                                <td class="align-middle">{{$item->user->name}}</td>
                              <td class="align-middle">{{round($item->amount)}}</td>



                              <td class="align-middle">{!!FashiSalesStatus($item->sales_status)!!}</td>
                              <td class="align-middle">{!!fuc_is_conditioned($item->is_condition)!!}</td>
                              @if($item->deleted_at == NULL)
                                <td >
                                    @can('sales_invoice.edit')
                                    <a class="btn btn-info btn-sm" target="_blank" href="{{route('sale.show',$item->id)}}"><i class="fa fa-eye"></i></a>   | <a target="_blank" class="btn btn-primary btn-sm" href="{{route('sale.edit',$item->id)}}"><i class="fa fa-edit"></i></a>
                                    @endcan
                                </td>
                              @else
                              <td class="align-middle"><small>By: {{App\Admin::where('id',$item->approved_by)->first()->name }} </small> <br><small>At {{$item->updated_at->format('d M Y g: i a')}}</small></td>
                              @endif

                              </tr>


                              @endforeach

                          </tbody>
                        </table>
                      </div>
                    </div>

            </div>
        </div>





    </div>
  </div>

@endsection

@push('css')
<link rel="stylesheet" href="{{asset('assets/css/flatpicker.min.css')}}">
@endpush

@push('js')
<script>
  sessionStorage.clear();
  $('#user').select2({
width: '100%',
  theme: "bootstrap"
});
</script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});
</script>

@endpush


