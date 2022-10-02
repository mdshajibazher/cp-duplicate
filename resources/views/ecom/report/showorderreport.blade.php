@extends('layouts.adminlayout')
@section('title','Eommerce Order Report')
@section('content')

  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
              Eommerce Order  Report
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="{{route('report.orderreportshow')}}" method="POST">
                    @csrf
                      <div class="row justify-content-center">

                        <div class="col-lg-3">
                          <div class="form-group">
                            <span>Start Date : </span>
                          </div>
                          <div class="form-group">
                          <input type="text" class="form-control @error('start') is-invalid @enderror" name="start" id="start" placeholder="Select Start Date" value="{{$request->start}}">
                                @error('start')
                                <small class="form-error">{{ $message }}</small>
                                @enderror
                          </div>
                        </div>

                        <div class="col-lg-3">
                          <div class="form-group">
                            <span>End Date : </span>
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control @error('end') is-invalid @enderror" name="end" id="end" placeholder="Select End Date" value="{{$request->end}}">
                            @error('end')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-2">
                          <div style="margin-top: 40px;">
                            <button type="submit" class="btn btn-info">submit</button>
                          </div>

                        </div>
                      </div>
                    </form>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="statement_table table-responsive">
                    <h4 style="text-align: center;text-transform: uppercase;padding: 30px 0;font-family:Sans-serif">Ecommerce Order Report</h4>
                    <h5 class="text-center mb-5">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</h5>

                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-sm">

                  <tr style="background: #ddd">
                    <td style="width: 200px" class="align-middle">Customer</td>
                    <td class="align-middle text-center">Amount</td>
                    <td class="align-middle text-center">Status</td>
                    <td class="align-middle">Product</td>
                  </tr>
                  @php
                    $ordersum = 0;
                  @endphp
                  @foreach ($orders as $item)
                  @php
                    $ordersum = $ordersum+$item->amount;
                  @endphp
                  <tr>
                    <td class="align-middle">
                        <table class="table table-borderless table-sm">
                          <tr>
                            <td>Name:</td>
                            <td>{{$item->user->name}}</td>
                          </tr>
                          <tr>
                            <td>Phone</td>
                            <td>{{$item->user->phone}}</td>
                          </tr>
                          <tr>
                            <td>Address</td>
                            <td><small>{{$item->user->address}}</small></td>
                          </tr>
                        </table>

                      </td>
                    <td class="align-middle text-center">{{round($item->amount)}}</td>
                    <td class="align-middle">
                      <table class="table table-sm table-borderless">
                        <tr>
                          <td>Order:</td>
                          <td>{!!FashiOrderStatus($item->order_status)!!}</td>
                        </tr>
                        <tr>
                          <td>Payment:</td>
                          <td>{!!FashiPaymentStatus($item->payment_status)!!}</td>
                        </tr>
                        @if($item->payment_status ==1)
                        <tr>
                          <td>Amount:</td>
                        <td>{{round($item->cash)}} <br><small> at ({{$item->paymented_at->format('d-M-Y')}}) </small></td>
                        </tr>
                        @endif

                        <tr>
                          <td>Delivery:</td>
                          <td>{!!FashiShippingStatus($item->shipping_status)!!} @if($item->shipping_status == 1) <br><small> at ({{$item->shipped_at}} ref:{{$item->references}} ) </small> @endif</td>
                        </tr>

                      </table>
                    </td>
                    <td class="align-middle">
                      @php
                      $pdsum = 0;
                      @endphp
                      @if(count($item->product) > 0)
                      <div style="border-bottom: 1px solid #aaa;padding-bottom: 15px;">
                      @foreach ($item->product as $pd)

                      @php
                      $pd_price = $pd->pivot->price;
                      $pd_qty = $pd->pivot->qty;
                      $pd_subtotal = $pd_price*$pd_qty;
                      $pdsum = $pdsum+$pd_subtotal;

                      @endphp

                        <small>{{Str::limit($pd->product_name,12)}} ({{$pd_qty}} x {{$pd_price}}) = {{ $pd_subtotal}} </small> <br>


                      @endforeach
                    </div>


                    <small>Subtotal : {{ $pdsum}}</small>,
                    <small>Discount: {{$pdsum*$item->discount/100}}</small>,
                    <small>shipping : {{$item->shipping}} </small><br>
                    @if($item->vat != 0 && $item->tax != 0)
                    <small>VAT : {{$pdsum*(($item->vat+$item->tax)/100)}} </small><br>
                    @endif
                    <small>Grand Total : <span class="badge badge-success">{{$item->amount}} </span> </small><br>
                    @else
                      <small>not applicable</small>
                    @endif

                    </td>
                  </tr>
                  @endforeach






                </table>

              </div>
                <div class="row justify-content-center">
                  <div class="col-lg-4">
                    <table class="table table-bordered table-striped">
                      <tr>
                        <td>Total Orders</td>
                      <td>{{round($ordersum)}}</td>
                      </tr>
                      <tr>
                        <td>Action</td>
                        <td>
                        <form action="{{route('report.orderreportpdf')}}" method="POST">
                            @csrf
                              <input type="hidden" name="end" value="{{$request->end}}">
                              <input type="hidden" name="start" value="{{$request->start}}">
                              <button type="submit" class="btn btn-success">Download PDF</button>
                          </form>

                      </tr>
                  </table>
                  </div>
                </div>


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
  $('#division').select2({
width: '100%',
  theme: "bootstrap"
});
</script>
<script src="{{asset('assets/js/flatpicker.min.js')}}"></script>
<script src="{{asset('assets/js/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>


<script>
  $("#start").flatpickr({dateFormat: 'Y-m-d'});
  $("#end").flatpickr({dateFormat: 'Y-m-d'});

  $('#order_table').DataTable({});
  $('#cash_table').DataTable({});
</script>

@endpush


