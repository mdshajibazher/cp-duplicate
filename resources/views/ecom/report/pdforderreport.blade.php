<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="ASOjne3KXoYfj3Bf24x8FUsRK920YOgbS7CcIRxa">

    <title>Order Report</title>

    <!-- Bootstrap css -->
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet"/>
    <style>
      .table-bordered td, .table-bordered th{
        border: 1px solid #000;
      }
      .table thead th{
        border: 1px solid #000;
      }
    </style>

</head>
<body style="background: #fff;font-size: 12px;">
              <div style="width: 50%;margin: 0 auto">
                <h5 style="text-align: center;font-family: Tahoma,sans-serif">Ecommerce Order Report</h5>
                      <h6 class="text-center">{{$CompanyInfo->company_name}}</h6>
                      <p style="text-align: center;font-size: 11px">{{$CompanyInfo->address}} <br> <b>Email :</b>  {{$CompanyInfo->email}} <br> <b>Phone:</b>  {{$CompanyInfo->phone}}</p>
              </div>





                  <div class="statement_table">
                    <p style="text-align: center;margin-bottom: 10px;font-weight: bold">From {{date("d-M-Y", strtotime($request->start) )}} To {{date("d-M-Y", strtotime($request->end) )}}</p>
                    <table class="table table-sm">

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
                        <td class="align-middle text-center"><b>{{round($item->amount)}}</b></td>
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












</body>
</html>

















